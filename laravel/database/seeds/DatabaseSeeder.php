<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(RequestStatusTableSeeder::class);
        $this->call(TypeFreightTableSeeder::class);
        $this->call(TypePaymentTableSeeder::class);
        $this->call(TypeMovementStockTableSeeder::class);
        $this->call(CountOrderTableSeeder::class);
        $this->call(SellerTableSeeder::class);
        $this->call(StoreTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ProductRequestTableSeeder::class);
       // $this->call(MessageTableSeeder::class);
    }
}
