@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <h2>Mensagem enviada por Luís Fernando</h2>
        <p>enviada hoje às 10:25:48</p>
        <div>
            <p>
                Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e
                vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja
                de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu
                não só a cinco séculos, como também ao salto para a editoração eletrônica, permanecendo
                essencialmente inalterado. Se popularizou na década de 60, quando a Letraset lançou
                decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser
                integrado a softwares de editoração eletrônica como Aldus PageMaker.
            </p>
            <form class="form-modern" action="" method="POST">
                <label>
                    <textarea name="message" rows="10"></textarea>
                </label>

                <div class="txt-center">
                    <button type="submit" class="btn btn-teal">Responder</button>
                </div>
            </form>
        </div>

    </section>
    <div class="clear-both"></div>
@endsection
