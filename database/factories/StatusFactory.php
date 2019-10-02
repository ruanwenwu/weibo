<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Status;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Status::class, function (Faker $faker) {
    $dateTime = Carbon::now();
    return [
        'content'       =>  $faker->text(),
        'created_at'    =>  $dateTime,
        'updated_at'    =>  $dateTime,
    ];
});
