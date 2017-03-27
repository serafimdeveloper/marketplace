<?php

use App\Model\Request;

$requests = Request::where('request_status_id',4)->get();
