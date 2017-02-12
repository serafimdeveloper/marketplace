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
        $this->call(FreightTableSeeder::class);
        $this->call(PaymentTableSeeder::class);
        $this->call(TypeMovementStockTableSeeder::class);
        $this->call(CountOrderTableSeeder::class);
        $this->call(SalesmanTableSeeder::class);
        $this->call(StoreTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ProductRequestTableSeeder::class);
        $this->call(MessageTypeTableSeeder::class);
       // $this->call(MessageTableSeeder::class);

    }
}
