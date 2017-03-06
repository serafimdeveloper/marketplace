@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="content">
            <header class="pop-title">
                <h1>Confirmar endereço de entrega</h1>
            </header>
            <div class="">
                {!!Form::open(['route'=>['pages.cart.cart_address.post'],'method'=>'POST','class'=>'form-modern pop-form'])!!}
                <div class="colbox">
                    <div class="colbox-full">
                        <label>
                            <span>Destinatário: </span>
                            {!! Form::text('name', (isset($address->name) ? $address->name : null), ['placeholder' => 'Informe um nome', 'data-required' => 'fullname']) !!}
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                </div>
                <div class="colbox">
                    <div class="colbox-3">
                        <label>
                            <span>CEP:</span>
                            {!! Form::text('zip_code', (isset($address->zip_code) ? $address->zip_code : $address->cep), ['readonly'=>'readonly']) !!}
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                    <div class="colbox-3">
                        <label>
                            <span>UF:</span>
                            {!! Form::text('state', (isset($address->state) ? $address->state : $address->uf) ,['readonly'=>'readonly']) !!}
                            <span class="fa fa-spinner fa-spin jq-loader dp-none loader-address"></span>
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                    <div class="colbox-3">
                        <label>
                            <span>Município:</span>
                            {!! Form::text('city', (isset($address->city) ? $address->city : $address->cidade) ,['readonly'=>'readonly']) !!}
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
                            {!! Form::text('neighborhood',(isset($address->neighborhood) ? $address->neighborhood : (isset($address->bairro) ? $address->bairro : null)) , ['placeholder' => 'Digite seu Bairro', 'data-required' => 'notnull']) !!}
                            <span class="fa fa-spinner fa-spin jq-loader dp-none loader-address"></span>
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                    <div class="colbox-2">
                        <label>
                            <span>Endereço:</span>
                            {!! Form::text('public_place', (isset($address->public_place) ? $address->public_place : (isset($address->logradouro) ? $address->logradouro : null)), ['placeholder' => 'Digite seu Endereço', 'data-required' => 'minlength', 'data-minlength' => 5]) !!}
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
                            {!! Form::text('number', (isset($address->number) ? $address->number : null), ['placeholder' => 'Digite seu número', 'data-required' => 'notnull']) !!}
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                    <div class="colbox-2">
                        <label>
                            <span>Complemento:</span>
                            {!! Form::text('complements', (isset($address->complements) ? $address->complements : null),['placeholder'=>'Seu complemento']) !!}
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
