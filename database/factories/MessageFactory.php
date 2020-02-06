<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {

    $allUsers=\App\User::all()->pluck('id')->toArray();
    $allMsgs=Message::all()->pluck('id');

    if (count($allMsgs) <= 30) {
       $allMsgs=[0];
    } else {
        $allMsgs=$allMsgs->toArray();
    }

    return [
        'author_id' => $faker->randomElement($allUsers),
        'parent_id' => $faker->randomElement($allMsgs),
        'text' => $faker->text(100),
        'images' => $faker->imageUrl(100,100),
        'created_at' => $faker->dateTimeThisYear,
        'updated_at' => $faker->dateTimeThisYear,
    ];
});
