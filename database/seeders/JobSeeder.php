<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $jobs = array(
         array('id' => '1','title' => 'Product Designer','slug' => 'product-designer','location' => 'Newark, NJ','type' => 'Full-time','expert_level' => 'Senior','description' => '<div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Job Responsibilities</h4>
                                               <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                                  suffered alteration in some form, by injected humour, or randomised words which don\'t
                                                  look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Job Requirements</h4>
                                               <p class="pb-15">There are many variations of passages of Lorem Ipsum available, but the
                                                  majority have suffered alteration in some form, by injected humour, or randomised words
                                                  which don\'t look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        5+ years experience in backend engineering, <br>
                                                        ideally in Python or Node
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience building and operating backend <br>
                                                        distributed systems
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience designing serverless architectures <br>
                                                        on AWS infrastructure
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Our Benefits</h4>
                                               <p class="pb-15">Now, the paradigm has shifted. The question is not why you should include
                                                  a content marketing strategy.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Flexible hours
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Unlimited PTO
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Medical insurance
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Career growth
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-20">
                                               <h4 class="career-details-title-sm">Job Requirements</h4>
                                               <p class="pb-15">There are many variations of passages of Lorem Ipsum available, but the
                                                  majority have suffered alteration in some form, by injected humour, or randomised words
                                                  which don\'t look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience building software and systems that balance <br> simplicity,
                                                        flexibility, and security.
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Track record with a smart contract language <br> such as Solidity
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        A customer-focused and product-focused mindset.
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity">
                                               <h4 class="career-details-title-sm">Education & Experience</h4>
                                               <p>TBachelors Degree in Interaction, Graphic Design, Media Arts or similar.</p>
                                            </div>','is_active' => '1','meta' => '{"title":"Product Designer","image":null,"description":"Product Designer Description","tags":"SEO Meta Tags"}','created_at' => '2024-01-07 10:06:58','updated_at' => '2024-06-19 18:07:38'),
         array('id' => '2','title' => 'Software Engineer','slug' => 'software-engineer','location' => 'Newark, NJ','type' => 'Full-time','expert_level' => 'Senior','description' => '<div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Job Responsibilities</h4>
                                               <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                                  suffered alteration in some form, by injected humour, or randomised words which don\'t
                                                  look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Job Requirements</h4>
                                               <p class="pb-15">There are many variations of passages of Lorem Ipsum available, but the
                                                  majority have suffered alteration in some form, by injected humour, or randomised words
                                                  which don\'t look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        5+ years experience in backend engineering, <br>
                                                        ideally in Python or Node
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience building and operating backend <br>
                                                        distributed systems
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience designing serverless architectures <br>
                                                        on AWS infrastructure
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Our Benefits</h4>
                                               <p class="pb-15">Now, the paradigm has shifted. The question is not why you should include
                                                  a content marketing strategy.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Flexible hours
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Unlimited PTO
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Medical insurance
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Career growth
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-20">
                                               <h4 class="career-details-title-sm">Job Requirements</h4>
                                               <p class="pb-15">There are many variations of passages of Lorem Ipsum available, but the
                                                  majority have suffered alteration in some form, by injected humour, or randomised words
                                                  which don\'t look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience building software and systems that balance <br> simplicity,
                                                        flexibility, and security.
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Track record with a smart contract language <br> such as Solidity
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        A customer-focused and product-focused mindset.
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity">
                                               <h4 class="career-details-title-sm">Education & Experience</h4>
                                               <p>TBachelors Degree in Interaction, Graphic Design, Media Arts or similar.</p>
                                            </div>','is_active' => '1','meta' => '{"title":"Software Engineer","image":null,"description":"Product Designer Description","tags":"SEO Meta Tags"}','created_at' => '2024-01-07 10:06:58','updated_at' => '2024-06-19 18:07:38'),
         array('id' => '3','title' => 'Product Manager','slug' => 'product-manager','location' => 'Newark, NJ','type' => 'Full-time','expert_level' => 'Senior','description' => '<div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Job Responsibilities</h4>
                                               <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                                  suffered alteration in some form, by injected humour, or randomised words which don\'t
                                                  look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Job Requirements</h4>
                                               <p class="pb-15">There are many variations of passages of Lorem Ipsum available, but the
                                                  majority have suffered alteration in some form, by injected humour, or randomised words
                                                  which don\'t look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        5+ years experience in backend engineering, <br>
                                                        ideally in Python or Node
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience building and operating backend <br>
                                                        distributed systems
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience designing serverless architectures <br>
                                                        on AWS infrastructure
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Our Benefits</h4>
                                               <p class="pb-15">Now, the paradigm has shifted. The question is not why you should include
                                                  a content marketing strategy.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Flexible hours
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Unlimited PTO
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Medical insurance
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Career growth
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-20">
                                               <h4 class="career-details-title-sm">Job Requirements</h4>
                                               <p class="pb-15">There are many variations of passages of Lorem Ipsum available, but the
                                                  majority have suffered alteration in some form, by injected humour, or randomised words
                                                  which don\'t look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience building software and systems that balance <br> simplicity,
                                                        flexibility, and security.
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Track record with a smart contract language <br> such as Solidity
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        A customer-focused and product-focused mindset.
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity">
                                               <h4 class="career-details-title-sm">Education & Experience</h4>
                                               <p>TBachelors Degree in Interaction, Graphic Design, Media Arts or similar.</p>
                                            </div>','is_active' => '1','meta' => '{"title":"Product Manager","image":null,"description":"Product Designer Description","tags":"SEO Meta Tags"}','created_at' => '2024-01-07 10:06:58','updated_at' => '2024-06-19 18:07:38'),
         array('id' => '4','title' => 'DevOps Engineer','slug' => 'devops-engineer','location' => 'Newark, NJ','type' => 'Full-time','expert_level' => 'Senior','description' => '<div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Job Responsibilities</h4>
                                               <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                                  suffered alteration in some form, by injected humour, or randomised words which don\'t
                                                  look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Job Requirements</h4>
                                               <p class="pb-15">There are many variations of passages of Lorem Ipsum available, but the
                                                  majority have suffered alteration in some form, by injected humour, or randomised words
                                                  which don\'t look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        5+ years experience in backend engineering, <br>
                                                        ideally in Python or Node
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience building and operating backend <br>
                                                        distributed systems
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience designing serverless architectures <br>
                                                        on AWS infrastructure
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-45">
                                               <h4 class="career-details-title-sm">Our Benefits</h4>
                                               <p class="pb-15">Now, the paradigm has shifted. The question is not why you should include
                                                  a content marketing strategy.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Flexible hours
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Unlimited PTO
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Medical insurance
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Career growth
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity mb-20">
                                               <h4 class="career-details-title-sm">Job Requirements</h4>
                                               <p class="pb-15">There are many variations of passages of Lorem Ipsum available, but the
                                                  majority have suffered alteration in some form, by injected humour, or randomised words
                                                  which don\'t look even slightly believable. If you are going to use a passage
                                                  of Lorem Ipsum,anything embarrassing hidden.</p>
                                               <div class="career-details-job-list">
                                                  <ul>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Experience building software and systems that balance <br> simplicity,
                                                        flexibility, and security.
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        Track record with a smart contract language <br> such as Solidity
                                                     </li>
                                                     <li>
                                                        <i class="fal fa-long-arrow-right"></i>
                                                        A customer-focused and product-focused mindset.
                                                     </li>
                                                  </ul>
                                               </div>
                                            </div>
                                            <div class="career-details-job-responsiblity">
                                               <h4 class="career-details-title-sm">Education & Experience</h4>
                                               <p>TBachelors Degree in Interaction, Graphic Design, Media Arts or similar.</p>
                                            </div>','is_active' => '1','meta' => '{"title":"DevOps Engineer","image":null,"description":"Product Designer Description","tags":"SEO Meta Tags"}','created_at' => '2024-01-07 10:06:58','updated_at' => '2024-06-19 18:07:38')
       );  
      Job::insert($jobs);
    }
}
