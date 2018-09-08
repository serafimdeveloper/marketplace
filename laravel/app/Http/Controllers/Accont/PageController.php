<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:48
 */

namespace App\Http\Controllers\Accont;


use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Model\Page;

class PageController extends Controller {
    private $page;

    public function __construct(Page $page){
        $this->page = $page;
    }

    public function index(){
        $pages = $this->page->paginate(10);
        return view('accont.pages', compact('pages'));
    }

    public function show($id){
        $pages = $this->page->find($id);
        return view('accont.page', compact('pages'));
    }

    public function update($id, PageRequest $pageRequest){
        if($page = $this->page->find($id)->update($pageRequest->all())){
            flash('Página atualizada!', 'accept');
        }
        $pages = $this->page->find($id);
        return view('accont.page', compact('pages'));
    }

    public function with_pay($page){
        $pg = new Page;
        $page = $pg->where('slug', '=', $page)->first();
        return view('pages.dinamic', compact('page'));
    }

}