<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->truncate();  
        DB::table('posts_reply')->truncate();

		$d1 = App\posts::create(array(
			'categories_id' => '2',
			'user_id' => '1',
			'subject' => '測試標題1',
			'content' => '測試內容1',
		));

		App\posts_reply::create(array(
			'posts_id' => $d1->id,
			'user_id' => '1',
			'content' =>'回覆1',

		));
		App\posts_reply::create(array(
			'posts_id' => $d1->id,
			'user_id' => '1',
			'content' =>'回覆2',

		));
		App\posts_reply::create(array(
			'posts_id' => $d1->id,
			'user_id' => '1',
			'content' =>'回覆3',

		));


		App\posts::create(array(
			'categories_id' => '2',
			'user_id' => '1',
			'subject' => '測試標題2',
			'content' => '測試內容2',
		));
    }
}
