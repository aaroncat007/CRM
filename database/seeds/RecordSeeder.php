<?php

use Illuminate\Database\Seeder;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('record')->truncate();  

		App\record::create(array(
			'categories_id' => '2',
			'user_id' => '1',
			'title' => '測試標題1',
			'content' => '測試內容1',
		));

		App\record::create(array(
			'categories_id' => '2',
			'user_id' => '1',
			'title' => '測試標題2',
			'content' => '測試內容2',
		));
    }
}
