<?php
use App\Model\TypePayment;
use Illuminate\Database\Seeder;

class TypePaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypePayment::insert([
            ['name' => 'Cartão Cŕedito', 'active' => 1],
            ['name' => 'Boleto', 'active' => 1],
            ['name' => 'Moip', 'active' => 1]
        ]);
    }
}
