<?php
	namespace App\Http\Controllers\Account\Clients;

	use App\Http\Controllers\Controller;
	use Auth;
 	use App\Http\Requests\Account\Clients\HomeStoreRequest;
	use App\Http\Requests\Account\Clients\ChangePasswordRequest;
    use Illuminate\Support\Facades\Gate;

    class HomeController extends Controller
	{
        public function index(){
            if(Gate::denies('is_active')){
                return redirect()->route('page.confirm_account');
            }
			$user = Auth::User();
			$collection = $user->addresses->sortByDesc(function($address, $key){
				return $address->master;
			});
			$addresses = $collection->values()->all();
			return view('account.home', compact('user','addresses'));
		}

		public function store(HomeStoreRequest $request){
            if(Gate::denies('is_active')){
                return redirect()->route('page.confirm_account');
            }
            $input = $request->all();
			$user = Auth::User()->fill($input);
			$user->save();
			flash('Dados atualizado com sucesso!', 'accept');	
			return redirect()->route('account.home');
		}

		public function change_password(ChangePasswordRequest $request){
            if(Gate::denies('is_active')){
                return redirect()->route('page.confirm_account');
            }
			$user = Auth::User();
			if(Auth::attempt(['email'=>$user->email, 'password'=>$request->get('password')])){
				$user->fill(['password'=> bcrypt($request->get('newpassword'))]);
				$user->save();
				flash('Senha alterada com sucesso!', 'accept');
                return redirect()->route('account.home');
			}else{
                flash('Senha atual informada incorreta', 'error');
                return redirect()->route('account.home');
            }
			flash('Ocorreu um erro ao alterar a senha!', 'error');
            return redirect()->route('account.home');

		}
	}

