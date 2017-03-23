<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:48
 */
namespace App\Http\Controllers;
class ContatcController extends Controller{

    public function indexGet(){
        return view('pages.contact');
    }

    public function indexPost(){
        return view('pages.contact');
    }
}