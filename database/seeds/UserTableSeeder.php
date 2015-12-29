<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	     DB::table('users')->truncate();  
	     DB::table('role_users')->truncate();  
	     DB::table('activations')->truncate();  
	     $user = Sentinel::create([  
	             'email'   	=> 'superadmin@wb.com',  
	             'first_name' => 'WB-超級管理員',  
	             'password'  => '123456',  
	     ]);  
	     // 啟用帳號  
	     $activation = Activation::create($user);  
	     Activation::complete($user, $activation->code);  
	     // 加入角色 
	     $role = Sentinel::findRoleBySlug('SuperAdmin');  
	     $role->users()->attach($user);  


	     $user = Sentinel::create([  
	             'email'   => 'admin@wb.com',  
	             'first_name' => 'WB-管理員',  
	             'password'  => '123456',  
	     ]);  
	     // 啟用帳號  
	     $activation = Activation::create($user);  
	     Activation::complete($user, $activation->code);  
	     // 加入角色
	     $role = Sentinel::findRoleBySlug('Admin');  
	     $role->users()->attach($user);  

	     $user = Sentinel::create([  
	             'email'   => 'user@wb.com',  
	             'first_name' => '客戶',  
	             'password'  => '123456',  
	     ]);  
	     // 啟用帳號  
	     $activation = Activation::create($user);  
	     Activation::complete($user, $activation->code);  
	     // 加入角色
	     $role = Sentinel::findRoleBySlug('User');  
	     $role->users()->attach($user);  

   }  
}
