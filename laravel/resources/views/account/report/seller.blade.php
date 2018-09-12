@extends('layouts.app')

@section('content')
    @include('account.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>{{ (Request::segment(3) == 'users' ? 'Usuários' : 'Vendedores')  }} cadastrado na loja</h1>
        </header>
        <form class="form-modern pop-form searh_store" action="javascript:void(0)">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <label>
                <input type="search" class="jq-input-search" name="user_name" placeholder="Pesquisar vendedor por e-mail">
            </label>
        </form>

    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_user_info')
@endsection
