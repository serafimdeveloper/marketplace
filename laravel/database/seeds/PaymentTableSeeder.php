<?php
use App\Model\Payment;
use Illuminate\Database\Seeder;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Payment::find(1)){
            factory(Payment::class, 3)->create();
        }
    }
}
