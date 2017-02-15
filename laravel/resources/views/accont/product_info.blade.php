@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Detalhe do produto</h1>
        </header>
            @if(isset($product))
                {!!Form::model($product,['route'=>['accont.salesman.products.update', $product->id], 'method'=>'PUT', 'class' => 'form-modern pop-form' ,'enctype'=>'multipart/form-data'])!!}
            @else
                {!! Form::open(['route' => ['accont.salesman.products.store'], 'method' => 'POST', 'class' => 'form-modern pop-form', 'enctype'=>'multipart/form-data']) !!}
            @endif
            <label>
                <span>Nome do produto</span>
                {!! Form::text('name',null, ['placeholder' => 'Nome do produto']) !!}
                <span class="alert{{ $errors->has('name') ? '' : ' hidden' }}">{{ $errors->first('name') }}</span>
            </label>
            <div class="coltable">
                <div class="coltable-3">
                    <div id="preview_img0" class="prevImg">
                        @if(isset($galeries))
                                <img src="{{ isset($galeries[0]['image']) ? url('imagem/produto/'.$galeries[0]['image']) : url('image/img-exemple.jpg') }}">
                        @else
                            <img src="{{ url('image/img-exemple.jpg') }}">
                        @endif
                    </div>
                </div>
                <div class="coltable-9">
                    <label>
                        <div class="file" style="margin-top: 2.5%;">
                            {!! Form::file('image_0', ['data-preview' => 0, 'onchange' => 'previewFile($(this))']) !!}
                            <input type="text"  placeholder="informe aqui a imagem principal deste produto" readonly="readonly">
                            <input type="hidden" name="image_name_0" value="{{isset($galeries) ? $galeries[0]['image'] : ''}}">
                            <button type="button" class="btn btn-orange">Imagem</button>
                            <div class="clear-both"></div>
                            <span class="alert{{ $errors->has('image_0') ? '' : ' hidden' }}">{{ $errors->first('image_0') }}</span>
                        </div>
                    </label>
                </div>
            </div>
            <div class="colbox">
                @if(isset($product))
                    <div class="colbox-3">
                        <label>
                            <span>Categoria</span>
                            {!! Form::select('category_id', $categories, isset($product->category->category_id) ? $product->category->category_id : $product->category_id , ['class' => 'select_subcat', 'placeholder' => 'Selecione uma Categória', 'data-loader' => 'loader-1']) !!}
                            <span class="alert{{ $errors->has('category_id') ? '' : ' hidden' }}">{{ $errors->first('category_id') }}</span>
                        </label>
                    </div>
                    <div class="colbox-3">
                        <label>
                            <span>Subcategoria</span>
                            {!! Form::select('subcategory_id',$subcategories,isset($product->category->category_id) ? $product->category_id : null , ['class' => 'subcat_info','placeholder'=>'Nenhuma subcategoria']) !!}
                            <span class="alert{{ $errors->has('subcategory_id') ? '' : ' hidden' }}">{{ $errors->first('subcategory_id') }}</span>
                            <span class="fa fa-spinner fa-spin jq-loader dp-none loader-1"></span>
                        </label>
                    </div>
                @else
                    <div class="colbox-3">
                        <label>
                            <span>Categoria</span>
                            {!! Form::select('category_id', $categories, null, ['class' => 'select_subcat', 'placeholder' => 'Selecione uma Categória', 'data-loader' => 'loader-1']) !!}
                            <span class="alert{{ $errors->has('category_id') ? '' : ' hidden' }}">{{ $errors->first('category_id') }}</span>
                        </label>
                    </div>
                    <div class="colbox-3">
                        <label>
                            <span>Subcategoria</span>
                            {!! Form::select('subcategory_id', [], 0, ['class' => 'subcat_info','placeholder'=>'Nenhuma subcategoria']) !!}
                            <span class="alert{{ $errors->has('subcategory_id') ? '' : ' hidden' }}">{{ $errors->first('subcategory_id') }}</span>
                            <span class="fa fa-spinner fa-spin jq-loader dp-none loader-1"></span>
                        </label>
                    </div>
                @endif
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
                                    {!! Form::radio('active', 0,true) !!}
                                </label>
                                <label class="radio" style="border: none;">
                                    <span><span class="fa fa-circle-o"></span> sim</span>
                                    {!! Form::radio('active', 1) !!}
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
                        {!! Form::text('price_out_discount', null, ['placeholder' => '0.00', 'class' => 'masksMoney']) !!}
                        <span class="alert{{ $errors->has('price_out_discount') ? '' : ' hidden' }}">{{ $errors->first('price_out_discount') }}</span>
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
                            @if(isset($product))
                                <span><span class="{{($product->free_shipping) ?'fa fa-check-square-o' : 'fa fa-square-o' }}"></span> frete grátis</span>
                            @else
                                <span><span class="fa fa-square-o"></span> frete grátis</span>
                            @endif
                                {!! Form::checkbox('free_shipping',1) !!}

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
                @if (isset($product))
                    <div class="colbox-3">
                        <label>
                            <span>Movimentação de estoque <i class="fa fa-info-circle c-blue tooltip" title="Informações sobre este assunto"></i></span>
                            {!! Form::number('count', null, ['placeholder' => '0', 'id' => 'number']) !!}
                            {!! Form::select('type_operation_stock', $typemovements, null, ['placeholder' => 'Selecione um tipo de movimentação', 'id' => 'type_operation_stock', 'data-loader' => 'loader-2']) !!}
                        </label>
                        <input type="hidden" id="product_id" value="{{$product->id}}"/>
                    </div>
                    <div class="colbox-3">
                        <label>
                            <span>Estoque Atual</span>
                            {!! Form::text('quantity', null, ['placeholder' => '0', 'id'=>'quantity', 'readonly' => 'true']) !!}
                            <span class="alert hidden"></span>
                            <span class="fa fa-spinner fa-spin jq-loader dp-none loader-2"></span>
                        </label>
                    </div>
                @endif
            </div>
            <div class="clear-both"></div>
            <label>
                <span>Detalhes do produto</span>
                {!! Form::textarea('details', null, ['placeholder' => 'Informações sobre este produto', 'rows' => 14]) !!}
                <span class="alert{{ $errors->has('details') ? '' : ' hidden' }}">{{ $errors->first('details') }}</span>

            </label>
            <p class="c-pop fontw-500">Dados do correio</p>
            <div class="colbox">
                <div class="colbox-5">
                    <label>
                        <span>Comprimento (cm)</span>
                        {!! Form::text('length_cm', null, ['placeholder' => '0', 'class' => 'masksInt', 'maxlength' => 5]) !!}
                        <span class="alert{{ $errors->has('length_cm') ? '' : ' hidden' }}">{{ $errors->first('length_cm') }}</span>

                    </label>
                </div>
                <div class="colbox-5">
                    <label>
                        <span>Largura (cm)</span>
                        {!! Form::text('width_cm', null, ['placeholder' => '0', 'class' => 'masksInt', 'maxlength' => 5]) !!}
                        <span class="alert{{ $errors->has('width_cm') ? '' : ' hidden' }}">{{ $errors->first('width_cm') }}</span>
                    </label>
                </div>
                <div class="colbox-5">
                    <label>
                        <span>Diametro (cm)</span>
                        {!! Form::text('diameter_cm', null, ['placeholder' => '0', 'class' => 'masksInt', 'maxlength' => 5]) !!}
                        <span class="alert{{ $errors->has('diameter_cm') ? '' : ' hidden' }}">{{ $errors->first('diameter_cm') }}</span>
                    </label>
                </div>
                <div class="colbox-5">
                    <label>
                        <span>Altura (cm)</span>
                        {!! Form::text('height_cm', null, ['placeholder' => '0', 'class' => 'masksInt', 'maxlength' => 5]) !!}
                        <span class="alert{{ $errors->has('height_cm') ? '' : ' hidden' }}">{{ $errors->first('height_cm') }}</span>

                    </label>
                </div>
                <div class="colbox-5">
                    <label>
                        <span>Peso (gramas)</span>
                        {!! Form::text('weight_gr', null, ['placeholder' => '0', 'class' => 'masksInt', 'maxlength' => 6]) !!}
                        <span class="alert{{ $errors->has('weight_gr') ? '' : ' hidden' }}">{{ $errors->first('weight_gr') }}</span>
                    </label>
                </div>
            </div>
            <div class="clear-both"></div>
            <br>
                <p class="c-pop fontw-500">Galeria de imagens deste produto
                    <i class="fa fa-info-circle c-blue tooltip" title="Informações sobre este assunto"></i>
                </p>
                <div class="colbox">
                    @for ($i = 1; $i < 5; $i++)
                        <div class="colbox-4 product-galery">
                            <p class="c-blue fontw-500">Imagem {{$i}} <a href="javascript:void(0)" class="c-pop fl-right jq-remove-img-galery" data-id="{{ (isset($galeries[$i]) ? $galeries[$i]['id'] : 0) }}" data-preview="{{ $i }}" data-action="{{ (Request::segment('5') == 'edit' ? 'update' : 'create') }}"><i class="fa fa-times-circle"></i> remover</a></p>
                            <div class="txt-center">
                                <div id="preview_img{{$i}}" class="prevImg">
                                    @if(isset($galeries))
                                    <img src="{{ isset($galeries[$i]) ? url('imagem/produto/'.$galeries[$i]['image'].'?h=110') :  url('image/img-exemple.jpg')}}">
                                    @else
                                    <img src="{{ url('image/img-exemple.jpg') }}">
                                    @endif
                                </div>
                                <div class="file" style="padding: 10px;">
                                    {!! Form::file('image.'.$i, ['data-preview' => $i, 'onchange' => 'previewFile($(this))']) !!}
                                    @if(isset($galeries))
                                        <input type="text"  value="{{isset($galeries[$i]) ? $galeries[$i]['image' ] : ''}}">
                                        <input type="hidden" name="image_name.{{$i}}" value="{{isset($galeries[$i]) ? $galeries[$i]['image' ] : ''}}"/>
                                    @else
                                        <input type="text" />
                                    @endif
                                    <button type="button" class="btn btn-orange">Imagem</button>
                                    <div class="clear-both"></div>
                                    <span class="alert{{ $errors->has('image') ? '' : ' hidden' }}">{{ $errors->first('image') }}</span>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
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
