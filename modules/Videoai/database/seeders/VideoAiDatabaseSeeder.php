<?php

namespace Modules\VideoAi\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Videoai\App\Models\PromptPreset;
use Modules\VideoAi\Database\Seeders\PromptPresetSeeder;
class VideoAiDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prompt_presets = array(
            array('id' => '1','user_id' => NULL,'title' => 'A person in a crowd','description' => 'A person in a crowd','prompt' => 'Cinematic view of  [a human subject with detailed descriptions of their appearance] walking through a blurry crowd.  [Describe their action]. 30x speed, hyperspeed, fast motion. In the style of  [describe style; ex. Moody colors, cinematic feel, dynamic motion, depth of field].','icon' => NULL,'prompt_for' => 'video','status' => 'active','meta' => '[]','created_at' => '2024-12-09 05:13:56','updated_at' => '2024-12-09 05:13:56'),
            array('id' => '3','user_id' => NULL,'title' => 'Cinematic Dolly Out','description' => 'Cinematic Dolly Out','prompt' => 'The camera slowly pulls back and rotates as [the subject and subject action].','icon' => NULL,'prompt_for' => 'video','status' => 'active','meta' => '[]','created_at' => '2024-12-09 05:13:56','updated_at' => '2024-12-09 05:13:56')
        );
        
        PromptPreset::insert($prompt_presets);
    }
}
