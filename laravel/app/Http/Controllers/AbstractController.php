<?php
namespace App\Http\Controllers;

use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Storage;


abstract class AbstractController extends Controller
{
    /**
     * Columns default to get and all.
     * @var array
     */
    protected $columns = ['*'];

    /**
     * Where condicions
     * @var array
     */
    protected $where = [];

    /**
     * With relationships.
     * @var array
     */
    protected $with = [];

    /**
     * Load relationships.
     * @var array
     */
    protected $load = [];

    /**
     * Container.
     * @var Container
     */
    protected $app;

    /**
     * Repository.
     * @var \App\Repositories\BaseRepository
     */
    protected $repo;

    /**
     * Constrcut.
     * @param App        $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->repo = $app->make($this->repo());
    }

    abstract public function repo();

    protected function upload($arquivo,$path,$nome){
        if($arquivo->isValid()){
            $nomeArquivo = $nome.'.'.$arquivo->extension();
            $arquivo->move(storage_path('app/'.$path),$nomeArquivo);
//            Storage::putFileAs($path, $arquivo, $nomeArquivo);
            return $nomeArquivo;
        }
    }
}
