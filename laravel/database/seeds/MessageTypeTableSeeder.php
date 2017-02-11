<?php
use App\Model\MessageType;
use Illuminate\Database\Seeder;

class MessageTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!MessageType::find(1)){
            factory(MessageType::class, 8)->create();
        }
    }
}
