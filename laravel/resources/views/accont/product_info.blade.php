@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Detalhe do produto</h1>
        </header>
            @if(isset($product))
                {!!Form::model($product,['route'=>['accont.salesman.product.update', $product->id], 'method'=>'POST', 'class' => 'form-modern pop-form', 'enctype'=>'multipart/form-data'])!!}
            @else
                {!! Form::open(['route' => ['accont.salesman.product.store'], 'method' => 'POST', 'class' => 'form-modern pop-form', 'enctype'=>'multipart/form-data']) !!}
            @endif
            <label>
                <span>Nome do produto</span>
                {!! Form::text('name',null, ['placeholder' => 'Nome do produto']) !!}
                <span class="alert{{ $errors->has('name') ? '' : ' hidden' }}">{{ $errors->first('name') }}</span>
            </label>
            <div class="coltable">
                <div class="coltable-3">
                    <div id="preview_img0" class="prevImg">
                        @if(isset($product))
                            @if(isset($product->galeries->first()->name))
                                <img src="{{ url('imagem/produto/'.$product->galeries->first()->name) }}">
                            @else
                                <img src="{{ url('image/img-exemple.jpg') }}">
                            @endif
                        @else
                            <img src="{{ url('image/img-exemple.jpg') }}">
                        @endif
                    </div>
                </div>
                <div class="coltable-9">
                    <label>
                        <div class="file" style="margin-top: 2.5%;">
                            {!! Form::file('image_master', ['data-preview' => '1', 'onchange' => 'previewFile($(this))']) !!}
                            <input type="text" placeholder="informe aqui a imagem principal deste produto">
                            <button type="button" class="btn btn-orange">Imagem</button>
                            <div class="clear-both"></div>
                            <span class="alert{{ $errors->has('image_master') ? '' : ' hidden' }}">{{ $errors->first('image_master') }}</span>
                        </div>
                    </label>
                </div>
            </div>
            <div class="colbox">
                <div class="colbox-3">
                    <label>
                        <span>Categoria</span>
                        {!! Form::select('category_id', $categories, null, ['class' => 'select_subcat', 'placeholder' => 'Selecione uma Categória']) !!}
                        <span class="alert{{ $errors->has('category_id') ? '' : ' hidden' }}">{{ $errors->first('category_id') }}</span>
                    </label>
                </div>
                <div class="colbox-3">
                    <label>
                        <span>Subcategoria</span>
                        {!! Form::select('subcategory_id', [], 0, ['class' => 'subcat_info','placeholder'=>'Nenhuma subcategoria']) !!}
                        <span class="alert{{ $errors->has('subcategory_id') ? '' : ' hidden' }}">{{ $errors->first('subcategory_id') }}</span>
                    </label>
                </div>
                <div class="colbox-3">
                    <label>
                        <span>Produto visível? <i class="fa fa-info-circle c-blue tooltip" title="Informações sobre este assunto"></i></span>
                        <div class="checkboxies">
                            @if(isset($product))
                                <label class="radio" style="border: none;">
                                    <span><span class="fa {{ ($product->active === 0) ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></span> não</span>
                                    {!! Form::radio('active', 1) !!}
                                </label>
                                <label class="radio" style="border: none;">
                                    <span><span class="fa {{ ($product->active === 1) ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></span> sim</span>
                                    {!! Form::radio('active', 0) !!}
                                </label>
                            @else
                                <label class="radio" style="border: none;">
                                    <span><span class="fa fa-check-circle-o c-green}"></span> não</span>
                                    {!! Form::radio('active', 1,true) !!}
                                </label>
                                <label class="radio" style="border: none;">
                                    <span><span class="fa fa-circle-o"></span> sim</span>
                                    {!! Form::radio('active', 0) !!}
                                </label>
                            @endif
                        </div>
                    </label>
                </div>
            </div>
            <div class="colbox">
                <div class="colbox-4">
                    <label>
                        <span>Preço R$</span>
                        {!! Form::text('price', null, ['placeholder' => '0.00', 'class' => 'masksMoney']) !!}
                        <span class="alert{{ $errors->has('price') ? '' : ' hidden' }}">{{ $errors->first('price') }}</span>
                    </label>
                </div>
                <div class="colbox-4">
                    <label>
                        <span>Preço com desconto R$ <i class="fa fa-info-circle c-blue tooltip" title="Informações sobre este assunto"></i></span>
                        {!! Form::text('price_out_desconto', null, ['placeholder' => '0.00', 'class' => 'masksMoney']) !!}
                        <span class="alert{{ $errors->has('price_out_desconto') ? '' : ' hidden' }}">{{ $errors->first('price_out_desconto') }}</span>
                    </label>
                </div>
                <div class="colbox-4">
                    <label>
                        <span>Prazo de envio (dias) <i class="fa fa-info-circle c-blue tooltip" title="Informações sobre este assunto"></i></span>
                        {!! Form::text('deadline', null, ['placeholder' => '0', 'onkeyup' => 'maskInt(this)']) !!}
                        <span class="alert{{ $errors->has('deadline') ? '' : ' hidden' }}">{{ $errors->first('deadline') }}</span>
                    </label>
                </div>
                <div class="colbox-4">
                    <div class="checkboxies" style="margin: 0;padding: 0 15px 0 6px;">
                        <label class="checkbox" style="margin-top: 27px;">
                            <span><span class="fa fa-square-o"></span> frete grátis</span>
                            {!! Form::checkbox('active',1) !!}
                        </label>
                    </div>
                </div>
            </div>
            <div class="clear-both"></div>
            <div class="colbox">
                <div class="colbox-3">
                    <label>
                        <span>Estoque mínimo <i class="fa fa-info-circle c-blue tooltip" title="Informações sobre este assunto"></i></span>
                        {!! Form::text('minimum_stock', null, ['placeholder' => '0', 'onkeyup' => 'maskInt(this)']) !!}
                        <span class="alert{{ $errors->has('minimum_stock') ? '' : ' hidden' }}">{{ $errors->first('minimum_stock') }}</span>
                    </label>
                </div>
                @if (Request::segment(4))
                    <div class="colbox-3">
                        <label>
                            <span>Movimentação de estoque <i class="fa fa-info-circle c-blue tooltip" title="Informações sobre este assunto"></i></span>
                            {!! Form::text('price_with_desconto', null, ['placeholder' => '0', 'class' => 'masksMoney']) !!}
                            {!! Form::select('type_operation_stock', array('inclusao' => 'inclusão', 'retirada' => 'retirada')) !!}
                        </label>

                    </div>
                    <div class="colbox-3">
                        <label>
                            <span>Estoque Atual</span>
                            {!! Form::text('deadline', null, ['placeholder' => '0', 'onkeyup' => 'maskInt(this)', 'readonly' => 'true']) !!}
                        </label>
                    </div>
                @endif
            </div>
            <div class="clear-both"></div>
            <label>
                <span>Detalhes do produto</span>
                {!! Form::textarea('details', null, ['placeholder' => 'Informações sobre este produto', 'rows' => 14]) !!}
            </label>
            <p class="c-pop fontw-500">Dados do correio</p>
            <div class="colbox">
                <div class="colbox-4">
                    <label>
                        <span>Comprimento (cm)</span>
                        {!! Form::text('length_cm', null, ['placeholder' => '0', 'class' => 'masksMoney']) !!}
                    </label>
                </div>
                <div class="colbox-4">
                    <label>
                        <span>Largura (cm)</span>
                        {!! Form::text('width_cm', null, ['placeholder' => '0', 'class' => 'masksMoney']) !!}
                    </label>
                </div>
                <div class="colbox-4">
                    <label>
                        <span>Altura (cm)</span>
                        {!! Form::text('diameter_cm', null, ['placeholder' => '0', 'class' => 'masksMoney']) !!}
                    </label>
                </div>
                <div class="colbox-4">
                    <label>
                        <span>Preso (gramas)</span>
                        {!! Form::text('weight_gr', null, ['placeholder' => '0', 'class' => 'masksMoney']) !!}
                    </label>
                </div>
            </div>
            <div class="clear-both"></div>
            <br>

            @if (Request::segment(4))
                <p class="c-pop fontw-500">Galeria de imagens deste produto
                    <i class="fa fa-info-circle c-blue tooltip" title="Informações sobre este assunto"></i>
                </p>
                <div class="colbox">
                    @for ($i = 1; $i < 4; $i++)
                        <div class="colbox-4 product-galery">
                            <p class="c-blue fontw-500">Imagem {{$i}} <a href="javascript:void(0)" class="c-pop fl-right"><i class="fa fa-times-circle"></i> remover</a></p>
                            <div class="txt-center">
                                <div id="preview_img{{$i}}" class="prevImg"><img
                                            src="{{ url('image/img-exemple.jpg') }}">
                                </div>
                                <div class="file" style="padding: 10px;">
                                    {!! Form::file('image[]', ['data-preview' => $i, 'onchange' => 'previewFile($(this))']) !!}
                                    <input type="text">
                                    <button type="button" class="btn btn-orange">Imagem</button>
                                    <div class="clear-both"></div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            @endif
            <div class="clear-both"></div>
            <hr>
            <br>
            <div class="txt-center">
                <button type="submit" class="btn btn-popmartin">Salvar</button>
            </div>
        </form>
        <br>
        <p class="txt-center">ATENÇÂO: revise todos os dados antes de clicar em "Salvar". Tenha certeza que todas as
            informações estejam corretas.</p>
    </section>
    <div class="clear-both"></div>
    <div class="padding20"></div>
@endsection
