<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::all()->first();
        $posts = $user->posts()->get();

        $tags = $user->tags()->take(3)->get();
        $tag_ids = $tags->pluck('id')->toArray();

        foreach ($posts as $post) {
            $post->tags()->attach($tag_ids);
        }
    }
}
