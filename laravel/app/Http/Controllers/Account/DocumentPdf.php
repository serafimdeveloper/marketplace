<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Model\Seller;
use Auth;
use Correios;
use Illuminate\Support\Facades\Storage;

class DocumentPdf extends Controller {
    public function index($pdf){
        $file = storage_path('app/pdf/vendedor/'. $pdf . '.pdf');
        header('Content-Type: application/pdf');
        if(file_exists($file)){
            $id = (int) substr($pdf, -5);

            if($sallesman = Seller::find($id) && $user = Auth::user()){
                echo 'osdasd';
            }
        }
    }
}

	