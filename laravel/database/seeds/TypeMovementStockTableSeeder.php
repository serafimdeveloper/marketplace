<?php
use App\Model\TypeMovementStock;
use Illuminate\Database\Seeder;

class TypeMovementStockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!TypeMovementStock::find(1)){
            factory(TypeMovementStock::class, 4)->create();
        }
    }
}
