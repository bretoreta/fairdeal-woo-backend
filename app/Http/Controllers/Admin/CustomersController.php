<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customers\StoreRequest;
use App\Models\Code;
use App\Models\Showroom;
use App\Models\User;
use App\Notifications\AccountCreatedNotification;
use App\Notifications\CodeGeneratedNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        $customers = User::role('user')->with('showroom')->when($request->has('search'), function($query) use ($request) {
            return $query->where(function ($q) use ($request) {
                $q->where('name', 'like',  '%'. strtolower($request->query('search')) .'%')
                    ->orWhere('email', 'like',  '%'. strtolower($request->query('search')) .'%');
            });
        })->paginate();

        return Inertia::render('Admin/Customers/Index', [
            'customers' => $customers,
            'search' => $request->query('search'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Customers/Create', [
            'showrooms' => Showroom::all(['id', 'name']),
        ]);
    }

    public function show(User $user)
    {
        return Inertia::render('Admin/Customers/Show', [
            'customer' => $user->load('codes'),
        ]);
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
            $user->assignRole('user');

            $token = $this->generateCode();

            // Save the code to Database
            Code::create([
                'user_id' => $user->id,
                'token' => $token,
                'campaign' => 'Full House Sale',
            ]);

            //Commit changes to database
            DB::commit();

            // Send notifications to user with the credentials
            $user->notify(new AccountCreatedNotification($password, $user->email));
            $user->notify(new CodeGeneratedNotification($token));

            return redirect(route('admin.customers.index'))->with('message', [
                'type' => 'success',
                'message' => 'Customer Has Been Created Successfully'
            ]);
        } catch (\Error $error) {
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

            return redirect(route('admin.customers.index'))->with('message', [
                'type' => 'success',
                'message' => 'Customer Has Been Updated Successfully'
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
                'message' => 'Customer Has Been Updated Successfully'
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
                'message' => 'Customer Has Been Updated Successfully'
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
                'message' => 'Customer Has Been Updated Successfully'
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
                'message' => 'Customer Has Been Updated Successfully'
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
                'message' => 'Customer Has Been Updated Successfully'
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
                'message' => 'Customer Has Been Updated Successfully'
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
            $user->codes()->delete();
            $user->delete();

            return redirect(route('admin.customers.index'))->with('message', [
                'type' => 'success',
                'message' => 'Customer Has Been Deleted Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    private function generateCode() {
        return $token = "FFL-". Str::random(8). "-" . now()->format('Y');
    }
}
