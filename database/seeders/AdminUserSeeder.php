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
        \App\Models\User::updateOrCreate(['email' => 'admin@tunicart.com'], [
            'name' => 'Admin Tunicart',
            'password' => \Hash::make('admin123'),
            'is_admin' => true
        ]);

        \App\Models\User::updateOrCreate(['email' => 'customer@example.com'], [
            'name' => 'John Doe',
            'password' => \Hash::make('customer123'),
            'is_admin' => false
        ]);
    }
}
