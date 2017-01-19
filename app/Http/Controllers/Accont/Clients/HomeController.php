<?php
	namespace App\Http\Controllers\Accont\Clients;

	use App\Http\Controllers\Controller;
	use Auth;
	use App\Http\Requests\Accont\Clients\HomeStoreRequest;

	class HomeController extends Controller
	{

		public function index(){
			$user = Auth::User();
			return view('accont.home', compact('user'));
		}

		public function store(HomeStoreRequest $request){
			$input = $request->all();
			$user = Auth::User()->fill($input);
			$user->save();
			return view('accont.home', compact('user'));
		}
	}
