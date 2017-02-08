<?php
use App\Model\ProductRequest;
use Illuminate\Database\Seeder;

class ProductRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ProductRequest::class, 3)->create();
    }
}
