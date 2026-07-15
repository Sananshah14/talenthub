<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $skills = [

            'PHP',
            'Laravel',
            'JavaScript',
            'TypeScript',
            'React',
            'Angular',
            'Vue.js',
            'Node.js',
            'Express.js',
            'Python',
            'Django',
            'Java',
            'Spring Boot',
            'C#',
            '.NET',
            'HTML',
            'CSS',
            'Tailwind CSS',
            'Bootstrap',
            'MySQL',
            'PostgreSQL',
            'MongoDB',
            'Redis',
            'Docker',
            'Kubernetes',
            'Git',
            'GitHub',
            'REST API',
            'GraphQL',
            'AWS',
            'Azure',
            'Google Cloud',
            'Linux',
            'CI/CD',

        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                [
                    'name' => $skill,
                ],

                [
                    'name' => $skill,
                ]
            );
        }

    }
}
