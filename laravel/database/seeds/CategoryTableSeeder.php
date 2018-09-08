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
        factory(Category::class, 5)->create()->each(function($c){
            factory(Category::class, 5)->create(['category_id' => $c->id]);
        });
    }
}
