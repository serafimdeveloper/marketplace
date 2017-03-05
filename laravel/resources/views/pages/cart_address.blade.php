@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="content">
            <header class="pop-title">
                <h1>Confirmar endereço de entrega</h1>
            </header>
            <div class="">
                {!!Form::model(null,['route'=>['pages.cart.cart_checkout'],'method'=>'POST','class'=>'form-modern pop-form'])!!}
                {{ csrf_field() }}
                <div class="colbox">
                    <div class="colbox-full">
                        <label>
                            <span>Destinatário: </span>
                            {!! Form::text('name', null, ['placeholder' => 'Informe um nome', 'data-required' => 'fullname']) !!}
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                </div>
                <div class="colbox">
                    <div class="colbox-3">
                        <label>
                            <span>CEP:</span>
                            <input type="text" name="zip_code" value="27286210" readonly>
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                    <div class="colbox-3">
                        <label>
                            <span>UF:</span>
                            <input type="text" name="state" value="" placeholder="Digite sua UF" readonly="readonly">
                            <span class="fa fa-spinner fa-spin jq-loader dp-none loader-address"></span>
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                    <div class="colbox-3">
                        <label>
                            <span>Município:</span>
                            <input type="text" name="city" value="" placeholder="Digite seu Município" readonly="readonly">
                            <span class="fa fa-spinner fa-spin jq-loader dp-none loader-address"></span>
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                </div>
                <div class="clear-both"></div>
                <div class="colbox">
                    <div class="colbox-2">
                        <label>
                            <span>Bairro:</span>
                            {!! Form::text('neighborhood', null, ['placeholder' => 'Digite seu Bairro', 'data-required' => 'notnull']) !!}
                            <span class="fa fa-spinner fa-spin jq-loader dp-none loader-address"></span>
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                    <div class="colbox-2">
                        <label>
                            <span>Endereço:</span>
                            {!! Form::text('public_place', null, ['placeholder' => 'Digite seu Endereço', 'data-required' => 'minlength', 'data-minlength' => 5]) !!}
                            <span class="fa fa-spinner fa-spin jq-loader dp-none loader-address"></span>
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                </div>
                <div class="clear-both"></div>
                <div class="colbox">
                    <div class="colbox-2">
                        <label>
                            <span>Número:</span>
                            {!! Form::text('number', null, ['placeholder' => 'Digite seu número', 'data-required' => 'notnull']) !!}
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                    <div class="colbox-2">
                        <label>
                            <span>Complemento:</span>
                            <input type="text" name="complements" value="" placeholder="Seu Complemento">
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                </div>
                <div class="clear-both"></div>
                <div class="colbox">
                    <div class="colbox-2">
                        <br>
                        <a href="/carrinho" class="c-pop"><i class="fa fa-chevron-left"></i> Voltar para o carrinho</a>
                    </div>
                    <div class="colbox-2 txt-right">
                        <button type="submit" class="btn btn-popmartin">continuar pedido <i class="fa fa-chevron-right vertical-middle"></i></button>
                    </div>
                </div>
                <div class="clear-both"></div>
                {!!Form::close()!!}
            </div>
        </div>
        <div class="padding20"></div>
    </section>
@endsection
