@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <h2>Meus pedidos</h2>
        <!-- TABLE -->
        <table class="table table-action">

            <thead>
            <tr class="t-unread">
                <th class="t-small"></th>
                <th class="t-medium">Data</th>
                <th class="t-medium">Remetente</th>
                <th>Menssagem</th>
                <th class="t-small"></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td><label><input type="checkbox" name="msg"></label></td>
                <td>27/09/2013</td>
                <td>Luíz Fernando</td>
                <td>Alguma informação sobre esta mensagem</td>
                <td><a href="javascript:void(0)" class="btn btn-blue">responder</a></td>
            </tr>

            <tr>
                <td><label><input type="checkbox" name="msg"></label></td>
                <td>27/09/2013</td>
                <td>Luíz Fernando</td>
                <td>Alguma informação sobre esta mensagem</td>
                <td><a href="javascript:void(0)" class="btn btn-blue">responder</a></td>
            </tr>
            <tr>
                <td><label><input type="checkbox" name="msg"></label></td>
                <td>27/09/2013</td>
                <td>Luíz Fernando</td>
                <td>Alguma informação sobre esta mensagem</td>
                <td><a href="javascript:void(0)" class="btn btn-blue">responder</a></td>
            </tr>
            <tr>
                <td><label><input type="checkbox" name="msg"></label></td>
                <td>27/09/2013</td>
                <td>Luíz Fernando</td>
                <td>Alguma informação sobre esta mensagem</td>
                <td><a href="javascript:void(0)" class="btn btn-blue">responder</a></td>
            </tr>
            </tbody>
        </table>
        <!-- END TABLE -->
    </section>
    <div class="clear-both"></div>
@endsection
