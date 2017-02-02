@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>{{ (Request::segment(3) == 'users' ? 'Usuários' : 'Vendedores')  }} cadastrado na loja</h1>
        </header>
        <form class="form-modern searh_store" action="javascript:void(0)">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <label>
                <input type="search" class="jq-input-search" name="user_name" placeholder="Pesquisar usuário por e-mail">
            </label>
        </form>
        <table id="jq-search-table-result" class="table table-action">
            <thead>
            <tr>
                <th>Nome</th>
                <th class="t-medium">E-mail</th>
                <th class="t-medium">Último acesso</th>
                <th class="t-small">Pedidos</th>
                <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
            </tr>
            </thead>

            <tbody>
            @for($i = 0;$i < 3; $i++)
                <tr>
                    <td>Maria Luíza da Silva</td>
                    <td>marialuiza@hotmail.com</td>
                    <td>ontém às 18:65:25</td>
                    <td>0</td>
                    <td class="txt-center">
                        <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-user" data-user="{{$i}}">detalhes</a>
                    </td>
                </tr>
            @endfor
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_user_info')
@endsection
