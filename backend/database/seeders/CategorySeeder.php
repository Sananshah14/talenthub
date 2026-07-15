<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [

            [
                'name' => 'Software Development',
                'description' => 'Software engineering and application development.'
            ],

            [
                'name' => 'Web Development',
                'description' => 'Frontend and backend web development jobs.'
            ],

            [
                'name' => 'Mobile Development',
                'description' => 'Android and iOS application development.'
            ],

            [
                'name' => 'DevOps',
                'description' => 'Infrastructure, CI/CD and cloud engineering.'
            ],

            [
                'name' => 'Data Science',
                'description' => 'Machine learning, AI and data analytics.'
            ],

            [
                'name' => 'Cyber Security',
                'description' => 'Information security and penetration testing.'
            ],

            [
                'name' => 'UI/UX Design',
                'description' => 'User interface and user experience design.'
            ],

            [
                'name' => 'Quality Assurance',
                'description' => 'Software testing and quality assurance.'
            ],

        ];

        foreach ($categories as $category) {

            Category::updateOrCreate(

                [
                    'name' => $category['name'],
                ],

                $category

            );
        }
    }
}
