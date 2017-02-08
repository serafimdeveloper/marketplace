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
        factory(Category::class, 2)->create()->each(function($c){
            for($i = 0; $i < 4; $i++){
                $c->subcategories()->save(factory(Category::class)->make());
                $c->products()->save(factory(Product::class)->make());
            }
        });
    }
}
