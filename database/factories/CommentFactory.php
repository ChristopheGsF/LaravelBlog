<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
      'content' => $faker->text,
      'article_id' => function () {
          return factory(App\Article::class)->create()->id;
        },
        'user_id' => function () {
              return factory(App\User::class)->create()->id;
          }
    ];
});
