<?php
use App\Model\Galery;
use App\Model\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 2)->create()->each(function($g){
            for($i = 0; $i < 5; $i++){
                $g->galery()->save(factory(Galery::class)->make());
            }
        });
    }
}
