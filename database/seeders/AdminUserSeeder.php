<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Manuel',
            'email'    => 'manueldesande@hotmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);
    }
}
