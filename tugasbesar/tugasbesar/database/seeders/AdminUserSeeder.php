<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Make sure to import the User model
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin User', 
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'role' => 'admin', 
        ]);
    }
}
