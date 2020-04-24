<?php

use App\Category;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
   //DB::statement('SET FOREIGN_KEYS_CHECKS = 0');
   DB::statement("SET foreign_key_checks=0");

       $cantidadusuarios=200;
       $cantidadcategorias=30;
       $productos=1000;
       $transacciones =1000;
       DB::table('category_protuct');
      
       factory(User::class, $cantidadusuarios)->create();
       factory(Category::class, $cantidadcategorias)->create();
       
       factory(Product::class, $productos)->create()->each(
           function($producto){
               $categorias = Category::all()->random(mt_rand(1,5))->pluck('id');
               $producto->categories()->attach($categorias);
           }
       );
       
       factory(Transaction::class, $transacciones)->create();
    }
}
