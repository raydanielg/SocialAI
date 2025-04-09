<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super = User::create([
            'role' => 'admin',
            'avatar' => null,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        $permissions = [
            [
                'group_name' => 'Appearance',
                'permissions' => [
                    'blogs',
                    'blog-category',
                    'blog-tags',
                    'faq',
                    // 'features',
                    'team',
                    'language',
                    'menu',
                    'custom-page',
                    'partners',
                    'seo',
                    'testimonials',

                    // story ai
                    'brands',
                    'brand-categories',
                    'brand-descriptions',
                    'brand-slogans',
                    'brand-logos',
                    'brand-identities',
                    'brand-audiences',
                    'brand-strategies',
                    'designs',

                    'ai-templates',
                    'ai-language',
                    'prompts',
                    'ai-generated-history',

                    'integrations',
                    'services',
                    'service-categories',
                    'projects',
                    'project-categories',
                    'jobs',
                    'job-applications',
                ]
            ],
            [
                'group_name' => 'Site Settings',
                'permissions' => [
                    'page-settings',
                    'admin',
                    'developer-settings',
                    'roles',
                ]
            ],
            [
                'group_name' => 'User Logs',
                'permissions' => [
                    'customer',
                    'notification',
                ]
            ],
            [
                'group_name' => 'Site Functionalities',
                'permissions' => [
                    'cron-job',
                    'gateways',
                    'order',
                    'subscriptions',
                    'support',
                    'company-reviews',
                    'faq-category',
                ]
            ],
        ];

        foreach ($permissions as $key => $row) {
            foreach ($row['permissions'] as $per) {
                $permission = Permission::create([
                    'name' => $per,
                    'group_name' => $row['group_name']
                ]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
                $super->assignRole($roleSuperAdmin);
            }
        }


       

   
    }
}
