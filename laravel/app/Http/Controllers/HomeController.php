<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;

class HomeController extends Controller{

    public function index(){
        return view('pages.homepage');
    }
}
