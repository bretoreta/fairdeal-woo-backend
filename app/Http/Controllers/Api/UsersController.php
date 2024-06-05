<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\StoreRequest;
use App\Models\Code;
use App\Models\User;
use App\Notifications\CodeGeneratedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function index (Request $request) {
        return User::role('user')->where('name', 'like',  '%'. strtolower($request->query('search')) .'%')
                    ->orWhere('email', 'like',  '%'. strtolower($request->query('search')) .'%')
                    ->get(['id', 'name', 'email'])->toJson();
    }

    public function store (StoreRequest $request) {
        try {
            // Get Validated Data Only
            $data = $request->validated();

            // Begin Database Transaction
            DB::beginTransaction();
            // Create a user to the database with some dummy data
            $user = User::create([
                'name' => $data['name'],
                'username' => strtolower(explode(' ', $data['name'])[0] ?? 'demouser'.uniqid()),
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make('password'),
            ]);

            // Assign role: User
            $user->assignRole('user');
            // Generate the referral code for user
            $token = $this->generateCode();

            // Save the code to Database
            Code::create([
                'user_id' => $user->id,
                'token' => $token,
                'campaign' => 'Full House Sale',
            ]);

            //Commit changes to database
            DB::commit();

            // Send notifications to user with the code
            $user->notify(new CodeGeneratedNotification($token));

            // If all goes well, Return a successfull response
            return response()->noContent(200);

        } catch (\Error $error) {
            Log::error('Failed to register user from API call');
            return response($error->getMessage(), $error->getCode());
        }
    }

    private function generateCode() {
        return $token = "FFL-". Str::random(8). "-" . now()->format('Y');
    }
}
