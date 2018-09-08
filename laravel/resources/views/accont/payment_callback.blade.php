@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <div class="padding20"></div>
    <section class="panel-content">
        <div class="trigger accept fontem-14"><i class="fa fa-thumbs-up"></i> Compra realizada com sucesso!</div>
        <br>
        <p class="txt-center fontem-14">
            Obrigado por confiar em nosso trabalho! Você pode acompanhar o status de seu pedido<br>
            <a class="btn btn-small btn-popmartin-trans" href="{{ route('accont.requests') }}">Clicando aqui!</a>
        </p>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_banner')
@endsection
