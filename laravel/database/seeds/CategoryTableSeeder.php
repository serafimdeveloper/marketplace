<?php
use App\Model\Category;
use App\Model\Product;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 3)->create()->each(function($c){
            for($z = 0; $z < 4; $z++){
                $c->subcategories()->save(factory(Category::class)->make());
//                $c->products()->save(factory(Product::class)->make());
            }
        });
    }
}
