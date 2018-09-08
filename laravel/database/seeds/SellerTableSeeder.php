<?php
use App\Model\Seller;
use Illuminate\Database\Seeder;

class SellerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Seller::class, 3)->create(['active' => 1]);
    }
}
