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
        TypeMovementStock::insert([
            ['name' => 'Inclusão', 'description' => 'Inclusão no estoque pelo vendedor', 'type' => 'in', 'active' => 1],
            ['name' => 'Saída', 'description' => 'Venda concluída', 'type' => 'out', 'active' => 1],
            ['name' => 'Estorno', 'description' => 'Venda cancelada', 'type' => 'in', 'active' => 1],
            ['name' => 'Retirada', 'description' => 'Redução de estoque pelo vendedor', 'type' => 'out', 'active' => 1]
        ]);

    }
}
