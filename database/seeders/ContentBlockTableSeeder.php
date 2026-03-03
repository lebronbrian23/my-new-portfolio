<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentBlockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $welcome_content = \App\Models\ContentBlock::create([
            'content_block_section' => 'home',
            'title' => 'Welcome to My Portfolio',
            'description' => 'I am a passionate software developer with a knack for creating innovative solutions. With a strong background in web development, I specialize in building dynamic and responsive applications that deliver exceptional user experiences. Explore my projects and skills to see how I can contribute to your next venture.',
            'user_id' => \App\Models\User::first()->id ?? 1,
        ]);
    }
}
