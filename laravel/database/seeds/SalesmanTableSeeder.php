<?php
use App\Model\Salesman;
use Illuminate\Database\Seeder;

class SalesmanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Salesman::class, 3)->create();
    }
}
