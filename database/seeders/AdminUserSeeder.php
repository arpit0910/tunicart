<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::updateOrCreate(['email' => 'admin@tunicart.in'], [
            'name' => 'Admin Tunicart',
            'password' => \Hash::make('Tunicart@123'),
            'is_admin' => true
        ]);
    }
}
