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
use App\Model\Adress;
use App\Model\Category;
use App\Model\Product;
use App\Model\Salesman;
use App\Model\Store;
use App\Model\User;
use Faker\Generator;
use FontLib\Table\Type\name;

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birth' => $faker->date('Y-m-d','now'),
        'genre' => $faker->randomElement(array('M','F')),
        'phone' => $faker->numerify('(##) ####-####'),
        'cpf' => $faker->unique()->numerify('###.###.###-##'),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'confirm_token' => str_random(20),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Salesman::class, function(Generator $faker){
    $folder = DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . 'vendedor';
    return [
        'user_id' => function(){
            return factory(User::class, 1)->create()->id;
        },
        'moip' => function (array $post) {
            return User::find($post['user_id'])->name;
        },
        'cpf' => function (array $post) {
            return User::find($post['user_id'])->cpf;
        },
        'facebook' => $faker->url,
        'phone' => $faker->numerify('(##) ####-####'),
        'whatsapp' => $faker->cellphoneNumber,
        'cellphone' => $faker->cellphoneNumber,
        'photo_document' => $faker->image(storage_path(). $folder, 640, 480, 'cats', false),
        'proof_adress' => $faker->image(storage_path() . $folder, 640, 480, 'cats', false),
        'active' => 0
    ];
});

$factory->define(Store::class, function(Generator $faker){
    $folder = DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . 'loja';
    return [
        'salesman_id' => function(){
            return factory(Salesman::class, 1)->create()->id;
        },
        'name' => $faker->word(),

        'type_salesman' => $faker->randomElement(array('F','J')),
//        'cpf' => function (array $post) {
//            return User::find(Salesman::find($post['salesman_id'])->id)->cpf;
//        },
        'cnpj' => $faker->numerify('##.###.###/####-##'),
        'fantasy_name' => $faker->unique()->sentence(2),
        'social_name' => $faker->unique()->name . ' ltda',
        'slug' => $faker->unique()->slug,
        'about' => $faker->sentence(20),
        'exchange_policy' => $faker->sentence(40),
        'freight_policy' => $faker->sentence(25),
        'logo_file' => $faker->image(storage_path(). $folder, 640, 480, 'cats', false),
        'rate' => $faker->randomFloat(2, 0, 5),
        'active' => 0
        ];
    });
$factory->define(Adress::class, function(Generator $faker){
    return [
        'user_id' => function(){
            return factory(User::class, 1)->create()->id;
        },
        'store_id' => null,
        'name' => $faker->name,
        'zip_code' => $faker->postcode,
        'state' => $faker->stateAbbr,
        'city' => $faker->city,
        'public_place' => $faker->streetName,
        'neighborhood' => $faker->word,
        'number' => $faker->buildingNumber,
        'complements' => null,
        'master' => 0
    ];
});

$factory->define(Category::class, function(Generator $faker){
    return [
        'name' => $faker->word(6),
        'category_id' => function(){

        },
        'menu' => 0,
        'active' => 1
    ];
});