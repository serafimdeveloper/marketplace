<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 21:28
 */

namespace App\Repositories\Accont;


use App\Repositories\BaseRepository;
use App\Model\Message;

class MessagesRepository extends BaseRepository
{

    public function model()
    {
        return Message::class;
    }
}