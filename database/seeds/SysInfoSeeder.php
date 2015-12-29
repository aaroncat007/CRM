<?php

use Illuminate\Database\Seeder;

class SysInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sysInfo')->truncate();  

		$data = App\SysInfo::create(array(
			'Name' => 'WebName',
			'Value' => '米包設計',
		));

		$data = App\SysInfo::create(array(
			'Name' => 'WebEnName',
			'Value' => 'Mi-Bao',
		));


    }
}
