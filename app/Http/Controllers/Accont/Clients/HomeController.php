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
			return view('accont.home', compact('user'));
		}

		public function store(HomeStoreRequest $request){
			$input = $request->all();
			$user = Auth::User()->fill($input);
			$user->save();
			flash('Dados atualizado com sucesso!', 'accept');	
			return view('accont.home', compact('user'));
		}

		public function change_password(ChangePasswordRequest $request){
			$user = Auth::User();
			if(Auth::attempt(['email'=>$user->email, 'password'=>$request->get('password')])){
				$user->fill(['password'=> bcrypt($request->get('newpassword'))]);
				$user->save();
				flash('Senha alterada com sucesso!', 'accept');			
				return view('accont.home', compact('user'));
			}
			flash('Ocorreu um erro ao alterar a senha!', 'error');	
			return view('accont.home', compact('user'));

		}
	}

