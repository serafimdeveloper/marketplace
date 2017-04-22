<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:48
 */

namespace App\Http\Controllers\Accont;


use App\Http\Controllers\Controller;
use App\Model\Page;

class PageController extends Controller {

    public function with_pay($page){
        $pg = new Page;
        $page = $pg->where('slug', '=', $page)->first();
        return view('pages.dinamic', compact('page'));
    }

}