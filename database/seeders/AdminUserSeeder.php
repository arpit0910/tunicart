<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin Tunicart',
            'email' => 'admin@tunicart.in',
            'password' => \Hash::make('admin123'),
            'is_admin' => true
        ]);
    }
}
