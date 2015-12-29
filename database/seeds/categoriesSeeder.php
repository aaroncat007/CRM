<?php

use Illuminate\Database\Seeder;

class categoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();  

		$data1 = App\categories::create(array(
			'title' => '積躍股份有限公司',
			'description' => '這是積躍的類別唷唷唷唷唷唷',
		));

		App\categories::create(array(
			'title' => '資訊部',
			'description' => '資訊部門專用群組',
			'parent_categories' => $data1->id
		));

		$data2 = App\categories::create(array(
			'title' => '測試股份有限公司',
			'description' => '這是測試的類別唷唷唷唷唷唷',
		));

		App\categories::create(array(
			'title' => '工程部',
			'description' => '工程部門專用群組',
			'parent_categories' => $data2->id
		));

		App\categories::create(array(
			'title' => '設計部',
			'description' => '設計部門專用群組',
			'parent_categories' => $data2->id
		));

    }
}
