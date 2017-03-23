@extends('layouts.app')

@section('content')
    <section class="content">
        <header class="pop-title">
            <h1>Fale conosco</h1>
        </header>
        <p class="trigger warning"><i class="fa fa-warning"></i> ATENÇÃO: Este canal não deve ser usado para tirar dúvidas sobre produtos.</p>
        {!!Form::model('user',['route'=>['pages.contact'],'method'=>'POST','class'=>'form-modern pop-form'])!!}
        <div class="colbox">
            <div class="colbox-2">
                <label>
                    <span>Nome</span>
                    {!! Form::text('name',null, ['placeholder' => 'Seu nome', 'data-required' => 'minlength', 'data-minlength' => 3]) !!}
                    <span class="alert hidden"></span>
                </label>
                <label>
                    <span>E-mail</span>
                    {!! Form::text('email',null, ['placeholder' => 'Email de contato', 'data-required' => 'email']) !!}
                    <span class="alert hidden"></span>
                </label>
                <label>
                    <span>Setor</span>
                    <select name="setor">
                        <option value="comercial">SAC</option>
                    </select>
                </label>
            </div>
            <div class="colbox-2">
                <label>
                    <span>Mensagem</span>
                    {!! Form::textarea('message',null, ['rows' => '9', 'data-required' => 'minlength', 'data-minlength' => 20]) !!}
                    <span class="alert hidden"></span>
                </label>
            </div>
            <div class="clear-both"></div>
            <div class="txt-center" style="border-top: 1px solid #B0BEC5;padding-top: 10px;">
                <button type="submit" class="btn btn-popmartin">enviar menssagem</button>
            </div>
            {!!Form::close()!!}
        </div>
        <div class="clear-both"></div>
    </section>
@endsection