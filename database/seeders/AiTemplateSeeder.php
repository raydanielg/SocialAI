<?php

namespace Database\Seeders;

use App\Models\AiTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AiTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ai_templates = array(
            array('id' => '1','uuid' => 'd12a7e56-056b-4fec-ab1f-9c2e310128c9','title' => 'Blog post','description' => 'it will Compose a compelling blog post','preview' => '/demo/pnCPxOp0cM3OHtNLZBQsTOfnqdVDm4a7mjAANatF.jpg','icon' => '/demo/dQcEjpVaBadXj3ikzSiU.png','status' => 'active','fields' => '[{"type":"input","name":"Topic","placeholder":"Topic","value":null}]','prompt' => 'Compose a compelling blog post about [topic].','prompt_type' => 'text','ai_model' => NULL,'credit_charge' => '1.00','meta' => '{"max_token":"500","max_word":"500","model":"gpt-3.5-turbo-instruct"}','created_at' => '2024-08-02 15:58:37','updated_at' => '2024-08-18 06:26:00'),
            array('id' => '6','uuid' => '136a2cea-2b02-44b8-ab19-16e14a7f59e3','title' => 'Generate a logo','description' => 'it will create an appealing logo','preview' => '/demo/XqM2wgTT1UsqDUuJw2Se.png','icon' => '/demo/94pXiMvJ7ZHJvUtkEZTf.png','status' => 'active','fields' => '[{"type":"input","name":"Brand","placeholder":"Tesla","value":null},{"type":"input","name":"Category","placeholder":"Software Development","value":null}]','prompt' => 'Create a visually appealing logo for [Brand] and my brand category is [Category]','prompt_type' => 'image','ai_model' => 'dalle_3','credit_charge' => '100.00','meta' => '{"negative_prompt":"null","seed":null,"image_size":"1024x1024","image_quality":"standard"}','created_at' => '2024-08-18 06:34:07','updated_at' => '2024-08-18 06:34:07')
        );
        AiTemplate::insert($ai_templates);
    }
}
