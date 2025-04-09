<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = array(
            array('id' => '1','name' => 'Header','position' => 'main-menu','data' => '[{"id":"e95lu1cs","text":"Home","icon":null,"href":"\\/","target":"_self","title":null,"children":[]},{"id":"gays8vco","text":"About Us","icon":null,"href":"\\/about-us","target":"_self","title":null,"children":[]},{"id":"cujvodo2","text":"Explore","icon":null,"href":"#","target":"_self","title":null,"children":[{"id":"aoevjyyt","text":"Team","icon":null,"href":"\\/team","target":"_self","title":null,"children":[]},{"id":"h1esymdc","text":"Career","icon":null,"href":"\\/jobs","target":"_self","title":null,"children":[]},{"id":"bdoss81r","text":"Pricing","icon":null,"href":"\\/pricing","target":"_self","title":null,"children":[]},{"id":"ez6i5okp","text":"Services","icon":null,"href":"\\/services","target":"_self","title":null,"children":[]},{"id":"6jq4g55d","text":"Integrations","icon":null,"href":"\\/integrations","target":"_self","title":null,"children":[]}]},{"id":"b2hbs7ik","text":"Blogs","icon":null,"href":"\\/blogs","target":"_self","title":null,"children":[]},{"id":"h7hrsutc","text":"Contact Us","icon":null,"href":"\\/contact-us","target":"_self","title":null,"children":[]}]','lang' => 'en','location' => 'web','status' => '1','created_at' => '2023-08-03 16:57:06','updated_at' => '2023-11-28 16:15:28'),
            array('id' => '2','name' => 'Quick Links','position' => 'footer-right','data' => '[{"id":"ctw391xu","text":"Login","icon":null,"href":"\\/login","target":"_self","title":null,"children":[]},{"id":"7u90osuc","text":"Register","icon":null,"href":"\\/register","target":"_self","title":null,"children":[]},{"id":"4r8wupe3","text":"Integrations","icon":null,"href":"\\/integrations","target":"_self","title":null,"children":[]},{"id":"k15ht8xt","text":"Blogs","icon":null,"href":"\\/blogs","target":"_self","title":null,"children":[]},{"id":"2lgxqgjs","text":"Subscriptions","icon":null,"href":"\\/pricing","target":"_self","title":null,"children":[]},{"id":"9vskytfq","text":"Contact Us","icon":null,"href":"\\/contact-us","target":"_self","title":null,"children":[]}]','lang' => 'en','location' => 'web','status' => '1','created_at' => '2023-08-16 17:33:43','updated_at' => '2024-08-26 05:26:20'),
            array('id' => '3','name' => 'Explore','position' => 'footer-left','data' => '[{"id":"8c6fkq6c","text":"About Us","icon":null,"href":"\\/about-us","target":"_self","title":null,"children":[]},{"id":"law145ip","text":"Pricing","icon":null,"href":"\\/pricing","target":"_self","title":null,"children":[]},{"id":"ekteoag9","text":"Discussion","icon":null,"href":"\\/contact","target":"_self","title":null,"children":[]},{"id":"cbrdfgnc","text":"Our Team","icon":null,"href":"\\/team","target":"_self","title":null,"children":[]},{"id":"ll871m1h","text":"Career","icon":null,"href":"\\/jobs","target":"_self","title":null,"children":[]},{"id":"gumesi7s","text":"Services","icon":null,"href":"\\/services","target":"_self","title":null,"children":[]}]','lang' => 'en','location' => 'web','status' => '1','created_at' => '2023-08-16 17:33:58','updated_at' => '2024-08-26 05:20:55')
        );          
        Menu::truncate();
        Menu::insert($menus);

        MenuService::defaultSeeder('Admin');
        MenuService::defaultSeeder('User');
    }
}
