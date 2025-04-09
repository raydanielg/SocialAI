<?php

namespace Database\Seeders;

use App\Models\Prompt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Videoai\App\Models\PromptPreset;
class PromptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prompts = array(
            array('id' => '1','title' => 'slogan','prompt' => 'Create a catchy and memorable slogan that encapsulates the essence of the [category] brand. The slogan should be short, impactful, and convey the brand unique selling proposition.','type' => 'brand','prompt_type' => 'slogan','status' => 'active','max_token' => '5','credit_charge' => '0.50','meta' => '{"ai_model":"gpt-4o","max_word":5}','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 19:51:23'),
            array('id' => '3','title' => 'identity','prompt' => 'Describe the [category] brand\\\'s identity in terms of its mission, vision, and core values. Consider what makes the brand unique and how it differentiates itself from competitors. This identity should resonate with the target audience and be reflected in all brand communications.','type' => 'brand','prompt_type' => 'identity','status' => 'active','max_token' => '50','credit_charge' => '50.00','meta' => '{"ai_model":"gpt-4o","max_word":"50"}','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-12 04:50:45'),
            array('id' => '4','title' => 'audience','prompt' => 'Identify the target audience of the [category] brand. What are their demographics, interests, and behaviors? Understanding the audience is key to creating a brand that resonates with them. Consider conducting market research to gather this information.','type' => 'brand','prompt_type' => 'audience','status' => 'active','max_token' => '50','credit_charge' => '100.00','meta' => '{"ai_model":"gpt-4o","max_word":"50"}','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-12 04:50:57'),
            array('id' => '5','title' => 'strategy','prompt' => 'Outline a comprehensive brand strategy that includes positioning, messaging, and marketing tactics. The strategy should align with the [category] brand\\\'s identity and resonate with the target audience. It should also outline how the brand will achieve its goals and measure success.','type' => 'brand','prompt_type' => 'strategy','status' => 'active','max_token' => '50','credit_charge' => '50.00','meta' => '{"ai_model":"gpt-4o","max_word":"50"}','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-12 04:51:12'),
            array('id' => '6','title' => 'voice','prompt' => 'Define the [category] brand\\\'s voice. Is it formal or casual? Professional or playful? The brand\\\'s voice should reflect its identity and resonate with the target audience. It should be consistent across all brand communications.','type' => 'brand','prompt_type' => 'voice','status' => 'active','max_token' => '50','credit_charge' => '20.00','meta' => '{"ai_model":"gpt-4o","max_word":50}','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-12 04:51:44'),

            array('id' => '7','title' => 'voice-tone','prompt' => 'Describe the tone of the [category] brand\\\'s voice. My brand name is [name] and my brand description is [description] . How does it change in different contexts? The tone should adapt to the situation while still remaining true to the brand\\\'s voice. For example, the tone might be more serious in a crisis communication and more playful in a social media post.','type' => 'brand','prompt_type' => 'voice-tone','status' => 'active','max_token' => '100','credit_charge' => '100.00','meta' => '{"ai_model":"gpt-4o","max_word":100}','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-12 05:00:58'),
            array('id' => '8','title' => 'post','prompt' => 'You are my social media manager write a post for social media the context is for [post_description] and the brand name is [brand_name]','type' => 'content','prompt_type' => 'post','status' => 'active','max_token' => '100','credit_charge' => '100.00','meta' => '{"ai_model":"gpt-4o","max_word":100}','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-12 04:55:13'),
           
            array('id' => '11','title' => 'Post Image','prompt' => 'you are my social media manager my brand description is [description] and my brand category is [category]. Generate an attractive image for [post_description] this image will be posted to social media.','type' => 'content','prompt_type' => 'image','status' => 'active','max_token' => NULL,'credit_charge' => '50.00','meta' => '{"image_ai_model":"dalle_3","negative_prompt":null,"seed":null,"image_size":"1024x1024","image_quality":"standard"}','created_at' => '2024-08-12 05:04:24','updated_at' => '2024-08-12 05:04:24')
          );
        Prompt::insert($prompts);

        $prompt_presets = array(
            array('id' => '1','user_id' => NULL,'title' => 'A person in a crowd','description' => 'A person in a crowd','prompt' => 'Cinematic view of  [a human subject with detailed descriptions of their appearance] walking through a blurry crowd.  [Describe their action]. 30x speed, hyperspeed, fast motion. In the style of  [describe style; ex. Moody colors, cinematic feel, dynamic motion, depth of field].','icon' => NULL,'prompt_for' => 'video','status' => 'active','meta' => '[]','created_at' => '2024-12-09 05:13:56','updated_at' => '2024-12-09 05:13:56'),
            array('id' => '3','user_id' => NULL,'title' => 'Cinematic Dolly Out','description' => 'Cinematic Dolly Out','prompt' => 'The camera slowly pulls back and rotates as [the subject and subject action].','icon' => NULL,'prompt_for' => 'video','status' => 'active','meta' => '[]','created_at' => '2024-12-09 05:13:56','updated_at' => '2024-12-09 05:13:56')
        );
        
        PromptPreset::insert($prompt_presets);
    }
}
