<?php

namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('user');

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function verifyEmail(User $user): void
    {
        $user->update([
            'email_verified_at' => Carbon::now(),
        ]);
    }

    public function login(array $data): array

    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new \Exception('The provided credentials are incorrect.');
        }

        if (!$user->hasVerifiedEmail()) {
            throw new \Exception('Email not verified.');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function getUserByEmail(string $email)
    {
        $user = User::where('email', $email)->first();

        return $user;
    }

    public function resetPassword(User $user, string $password): void
    {
        $user->update([
            'password' => Hash::make($password),
        ]);

        // حذف كل التوكنز القديمة
        $user->tokens()->delete();
    }

    public function changePassword($user, string $currentPassword, string $newPassword): void
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new \Exception('Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        // حذف كل التوكنز القديمة
        $user->tokens()->delete();
    }
}
