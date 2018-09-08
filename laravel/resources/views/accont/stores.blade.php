@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minha loja</h1>
            @if(isset($store))
                <div class="pop-tile-menu">
                    <span class="btn btn-smallextreme btn-popmartin jq-block-store">
                    @if($store->active === 0)
                            <i class="fa fa-unlock vertical-middle"></i> desbloquear loja
                        @else
                            <i class="fa fa-lock vertical-middle"></i> bloquear loja
                        @endif
                </span>
                    <a href="{{ url('/'. $store->slug) }}" class="btn btn-smallextreme btn-popmartin" target="_blank">
                        <i class="fa fa-external-link vertical-middle"></i>
                        ver loja
                    </a>
                </div>

            @endif
        </header>
        @if(isset($store))
            {!!Form::model($store,['route'=>['accont.salesman.stores.update'], 'method'=>'POST', 'class' => 'form-modern pop-form', 'enctype'=>'multipart/form-data'])!!}
        @else
            {!! Form::open(['route' => ['accont.salesman.stores.store'], 'method' => 'POST', 'class' => 'form-modern pop-form', 'enctype'=>'multipart/form-data']) !!}
        @endif
        <div class="colbox">
            <div class="colbox-2">
                <label>
                    <span>Nome da loja <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    {!! Form::text('name', null, ['placeholder' => 'Nome da Loja', 'data-required' => 'notnull']) !!}
                    <span class="alert{{ $errors->has('name') ? '' : ' hidden' }}">{{ $errors->first('name') }}</span>
                </label>
                <div class="checkbox-container padding10">
                    <span>Tipo</span>
                    <div class="checkboxies">
                        <label class="radio select_type_sallesman" style="border: none;">
                            @if(isset($store))
                                <span><span class="fa {{ ($store->type_salesman === 'F') ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></span> física</span>
                                {!! Form::radio('type_salesman','F',($store->type_salesman === 'F') ? true : ' ') !!}
                            @else
                                <span><span class="fa fa-check-circle-o c-green"></span> física</span>
                                {!! Form::radio('type_salesman','F', true) !!}
                            @endif
                        </label>
                        <label class="radio select_type_sallesman" style="border: none;">
                            @if(isset($store))
                                <span><span class="fa {{ ($store->type_salesman === 'J') ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></span> jurídica</span>
                                {!! Form::radio('type_salesman','J', ($store->type_salesman === 'J') ? true : ' ') !!}
                            @else
                                <span><span class="fa fa-circle-o"></span> jurídica</span>
                                {!! Form::radio('type_salesman','J') !!}
                            @endif

                        </label>
                    </div>
                    <span class="alert{{ $errors->has('type_salesman') ? '' : ' hidden' }}">{{ $errors->first('type_salesman') }}</span>
                </div>
                @if(isset($store))
                    <div class="selects_people select_cpf" style="{{ $store->type_salesman === 'F' ? 'display: block' : ''}}">
                        @else
                            <div class="selects_people select_cpf" style="display: block;">
                                @endif

                                <label>
                                    <span>CPF</span>
                                    {!! Form::text('cpf',Auth::user()->cpf, ['class' => 'masked_cpf', 'placeholder' => 'CPF', 'data-required' => 'notnull', 'readonly'=>'readonly']) !!}
                                    <span class="alert{{ $errors->has('cpf') ? '' : ' hidden' }}">{{ $errors->first('cpf') }}</span>                        </label>
                            </div>
                            @if(isset($store))
                                <div class="selects_people select_cnpj" style="{{ $store->type_salesman === 'J' ? 'display: block' : ''}}">
                                    @else
                                        <div class="selects_people select_cnpj">
                                            @endif

                                            <label>
                                                <span>CNPJ</span>
                                                {!! Form::text('cnpj', null, ['class' => 'masked_cnpj', 'placeholder' => 'CNPJ']) !!}
                                                <span class="alert{{ $errors->has('cnpj') ? '' : ' hidden' }}">{{ $errors->first('cnpj') }}</span>                        </label>
                                            <label>
                                                <span>Nome Fantasia</span>
                                                {!! Form::text('fantasy_name', null, ['placeholder' => 'nome fantasia da Loja']) !!}
                                                <span class="alert{{ $errors->has('fantasy_name') ? '' : ' hidden' }}">{{ $errors->first('fantasy_name') }}</span>                        </label>
                                            <label>
                                                <span>Razão social</span>
                                                {!! Form::text('social_name', null) !!}
                                                <span class="alert{{ $errors->has('social_name') ? '' : ' hidden' }}">{{ $errors->first('social_name') }}</span>                        </label>
                                        </div>

                                        <div class="txt-center">
                                            <div id="preview_img1" class="prevImg">
                                                @if(old('logo_file'))
                                                    {{old('logo_file')}}
                                                @elseif(isset($store))
                                                    <img src="{{url('imagem/loja/'.$store->logo_file)}}">
                                                @endif
                                            </div>
                                            <div class="file" style="padding: 10px;">
                                                {!! Form::file('logo_file', ['data-preview' => 1, 'onchange' => 'previewFile($(this))']) !!}
                                                <input type="text" value="{{(!isset($store->logo_file)) ? old('logo_file') : $store->logo_file}}">
                                                <button type="button" class="btn btn-orange">Escolher Logo</button>
                                                <div class="clear-both"></div>
                                                <span class="alert{{ $errors->has('logo_file') ? '' : ' hidden' }}">{{ $errors->first('logo_file') }}</span>
                                            </div>
                                        </div>
                                </div>

                                <div class="colbox-2">
                                    <label>
                                        <span>Sobre a Loja (máximo de 500 caracteres) <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                                        {!! Form::textarea('about', null,['id' => 'sobre1', 'class' => 'limiter-textarea', 'maxlength' => '500', 'placeholder'=>'Digite aqui uma informação sobre a sua loja', 'rows'=>'7']) !!}
                                        <span class="alert{{ $errors->has('about') ? '' : ' hidden' }}">{{ $errors->first('about') }}</span>
                                        <span class="limiter-result" for="sobre1" data-limit="500">500</span>
                                    </label>
                                    <label>
                                        <span>Política de troca (máximo de 500 caracteres)</span>
                                        {!! Form::textarea('exchange_policy', null, ['id' => 'sobre2', 'class' => 'limiter-textarea', 'maxlength' => '500','placeholder'=>'Digite aqui suas políticas de troca', 'rows'=>'7']) !!}
                                        <span class="alert{{ $errors->has('exchange_policy') ? '' : ' hidden' }}">{{ $errors->first('exchange_policy') }}</span>
                                        <span class="limiter-result" for="sobre2" data-limit="500">500</span>
                                    </label>
                                    <label>
                                        <span>Política de frete (máximo de 500 caracteres)</span>
                                        {!! Form::textarea('freight_policy', null, ['id' => 'sobre3', 'class' => 'limiter-textarea', 'maxlength' => '500','placeholder'=>'Digite aqui suas políticas de frete', 'rows'=>'7']) !!}
                                        <span class="alert{{ $errors->has('freight_policy') ? '' : ' hidden' }}">{{ $errors->first('freight_policy') }}</span>
                                        <span class="limiter-result" for="sobre3" data-limit="500">500</span>
                                    </label>
                                </div>

                    </div>
                    <div class="clear-both"></div>
                    <div class="txt-center" style="border-top: 1px solid #B0BEC5;padding-top: 10px;">
                        <button type="submit" class="btn btn-popmartin">{{isset($store) ? 'atualizar' :'cadastrar'}}</button>
                    </div>

                    {!! Form::close() !!}
                    <div id="group-pnl-end">
                        @if(isset($store))
                            @if(isset($adress->id))

                                <div class="panel-end" id="end_{{$adress->id}}">

                                    <h4><span>Endereço da Loja</span></h4>
                                    <div class="panel-end-content">

                                        <p>CEP: {{$adress->zip_code}}</p>

                                        <p>{{$adress->public_place}}, {{$adress->number}} - {{$adress->city}}</p>
                                    </div>
                                    <a href="javascript:void(0)" class="panel-end-edit vertical-flex jq-address" data-alertbox="alert-address" data-id="{{$adress->id}}" data-action="store">editar|excluir</a>
                                </div>
                            @else
                                <div id="isAddress">
                                    <p class="trigger warning txt-center"><i class="fa fa-exclamation-circle"></i> Você ainda não possui endereço cadastrado</p>
                                    <p class="txt-center"><a href="javascript:void(0)" class="btn btn-popmartin jq-address" data-alertbox="alert-address" data-action="store">cadastrar um endereço</a></p>
                                </div>
                            @endif
                        @endif
                    </div>
            </div>
        </div>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_adress')
@endsection