<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Api\UserLevel;
use App\Models\Api\UserModel;
use Illuminate\Support\Facades\Hash;
class LoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $level=[
            ['name'=>'Superadmin','email'=>'superadmin@gmail.com','role'=> 1 ],
            ['name'=>'StoreAdmin','email'=>'storeadmin@gmail.com','role'=> 2 ],
            ['name'=>'Manger','email'=>'manager@gmail.com','role'=> 3],
        ];
        foreach ($level as $role){
            $userlevel= UserLevel::firstOrCreate(
                ['role'=>$role['role']],
                 ['name'=>$role['name']],
                );
                UserModel::updateOrCreate(
                    ['email'=>$role['email']],
                    [
                        'name'=>$role['name'],
                        'username'=>$role['name'],
                        'user_level' =>$userlevel->id,
                        'password' =>Hash::make('Admin@123'),
                    ]

                );
        }
    }
}