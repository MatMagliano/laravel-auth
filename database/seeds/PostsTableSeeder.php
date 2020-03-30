<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Post;
use App\User;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 10; $i++) { 
        $newPost = new Post;
        $newPost->title = $faker->sentence(3);
        $newPost->body= $faker->text(255); 
        $newPost->slug = Str::finish(Str::slug($newPost->title), rand(1, 1000000));
        $newPost->user_id = 1;
        $newPost->save();
        }
    }
}
