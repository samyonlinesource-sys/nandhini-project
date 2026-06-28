<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Api\UserModel;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserModel::updateOrCreate(
            ['email'=>'admin@gamil.com'],
            [
                'name'=>'Admin',
                'username'=> 'Admin',
                'password'=>Hash::make('Admin@123'),
            ]
        );
    }
}