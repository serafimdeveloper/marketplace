<?php
use App\Model\RequestStatus;
use Illuminate\Database\Seeder;

class RequestStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RequestStatus::insert([
            ['description' => 'Aguardando pagamento', 'trigger' => 'warning'],
            ['description' => 'Compra incompleta', 'trigger' => 'error'],
            ['description' => 'Aguardando envio', 'trigger' => 'warning'],
            ['description' => 'Aguardando chegada', 'trigger' => 'notice'],
            ['description' => 'Aguardando avaliação', 'trigger' => 'notice'],
            ['description' => 'Negociação concluído', 'trigger' => 'accept'],
            ['description' => 'Pedido devolvido', 'trigger' => 'default'],
            ['description' => 'Compra cancelada', 'trigger' => 'error']
        ]);
    }
}
