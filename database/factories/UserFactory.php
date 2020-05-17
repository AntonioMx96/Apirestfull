<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Product;
use App\Seller;
use App\Transaction;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'verified'=>$verificado = $faker->randomElement([User::USUARIO_VERIFICADO, User::USUARIO_NO_VERIFICADO],1),
        'verification_token'=> $verificado == User::USUARIO_VERIFICADO ? null : User::generarVerificacionToken(),
        'admin' => $faker->randomElement([User::USUARIO_ADMINISTRADOR, User::USUARIO_REGULAR],1),


    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'description' => $faker->paragraph(1),
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'description' => $faker->paragraph(1),
        'quantity'=>$faker->numberBetween(1,10),
        'status'=>$faker->randomElement([Product::PRODUCTO_DISPONIBLE, Product::PRODUCTO_NO_DISPONIBLE],1),
        'image'=>$faker->randomElement(['1.jpg', '2.jpg', '3.jpg'],1),
        'seller_id'=>User::all()->random()->id,
    ];
});

$factory->define(Transaction::class, function (Faker $faker) {
    $vendedores = Seller::has('products')->get()->random();
    $comprador = User::all()->except($vendedores->id)->random();
    return [
        'quantity'=>$faker->numberBetween(1,3),
        'buyer_id' => $comprador->id,
        'product_id' => $vendedores->products->random()->id,
    ];
});