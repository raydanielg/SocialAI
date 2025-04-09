<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BrandSlogan;
class BrandSloganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       

        $brand_slogans = array(
            array('id' => '1','category_id' => '93','title' => 'Code Smarter, Build Better Solutions','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 17:22:30'),
            array('id' => '2','category_id' => '94','title' => 'Inspiring Creativity, Transforming Visual Art','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 17:23:10'),
            array('id' => '3','category_id' => '94','title' => 'Inspire Creativity, Elevate Your Art','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 17:23:27'),
            array('id' => '4','category_id' => '92','title' => 'Designing Digital Excellence, Crafting Success','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 17:25:09'),
            array('id' => '5','category_id' => '94','title' => 'Unleash Imagination, Create Timeless Art','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 17:25:51'),
            array('id' => '6','category_id' => '92','title' => 'Crafting Digital Experiences, Innovating Solutions','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 17:26:43'),
            array('id' => '7','category_id' => '93','title' => 'Empowering Ideas, Building Tomorrow’s Software','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 17:28:07'),
            array('id' => '8','category_id' => '93','title' => 'Transforming Ideas into Digital Solutions','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 17:28:37'),
            array('id' => '9','category_id' => '94','title' => 'Expressing Vision, Creating Timeless Art','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 17:26:14'),
            array('id' => '10','category_id' => '92','title' => 'Innovative Design, Seamless Digital Experiences','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 17:27:17')
          );

        BrandSlogan::insert($brand_slogans); 
    }
}
