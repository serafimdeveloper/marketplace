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
        if(!RequestStatus::find(1)){
            for($i = 0; $i < 8; $i++){
                factory(RequestStatus::class)->create();
            }

        }
    }
}
