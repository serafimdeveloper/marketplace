@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Conversa com Luís Fernando</h1>
        </header>
        <table class="table table-action">
            <thead>
            <tr>
                <th class="t-medium"></th>
                <th>Mensagem</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>Cliente<br><span>ontém às 20:25:56</span></td>
                <td>
                    Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e
                    vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja
                    de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu
                    não só a cinco séculos, como também ao salto para a editoração eletrônica, permanecendo
                    essencialmente inalterado. Se popularizou na década de 60
                </td>
            </tr>
            <tr>
                <td>Eu<br><span>hoje às 20:25:56</span></td>
                <td>
                    Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e
                    vem sendo utilizado desde o século XVI.
                </td>
            </tr>
            </tbody>
        </table>
        <div>
            <form class="form-modern" action="" method="POST">
                <p class="c-pop fontw-600 box-marginzero">Responder</p>
                <label>
                    <textarea id="comments-limit" class="limiter-textarea" name="message" rows="4" maxlength="500"></textarea>
                    <span class="limiter-result" for="comments-limit">limite de 500 caracteres</span>
                </label>
                <div class="txt-left">
                    <button type="submit" class="btn btn-popmartin">enviar</button>
                </div>
            </form>
        </div>

    </section>
    <div class="clear-both"></div>
@endsection
