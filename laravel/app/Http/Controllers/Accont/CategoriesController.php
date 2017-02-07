<?php

namespace App\Http\Controllers\Accont;


use App\Http\Controllers\AbstractController;
use App\Http\Requests\Request;
use App\Repositories\Accont\CategoriesRepository;

class CategoriesController extends AbstractController
{
    public function repo(){
        return CategoriesRepository::class;
    }

    public function index(){
        $categories = $this->repo->all($this->columns,$this->with);
        return view('accont.categories', compact('categories'));
    }

    public function store(Request $request){

    }

}