<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 12/04/2017
 * Time: 20:24
 */

namespace App\Http\Controllers\Accont\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

abstract class AbstractAdminController extends Controller
{
    protected $repo;
    protected $with = [];
    protected $columns = ['*'];
    protected $where = [];
    protected $ordy = [];
    protected $title = '';
    protected $placeholder = '';
    protected $limit = 15;

    protected function search($request, $type){
        $page = Input::get('page') ? Input::get('page') : 1 ;
        $result = $this->repo->search($request->name, $this->columns, $this->where, $this->with, $this->ordy, $this->limit, $page);
        return ['type' => $type, 'result' => $result, 'title' => $this->title, 'placeholder' => $this->placeholder];

    }

    protected function getByRepoId($id){
        if($result = $this->repo->get($id,$this->columns,$this->with)){
            return $result;
        }
        return false;
    }

}