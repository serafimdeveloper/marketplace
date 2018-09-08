<?php
use App\Model\Gallery;
use App\Model\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        factory(Product::class, 20)->create()->each(function($p){
            factory(Gallery::class, 3)->create(['product_id' => $p->id]);
        });
    }
}
