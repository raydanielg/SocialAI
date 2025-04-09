<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Postcategory;

class PostCategoryTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $postcategories = array(
      array('post_id' => '10','category_id' => '76'),
      array('post_id' => '10','category_id' => '79'),
      array('post_id' => '10','category_id' => '81'),
      array('post_id' => '10','category_id' => '80'),
      array('post_id' => '9','category_id' => '77'),
      array('post_id' => '9','category_id' => '79'),
      array('post_id' => '8','category_id' => '78'),
      array('post_id' => '8','category_id' => '76'),
      array('post_id' => '8','category_id' => '81'),
      array('post_id' => '16','category_id' => '104'),
      array('post_id' => '3','category_id' => '104'),
      array('post_id' => '23','category_id' => '104'),
      array('post_id' => '25','category_id' => '104')
    );

    Postcategory::insert($postcategories);
  }
}
