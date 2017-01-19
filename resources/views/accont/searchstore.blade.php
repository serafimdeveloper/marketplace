@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <h2>Procure uma loja</h2>
        <form class="form-modern searh_store" action="" method="POST">
            <label>
                <input type="search" name="search_store" placeholder="Pesquisar Loja">
            </label>
        </form>
        <table id="pop-searchStore" class="table table-action">
            <thead>
            <tr>
                <th class="t-medium">Loja</th>
                <th class="t-medium">Vendedor</th>
                <th class="t-medium">Cadastro</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td><a href="/loja/nome" class="fontem-12 c-green-avocadodark">nome da loja</a> </td>
                <td>Luíz Fernando</td>
                <td>01/01/2015 às 00:00:00</td>
            </tr>
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
@endsection
