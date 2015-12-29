<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	     DB::table('roles')->truncate();  
	     Sentinel::getRoleRepository()->createModel()->create([  
	         'name'    => '系統管理員',  
             'slug'    => 'SuperAdmin',  
             'permissions' => $this->SuperAdmin(),  
	     ]);  
	     Sentinel::getRoleRepository()->createModel()->create([  
	         'name'    => '管理員',  
             'slug'    => 'Admin',  
             'permissions' => $this->Admin(),  
	     ]);  

       Sentinel::getRoleRepository()->createModel()->create([
            'name'    => '使用者',  
             'slug'    => 'User',  
             'permissions' => array(),  
       ]);
   }  

   private function SuperAdmin(){  
       return $data = array(  
             'user.user_manage'       => true,  
             'sys.system_manage'      => true,  
             'sys.rorle_manage'       => true,  
             'sys.permission_manage'    => true,  
             'sys.news_manage'       => true,  
       );  
   }  

   private function Admin(){  
         $data             = $this->SuperAdmin();  
         $data['sys.system_manage']   = false;  
         $data['sys.rorle_manage']   = false;  
         $data['sys.permission_manage'] = false;  
         $data['sys.news_manage']    = false;  
       return $data;  
   }  
}
