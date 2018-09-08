<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageController extends Controller
{
    const DR = DIRECTORY_SEPARATOR;

    private $server;

    public function __construct(Filesystem $filesystem)
    {
        $this->server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => $filesystem->getDriver(),
            'cache' => $filesystem->getDriver(),
            'source_path_prefix' =>  self::DR . 'img',
            'cache_path_prefix' =>  self::DR . 'img' . self::DR . 'cache',
            'base_url' => 'imagem',
            'driver' => 'gd'
        ]);


    }

    public function show($path){
        if(Storage::exists('img'.self::DR.$path)) {
            return $this->server->getImageResponse($path, request()->all());
        }
        throw new NotFoundHttpException('Erro ao encontrar a imagem');

    }

    public function deleteCache($path){
        return $this->server->deleteCache($path);
    }
}
