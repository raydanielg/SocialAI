<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\OptionsTableSeeder;
use Database\Seeders\GatewaysTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            AssetSeeder::class,
            BrandAudienceSeeder::class,
            BrandIdentitySeeder::class,
            BrandLogoSeeder::class,
            BrandPostSeeder::class,
            BrandSeeder::class,
            BrandSloganSeeder::class,
            BrandStrategySeeder::class,
            BrandVoiceSeeder::class,
            CategoriesTableSeeder::class,
            DesignSeeder::class,
            GatewaysTableSeeder::class,
            IntegrationTableSeeder::class,
            JobSeeder::class,
            MenusTableSeeder::class,
            OptionsTableSeeder::class,
            PlansTableSeeder::class,
            PostsTableSeeder::class,
            PostCategoryTableSeeder::class,
            PostMetaTableSeeder::class,
            ProjectSeeder::class,
            PromptSeeder::class,
            ServiceSeeder::class,
            UserPlatformSeeder::class,
            UsersTableSeeder::class,
            AiTemplateSeeder::class
            // DemoSeeder::class
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
