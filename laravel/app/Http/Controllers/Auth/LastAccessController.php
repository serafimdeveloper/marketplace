<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;

class LastAccessController{
    public function handle($event) {
        $user = $event->user;
        $user->last_access = Carbon::now();
        $user->save();
    }
}
