<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'nama' => $faker->name,
        'email' => $faker->email,
        'alamat' => $faker->address,
        'telp' => $faker->phoneNumber,
    ];
});
