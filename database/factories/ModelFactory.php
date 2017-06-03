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

/*$factory->define(Seracademico\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});*/

$factory->define(Seracademico\Entities\CGM::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
        'cpf_cnpj' => $faker->numberBetween(10000, 99999).$faker->numberBetween(100000, 999999),
        'numero_sus' => $faker->numberBetween(1000, 9999).$faker->numberBetween(1000, 9999),
    ];
});