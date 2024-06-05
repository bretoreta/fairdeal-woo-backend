<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employees\Sales\StoreRequest;
use App\Models\Image;
use App\Models\Showroom;
use App\Models\User;
use App\Notifications\Sales\AccountCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SalesPersonController extends Controller
{
    public function index(Request $request)
    {
        $salespersons = User::role('salesperson')->where('showroom_id', $request->user()->showroom_id)->with('showroom:id,name,location')->when($request->has('search'), function($query) use ($request) {
            return $query->where(function ($q) use ($request) {
                $q->where('name', 'like',  '%'. strtolower($request->query('search')) .'%')
                    ->orWhere('email', 'like',  '%'. strtolower($request->query('search')) .'%');
            });
        })->paginate();

        return Inertia::render('Employees/Sales/Index', [
            'salespersons' => $salespersons,
            'search' => $request->query('search'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Employees/Sales/Create', [
            'showrooms' => Showroom::all(['id', 'name']),
        ]);
    }

    public function show(User $user)
    {
        return Inertia::render('Employees/Sales/Show', [
            'salesperson' => $user->load(['showroom', 'clicks' => function($q) {
                $q->limit(4);
            }]),
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
                'username' => Str::slug($data['name']),
                'showroom_id' => $data['selectedShowroom']['id'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($password),
            ]);

            // Assign role: User
            $user->assignRole('salesperson');

            Image::where('uuid', $request->image_uuid)->update([
                'model_id' => $user->id,
                'model_type' => User::class
            ]);

            //Commit changes to database
            DB::commit();

            // Send notifications to salesperson with the credentials and link
            $user->notify(new AccountCreatedNotification($password, $user->email, route('web.sales.profile.show', [$user->username])));

            return redirect(route('employees.salesperson.index'))->with('message', [
                'type' => 'success',
                'message' => 'Sales Person Has Been Added Successfully'
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
            'phone' => ['required', 'string', 'regex:^07\d\d\d\d\d\d\d\d$^', 'max:10'],
        ]);

        try {
            $user->update($validator->valid());

            return redirect(route('employees.salesperson.index'))->with('message', [
                'type' => 'success',
                'message' => 'Sales Person Has Been Updated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function leaderboard(Request $request)
    {
        return Inertia::render('Employees/Sales/Leaderboard', [
            'salespersons' => User::role('salesperson')->with('showroom')->withCount('clicks')->orderBy('clicks_count', 'DESC')->paginate(),
        ]);
    }

    public function activate(User $user)
    {
        try {
            $user->forceFill(['status' => 'active']);
            $user->save();

            return back()->with('message', [
                'type' => 'success',
                'message' => 'Sales Person Has Been Updated Successfully'
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
                'message' => 'Sales Person Has Been Updated Successfully'
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
                'message' => 'Sales Person Has Been Updated Successfully'
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
                'message' => 'Sales Person Has Been Updated Successfully'
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
                'message' => 'Sales Person Has Been Updated Successfully'
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
                'message' => 'Sales Person Has Been Updated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }
}
