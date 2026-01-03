<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
      
        User::factory()->count(10)->create();

   
        User::factory()->create([

            'full_name' => 'Nada Asfour',
            
            'email' => 'nada@example.com',
            
            'password' => Hash::make('12345678'),
        ]);
    }
}
