<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 21:25
 */

namespace App\Repositories\Accont;

use App\Model\Notification;
use App\Repositories\BaseRepository;

class NotificationRepository extends BaseRepository {
    public function model(){
        return Notification::class;
    }
}