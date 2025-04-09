<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $posts = array(
            array('id' => '3','title' => 'Can I switch plans after subscribing?','slug' => 'can-i-switch-plans-after-subscribing','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 04:18:16','updated_at' => '2024-08-03 05:41:37'),
            array('id' => '4','title' => 'Darlene Robertson','slug' => 'Product Manager','type' => 'team','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 11:53:17','updated_at' => '2023-03-06 11:53:17'),
            array('id' => '5','title' => 'Bessie Cooper','slug' => 'Vp People','type' => 'team','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 11:54:06','updated_at' => '2023-03-06 11:54:06'),
            array('id' => '6','title' => 'Eleanor Pena','slug' => 'Head of Design','type' => 'team','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 11:54:44','updated_at' => '2023-03-06 11:54:44'),
            array('id' => '7','title' => 'Rhonda Ortiz','slug' => 'Founder & CO','type' => 'team','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 11:55:23','updated_at' => '2023-03-06 11:55:23'),
            array('id' => '8','title' => '8 Things About Web Design Your Boss Wants To Know','slug' => '8-things-about-web-design-your-boss-wants-to-know','type' => 'blog','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 12:50:45','updated_at' => '2023-11-23 04:49:22'),
            array('id' => '9','title' => '6 Tips for Personal Selling that Guarantee Success in 2023','slug' => '6-tips-for-personal-selling-that-guarantee-success-in-2023','type' => 'blog','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 12:57:44','updated_at' => '2023-11-23 04:47:47'),
            array('id' => '10','title' => 'How Chatbots Can Help You Drive More Sales','slug' => 'how-chatbots-can-help-you-drive-more-sales','type' => 'blog','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 13:00:52','updated_at' => '2023-11-23 04:47:16'),
            array('id' => '12','title' => 'Michael','slug' => 'Founder & CEO Dulalix','type' => 'testimonial','status' => '1','featured' => '1','lang' => '5','created_at' => '2023-03-06 13:23:24','updated_at' => '2024-06-13 06:09:23'),
            array('id' => '13','title' => 'Jane Dock','slug' => 'Founder of Dulalix','type' => 'testimonial','status' => '1','featured' => '1','lang' => '5','created_at' => '2023-03-06 13:24:12','updated_at' => '2024-06-13 06:09:11'),
            array('id' => '14','title' => 'Jhone Doe','slug' => 'Founder & CEO Dulalix','type' => 'testimonial','status' => '1','featured' => '1','lang' => '5','created_at' => '2023-03-06 13:24:59','updated_at' => '2024-06-13 06:04:46'),
            array('id' => '15','title' => 'Financial Services','slug' => 'financial-services','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 13:30:09','updated_at' => '2023-03-06 13:30:09'),
            array('id' => '16','title' => 'What is a Social Set?','slug' => 'what-is-a-social-set','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 13:31:09','updated_at' => '2024-08-03 05:40:53'),
            array('id' => '17','title' => 'Apply job or hire','slug' => 'apply-job-or-hire','type' => 'feature','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 16:24:43','updated_at' => '2023-10-07 03:25:49'),
            array('id' => '18','title' => 'Complete your profile','slug' => 'complete-your-profile','type' => 'feature','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 17:15:36','updated_at' => '2023-10-07 03:24:57'),
            array('id' => '19','title' => 'Create Account','slug' => 'create-account','type' => 'feature','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 17:32:24','updated_at' => '2023-10-07 03:24:08'),
            array('id' => '23','title' => 'Automatically sync in real time','slug' => 'automatically-sync-in-real-time','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-04-09 13:39:14','updated_at' => '2024-08-18 06:08:31'),
            array('id' => '24','title' => 'Do I need a credit card to sign up?','slug' => 'top','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-04-09 13:39:50','updated_at' => '2023-04-09 13:39:50'),
            array('id' => '25','title' => 'Free 10 Days Trial','slug' => 'free-10-days-trial','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-04-09 13:40:59','updated_at' => '2024-08-18 06:08:52'),
            array('id' => '26','title' => 'Terms and conditions','slug' => 'terms-and-conditions','type' => 'page','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-04-09 13:40:59','updated_at' => '2023-04-09 13:40:59'),
            array('id' => '27','title' => 'Privacy Policy','slug' => 'privacy-policy','type' => 'page','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-10-07 23:55:19','updated_at' => '2023-10-07 23:55:19'),
            array('id' => '28','title' => 'Jane Doe','slug' => 'Founder & CEO Taboola','type' => 'testimonial','status' => '1','featured' => '1','lang' => '5','created_at' => '2023-03-06 13:24:59','updated_at' => '2024-06-13 06:08:55')
          );
        Post::insert($posts);
    }
}
