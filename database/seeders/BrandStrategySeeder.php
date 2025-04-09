<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BrandStrategy;
class BrandStrategySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $brand_strategies = array(
            array('id' => '1','category_id' => '94','body' => 'Expand the range of art products and services to include various mediums, styles, and formats. This strategy involves collaborating with a diverse group of artists, offering a broad selection of artworks, and incorporating different forms such as paintings, sculptures, digital art, and installations. The goal is to attract a wide audience and cater to varied artistic tastes.','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 18:32:18'),
            array('id' => '2','category_id' => '92','body' => 'Focus on delivering personalized web design solutions tailored to each client\'s specific needs and goals. This strategy involves in-depth consultations, custom design processes, and ongoing client feedback to ensure that every project is uniquely crafted to meet the client\'s vision and business objectives.','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 18:33:34'),
            array('id' => '3','category_id' => '93','body' => 'Implement agile methodologies to enhance flexibility, collaboration, and efficiency in software development. This strategy involves adopting iterative development cycles, regular client feedback, and adaptive planning to quickly respond to changes and deliver high-quality software solutions.','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 18:34:56'),
            array('id' => '4','category_id' => '94','body' => 'Develop a robust online platform to showcase and sell art, including a user-friendly website, social media channels, and online galleries. This strategy focuses on digital marketing, e-commerce integration, and virtual exhibitions to reach a global audience, increase visibility, and drive sales through online engagement.','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 18:32:31'),
            array('id' => '5','category_id' => '94','body' => 'Build and nurture relationships within the art community through events, collaborations, and partnerships. This strategy includes hosting art workshops, exhibitions, and artist talks, as well as forming alliances with local and international art institutions. The aim is to create a vibrant community around the company, support artists, and foster a strong network of art enthusiasts.','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 18:32:44'),
            array('id' => '6','category_id' => '93','body' => 'Provide end-to-end support throughout the software lifecycle, from initial consulting to post-launch maintenance. This strategy involves offering services such as project management, quality assurance, user training, and ongoing technical support to ensure client satisfaction and long-term success.','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 18:35:18'),
            array('id' => '7','category_id' => '94','body' => 'Create unique and immersive art experiences that go beyond traditional gallery settings. This strategy involves developing interactive art installations, augmented reality experiences, and pop-up art events. By offering novel and engaging ways for audiences to experience art, the company can differentiate itself and attract new visitors.','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 18:32:58'),
            array('id' => '8','category_id' => '93','body' => 'Invest in creating and launching proprietary software products or platforms that address market needs. This strategy includes identifying gaps in the market, developing unique solutions, and leveraging these products to generate revenue, build brand recognition, and attract new clients.','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 18:35:37'),
            array('id' => '9','category_id' => '92','body' => 'Stay ahead of industry trends by incorporating the latest web technologies and design practices. This strategy includes adopting responsive design, optimizing for mobile devices, utilizing advanced web development frameworks, and integrating interactive elements to create modern and high-performing websites.','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 18:33:51'),
            array('id' => '10','category_id' => '92','body' => 'Build a strong and diverse portfolio showcasing a range of successful web design projects. This strategy involves regularly updating the portfolio with new and notable work, highlighting case studies and client testimonials, and demonstrating the company’s expertise across various industries and design styles.','status' => 'active','created_at' => '2024-08-02 15:58:36','updated_at' => '2024-08-11 18:34:06')
          );

          BrandStrategy::insert($brand_strategies);  
    }
}
