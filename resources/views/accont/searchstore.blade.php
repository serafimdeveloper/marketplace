@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Procure uma loja</h1>
        </header>
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
            </tr>
            </thead>

            <tbody>
            <tr>
                <td><a href="/loja/nome" class="fontem-12 c-green-avocadodark">nome da loja</a> </td>
                <td>Luíz Fernando</td>
            </tr>
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
@endsection
