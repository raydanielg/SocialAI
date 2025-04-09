<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = array(
            array('id' => '65','title' => 'Developement','slug' => 'developement-1','icon' => NULL,'preview' => '/demo/cosbQQ7S4jkd8vrJSJtj.png','type' => 'project','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-21 02:26:48','updated_at' => '2023-11-23 03:46:19'),
            array('id' => '66','title' => 'CRM Management','slug' => 'crm-management','icon' => '/demo/eGfxXHdHqY4eBKEp8dCv.png','preview' => '/demo/2yKtFOxaotlzg5oAphC4.png','type' => 'service','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-21 02:56:31','updated_at' => '2024-08-20 17:03:03'),
            array('id' => '67','title' => 'Branding','slug' => 'branding','icon' => NULL,'preview' => '/demo/vLnhfOT5qzWrGl0jXRAY.png','type' => 'project','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-21 10:49:48','updated_at' => '2023-11-23 03:46:01'),
            array('id' => '68','title' => 'Design Work','slug' => 'design-work-1','icon' => NULL,'preview' => '/demo/ulBY6aegCWh4zj3Rn3xX.png','type' => 'project','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-21 10:54:13','updated_at' => '2023-11-23 03:45:39'),
            array('id' => '70','title' => 'Project Management','slug' => 'project-management','icon' => '/demo/eGfxXHdHqY4eBKEp8dCv.png','preview' => '/demo/YIq7zLO0OzGsdLhKhPgT.png','type' => 'service','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-23 03:34:21','updated_at' => '2024-08-20 17:02:42'),
            array('id' => '71','title' => 'Sales Analytics','slug' => 'sales-analytics','icon' => '/demo/eGfxXHdHqY4eBKEp8dCv.png','preview' => '/demo/hNrMNjbEbxgVaCPD1KN0.png','type' => 'service','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-23 03:36:37','updated_at' => '2024-08-20 17:01:41'),
            array('id' => '72','title' => 'Easy Envoicing','slug' => 'easy-envoicing','icon' => '/demo/eGfxXHdHqY4eBKEp8dCv.png','preview' => '/demo/DOVhCqlhQ1DV5ZkR36Vp.png','type' => 'service','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-23 03:36:44','updated_at' => '2024-08-20 17:01:25'),
            array('id' => '73','title' => 'Complete Visibility','slug' => 'complete-visibility','icon' => '/demo/XOqmBXrRoCsJaPtPpbHI.png','preview' => '/demo/1qvoPKk1FyvfEUkcDo0e.png','type' => 'service','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-23 03:36:54','updated_at' => '2024-08-20 17:01:00'),
            array('id' => '74','title' => 'Illusutration','slug' => 'illusutration','icon' => NULL,'preview' => '/demo/ulBY6aegCWh4zj3Rn3xX.png','type' => 'project','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-21 10:54:13','updated_at' => '2023-11-23 03:45:39'),
            array('id' => '75','title' => 'App Design','slug' => 'app-design','icon' => NULL,'preview' => '/demo/ulBY6aegCWh4zj3Rn3xX.png','type' => 'project','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-21 10:54:13','updated_at' => '2023-11-23 03:45:39'),
            array('id' => '76','title' => 'CRM SOFTWARE','slug' => 'crm-software','icon' => NULL,'preview' => NULL,'type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-23 04:45:29','updated_at' => '2023-11-23 04:45:29'),
            array('id' => '77','title' => 'SALES TOOLS','slug' => 'sales-tools','icon' => NULL,'preview' => NULL,'type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-23 04:45:40','updated_at' => '2023-11-23 04:45:40'),
            array('id' => '78','title' => 'SALES MANAGEMENT','slug' => 'sales-management','icon' => NULL,'preview' => NULL,'type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-23 04:45:50','updated_at' => '2023-11-23 04:45:50'),
            array('id' => '79','title' => 'crm','slug' => 'crm','icon' => NULL,'preview' => NULL,'type' => 'tags','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-23 04:46:14','updated_at' => '2023-11-23 04:46:14'),
            array('id' => '80','title' => 'stori','slug' => 'stori','icon' => NULL,'preview' => NULL,'type' => 'tags','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-23 04:46:25','updated_at' => '2023-11-23 04:46:25'),
            array('id' => '81','title' => 'AI','slug' => 'ai','icon' => NULL,'preview' => NULL,'type' => 'tags','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2023-11-23 04:46:35','updated_at' => '2023-11-23 04:46:35'),
            array('id' => '92','title' => 'Design','slug' => 'design','icon' => NULL,'preview' => '/demo/oMQ9roAM5jBckMKoml1o.png','type' => 'brand','status' => '1','is_featured' => '0','lang' => 'en','category_id' => NULL,'created_at' => '2024-01-05 00:25:41','updated_at' => '2024-01-07 21:32:49'),
            array('id' => '93','title' => 'Development ','slug' => 'development','icon' => NULL,'preview' => '/demo/oMQ9roAM5jBckMKoml1o.png','type' => 'brand','status' => '1','is_featured' => '0','lang' => 'en','category_id' => NULL,'created_at' => '2024-01-05 00:25:41','updated_at' => '2024-01-07 21:32:49'),
            array('id' => '94','title' => 'Art','slug' => 'art','icon' => NULL,'preview' => '/demo/oMQ9roAM5jBckMKoml1o.png','type' => 'brand','status' => '1','is_featured' => '0','lang' => 'en','category_id' => NULL,'created_at' => '2024-01-05 00:25:41','updated_at' => '2024-01-07 21:32:49'),
            array('id' => '95','title' => '#','slug' => '4EeB6yawaShbIlSC','icon' => NULL,'preview' => '/demo/gYnByREnBeh8Jeq95GrD.png','type' => 'partner','status' => '1','is_featured' => '1','lang' => 'partner','category_id' => NULL,'created_at' => '2024-06-13 06:36:08','updated_at' => '2024-06-13 06:36:08'),
            array('id' => '96','title' => '#','slug' => '3oCJQLScgLE2kODY','icon' => NULL,'preview' => '/demo/fsfnXP9am1xD247sbM9J.png','type' => 'partner','status' => '1','is_featured' => '1','lang' => 'partner','category_id' => NULL,'created_at' => '2024-06-13 06:36:14','updated_at' => '2024-06-13 06:36:14'),
            array('id' => '97','title' => '#','slug' => 'hO2Md6SKzDavdOGW','icon' => NULL,'preview' => '/demo/X0WymY0KxwtSIx4Rgfdk.png','type' => 'partner','status' => '1','is_featured' => '1','lang' => 'partner','category_id' => NULL,'created_at' => '2024-06-13 06:36:20','updated_at' => '2024-06-13 06:36:20'),
            array('id' => '98','title' => '#','slug' => 'wERGnlVqgkiGne0l','icon' => NULL,'preview' => '/demo/BGqN1Yhf8qumgF6wS8x1.png','type' => 'partner','status' => '1','is_featured' => '1','lang' => 'partner','category_id' => NULL,'created_at' => '2024-06-13 06:36:27','updated_at' => '2024-06-13 06:36:27'),
            array('id' => '99','title' => '#','slug' => 'gWMRB8BH3ggVGMGi','icon' => NULL,'preview' => '/demo/EQ4cIhGuqfY2BCwHYG6t.png','type' => 'partner','status' => '1','is_featured' => '1','lang' => 'partner','category_id' => NULL,'created_at' => '2024-06-13 06:36:33','updated_at' => '2024-06-13 06:36:33'),
            array('id' => '100','title' => '#','slug' => 'FjLonJfZ4Soptkzb','icon' => NULL,'preview' => '/demo/2umn0MCfgsahnCH65x0t.png','type' => 'partner','status' => '1','is_featured' => '1','lang' => 'partner','category_id' => NULL,'created_at' => '2024-06-13 06:36:56','updated_at' => '2024-06-13 06:36:56'),
            array('id' => '101','title' => '#','slug' => 'liyYSkQzvWMbKzeD','icon' => NULL,'preview' => '/demo/NwQ4GVE9dQos9qgOOTHc.png','type' => 'partner','status' => '1','is_featured' => '1','lang' => 'partner','category_id' => NULL,'created_at' => '2024-06-13 06:37:02','updated_at' => '2024-06-13 06:37:02'),
            array('id' => '102','title' => '#','slug' => 'LrkFW943cx8zwP4Y','icon' => NULL,'preview' => '/demo/IzAOjUHYqf8qvN9QCqap.png','type' => 'partner','status' => '1','is_featured' => '1','lang' => 'partner','category_id' => NULL,'created_at' => '2024-06-13 06:37:07','updated_at' => '2024-06-13 06:37:07'),
            array('id' => '103','title' => '#','slug' => '1RhUYlgMbezoEWl8','icon' => NULL,'preview' => '/demo/odHlDDofz5fi0qWBc8LB.png','type' => 'partner','status' => '1','is_featured' => '1','lang' => 'partner','category_id' => NULL,'created_at' => '2024-06-13 06:37:12','updated_at' => '2024-06-13 06:37:12'),
            array('id' => '104','title' => 'SocialAI','slug' => 'socialai','icon' => NULL,'preview' => NULL,'type' => 'faq_category','status' => '1','is_featured' => '1','lang' => 'en','category_id' => NULL,'created_at' => '2024-08-03 05:40:23','updated_at' => '2024-08-03 05:40:23')
          );
        Category::insert($categories);
    }
}
