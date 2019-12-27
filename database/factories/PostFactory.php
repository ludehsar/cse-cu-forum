<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'subtitle' => $faker->sentence,
        'category_id' => 1,
        'user_id' => 1,
        'slug' => $faker->unique()->sentence,
        'description' => $faker->paragraph,
        'is_published' => 1
    ];
});
