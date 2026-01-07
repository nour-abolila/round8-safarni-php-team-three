<?php

namespace App\Services\User;

use App\Models\User;

class ProfileService
{
    public function update(User $user, array $data): User
    {
        $user->update([
            'full_name' => $data['full_name'] ?? $user->full_name,
            'email'     => $data['email'] ?? $user->email,
            'mobile'    => $data['mobile'] ?? $user->mobile,
        ]);

        return $user->fresh();
    }
}
