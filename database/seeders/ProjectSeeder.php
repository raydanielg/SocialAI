<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = array(
            array('id' => '4', 'category_id' => '68', 'title' => 'Mobile App Design', 'slug' => 'mobile-app-design', 'preview' => '/demo/xIprMpRLiwKOQ0glp0Es.jpg', 'banner_preview' => '/demo/cgMJ4HailUEELhYB9wFM.png', 'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.', 'overview' => '<h4><strong>Overview</strong></h4><ul><li>Create &amp; Save your notes with multi-media</li><li>Complete note editor with rich text options</li><li>Automatically sync in real time</li><li>Web Clipper Extension</li></ul><p>Felis morbi ut tristique pretium libero. Eget purus, enim, orci, quis tempor sed. Sed nec eget nibh et Ut orci, sagittis tellus dui congue. Blandit laoreet nullam amet eget. Ut tincidunt diam tempor sed turpis odio vitae sem lobortis. Lobortis enim non eu a.</p><p><img src="assets/img/project/solution-1.jpg" alt=""></p><p><img src="assets/img/project/solution-2.jpg" alt=""></p>', 'output' => 'Felis morbi ut tristique pretium libero. Eget purus, enim, orci, quis tempor sed. Sed nec eget nibh et Ut orci, sagittis tellus dui congue. Blandit laoreet nullam amet eget. Ut tincidunt diam tempor sed turpis odio vitae sem lobortis. Lobortis enim non eu a. In gravida velit pretium commodo odio ridiculus odio enim.Tincidunt eget tellus pellentesque nulla.
          
          Sed morbi dignissim odio enim volutpat. Viverra facilisi aliquet sed purus id ornare nunc, sit ipsum.Risus amet non eget velit nunc, libero', 'client' => 'Microsoft App Holing Ltd, Australia Area', 'preview_link' => '/projects', 'is_active' => '1', 'is_featured' => '1', 'meta' => '{"title":"Mobile App Design","image":null,"description":"Mobile App Design Description","tags":"Mobile, App, Design"}', 'created_at' => '2023-11-23 10:13:53', 'updated_at' => '2023-11-23 10:13:53')
        );
        Project::insert($projects);
    }
}
