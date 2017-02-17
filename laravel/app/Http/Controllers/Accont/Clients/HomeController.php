<?php
	namespace App\Http\Controllers\Accont\Clients;

	use App\Http\Controllers\Controller;
	use Auth;
 	use App\Http\Requests\Accont\Clients\HomeStoreRequest;
	use App\Http\Requests\Accont\Clients\ChangePasswordRequest;

	class HomeController extends Controller
	{

		public function index(){
			$user = Auth::User();
			$collection = $user->addresses->sortByDesc(function($adress, $key){
				return $adress->master;
			});
			$adresses = $collection->values()->all();
			return view('accont.home', compact('user','adresses'));
		}

		public function store(HomeStoreRequest $request){
//            dd($request);
			$input = $request->all();
			$user = Auth::User()->fill($input);
			$user->save();
			flash('Dados atualizado com sucesso!', 'accept');	
			return redirect()->route('accont.home');
		}

		public function change_password(ChangePasswordRequest $request){
			$user = Auth::User();
			if(Auth::attempt(['email'=>$user->email, 'password'=>$request->get('password')])){
				$user->fill(['password'=> bcrypt($request->get('newpassword'))]);
				$user->save();
				flash('Senha alterada com sucesso!', 'accept');
                return redirect()->route('accont.home');
			}
			flash('Ocorreu um erro ao alterar a senha!', 'error');
            return redirect()->route('accont.home');

		}
	}

