<?php
namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $users = [
            [
                'full_name' => 'أحمد محمد',
                'email' => 'ahmed@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password123'),
                'mobile' => '+966501234567',
            ],
            [
                'full_name' => 'سارة عبدالله',
                'email' => 'sara@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password123'),
                'mobile' => '+966502345678',
            ],
            [
                'full_name' => 'محمد الخالد',
                'email' => 'mohammed@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password123'),
                'mobile' => '+966503456789',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
