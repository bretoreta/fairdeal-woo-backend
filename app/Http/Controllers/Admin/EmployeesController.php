<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employees\StoreRequest;
use App\Models\Showroom;
use App\Models\User;
use App\Notifications\AccountCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $employees = User::role('employee')->with('showroom:id,name,location')->when($request->has('search'), function($query) use ($request) {
            return $query->where(function ($q) use ($request) {
                $q->where('name', 'like',  '%'. strtolower($request->query('search')) .'%')
                    ->orWhere('email', 'like',  '%'. strtolower($request->query('search')) .'%');
            });
        })->paginate();

        return Inertia::render('Admin/Employees/Index', [
            'employees' => $employees,
            'search' => $request->query('search'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Employees/Create');
    }

    public function show(User $user)
    {
        return Inertia::render('Admin/Employees/Show');
    }

    public function store(StoreRequest $request)
    {
        try {
            // Get Validated Data Only
            $data = $request->validated();
            $password = Str::random();

            // Begin Database Transaction
            DB::beginTransaction();
            // Create a user to the database
            $user = User::create([
                'name' => $data['name'],
                'username' => strtolower(explode(' ', $data['name'])[0] ?? 'demouser'.uniqid()),
                'showroom_id' => $data['selectedShowroom']['id'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($password),
            ]);

            // Assign role: User
            $user->assignRole('employee');

            //Commit changes to database
            DB::commit();

            // Send notifications to user with the credentials
            $user->notify(new AccountCreatedNotification($password, $user->email));

            return redirect(route('admin.employees.index'))->with('message', [
                'type' => 'success',
                'message' => 'Employee Has Been Added Successfully'
            ]);

        } catch (\Error $error) {
            Log::error('Failed to register user from API call');
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignoreModel($user)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignoreModel($user)],
            'phone' => ['required', 'string', 'regex:^07\d\d\d\d\d\d\d\d$^', 'max:10', Rule::unique('users')->ignoreModel($user)],
        ]);

        try {
            $user->update($validator->valid());

            return redirect(route('admin.employees.index'))->with('message', [
                'type' => 'success',
                'message' => 'Employee Has Been Updated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function activate(User $user)
    {
        try {
            $user->forceFill(['status' => 'active']);
            $user->save();

            return back()->with('message', [
                'type' => 'success',
                'message' => 'Employee Has Been Updated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function deactivate(User $user)
    {
        try {
            $user->forceFill(['status' => 'pending']);
            $user->save();

            return back()->with('message', [
                'type' => 'success',
                'message' => 'Employee Has Been Updated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function verify(User $user)
    {
        try {
            $user->forceFill(['email_verified_at' => now()]);
            $user->save();

            return back()->with('message', [
                'type' => 'success',
                'message' => 'Employee Has Been Updated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function unverify(User $user)
    {
        try {
            $user->forceFill(['email_verified_at' => null]);
            $user->save();

            return back()->with('message', [
                'type' => 'success',
                'message' => 'Employee Has Been Updated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function block(User $user)
    {
        try {
            $user->forceFill(['status' => 'closed']);
            $user->save();

            return back()->with('message', [
                'type' => 'success',
                'message' => 'Employee Has Been Updated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function unblock(User $user)
    {
        try {
            $user->forceFill(['status' => 'active']);
            $user->save();

            return back()->with('message', [
                'type' => 'success',
                'message' => 'Employee Has Been Updated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function delete(User $user)
    {
        try {
            $user->delete();

            return redirect(route('admin.employees.index'))->with('message', [
                'type' => 'success',
                'message' => 'Employee Has Been Deleted Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }
}
