<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class FreightController extends Controller{
    public function toCalculate(Request $request){
        dd($request->all());
    }
}
