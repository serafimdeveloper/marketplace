@extends('layouts.app')

@section('content')
    @include('account.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Detalhe do produto</h1>
        </header>
        @if(isset($product) && Auth::user()->admin)
            @if($product->store->seller->user->id !== Auth::user()->id)
                <div class="trigger warning">
                    <span>Você está editando um produto da loja <b>{{ $product->store->name }}</b></span>
                </div>
            @endif
        @endif
        @if(isset($product))
            {!!Form::model($product,['route'=>['account.seller.products.update', $product->id], 'method'=>'PUT', 'class' => 'form-modern pop-form form-create-product' ,'enctype'=>'multipart/form-data'])!!}
        @else
            {!! Form::open(['route' => ['account.seller.products.store'], 'method' => 'POST', 'class' => 'form-modern pop-form', 'enctype'=>'multipart/form-data']) !!}
        @endif

        @if(!isset($product) && Auth::user()->admin)
            <label>
                <span>Loja: <i class="fa fa-info-circle c-blue tooltip" title="Selecione a loja apenas se desejar cadastrar produto para uma outra loja que não seja a sua!"></i></span>
            <div class="trigger warning">
                {!! Form::select('store_id', $stores, (isset(Auth::user()->seller->store) ? Auth::user()->seller->store->id : null) , ['class' => 'chosen-select', 'placeholder' => 'Selecione uma loja']) !!}
            </div>
            </label>

            {{--{!! Form::text('store', null, ['placeholder' => 'Loja para o qual o produto será criado', 'class' => '']) !!}--}}

        @endif
        <label>
            <span>Nome do produto <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
            {!! Form::text('name',null, ['placeholder' => 'Nome do produto']) !!}
            <span class="alert{{ $errors->has('name') ? '' : ' hidden' }}">{{ $errors->first('name') }}</span>
        </label>
        <div class="coltable">
            <div class="coltable-3">
                <div id="preview_img0" class="prevImg">
                    @if(isset($galleries))
                        <img src="{{ isset($galleries[0]['image']) ? url('imagem/produto/'.$galleries[0]['image']) : url('image/img-exemple.jpg') }}">
                    @else
                        <img src="{{ url('image/img-exemple.jpg') }}">
                    @endif
                </div>
            </div>
            <div class="coltable-9">
                <label>
                    <div class="file" style="margin-top: 2.5%;">
                        {!! Form::file('image_0', ['data-preview' => 0, 'onchange' => 'previewFile($(this))']) !!}
                        <input type="text" placeholder="informe aqui a imagem principal deste produto"
                               readonly="readonly">
                        <input type="hidden" name="image_name_0" value="{{isset($galleries) && $galleries ? $galleries[0]['image'] : ''}}">
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
                        <span>Categoria <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
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
                    <span>Produto visível? <i class="fa fa-info-circle c-blue tooltip"
                                              title="Esta opção, marca se o seu produto estará visível ou não para os visitantes em sua loja"></i></span>
                    <div class="checkboxies">
                        @if(isset($product))
                            <label class="radio" style="border: none;">
                                <span><span class="fa {{ ($product->active === 0) ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></span> não</span>
                                {!! Form::radio('active', 0, ($product->active === 0 ) ? true : ' ') !!}
                            </label>
                            <label class="radio" style="border: none;">
                                <span><span class="fa {{ ($product->active === 1) ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></span> sim</span>
                                {!! Form::radio('active', 1, ($product->active === 1 ) ? true : ' ') !!}
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
                    <span>Preço R$ <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    {!! Form::text('price', null, ['placeholder' => '0.00', 'class' => 'masksMoney', 'data-required' => 'notnull']) !!}
                    <span class="alert{{ $errors->has('price') ? '' : ' hidden' }}">{{ $errors->first('price') }}</span>
                </label>
            </div>
            <div class="colbox-4">
                <label>
                    <span>Preço com desconto R$ <i class="fa fa-info-circle c-blue tooltip"
                                                   title="Valor já com desconto do seu produto"></i></span>
                    {!! Form::text('price_out_discount', null, ['placeholder' => '0.00', 'class' => 'masksMoney']) !!}
                    <span class="alert{{ $errors->has('price_out_discount') ? '' : ' hidden' }}">{{ $errors->first('price_out_discount') }}</span>
                </label>
            </div>
            <div class="colbox-4">
                <label>
                    <span>Prazo de envio (dias) <i class="fa fa-info-circle c-blue tooltip"
                                                   title="Após feito a venda, qual o seu prazo para enviar este produto ao correio!"></i> <sup
                                class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    {!! Form::number('deadline', null, ['placeholder' => '0', 'onkeyup' => 'maskInt(this)', 'data-required' => 'notnull']) !!}
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
                    <span>Estoque mínimo <i class="fa fa-info-circle c-blue tooltip"
                                            title="Estoque mínimo para ser notificado quando o quantidade de produtos atingir este limite"></i> <sup
                                class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    {!! Form::number('minimum_stock', null, ['placeholder' => '0', 'onkeyup' => 'maskInt(this)', 'data-required' => 'notnull']) !!}
                    <span class="alert{{ $errors->has('minimum_stock') ? '' : ' hidden' }}">{{ $errors->first('minimum_stock') }}</span>
                </label>
            </div>
            @if (isset($product))
                <div class="colbox-3">
                    <label>
                        <span>Movimentação de estoque <i class="fa fa-info-circle c-blue tooltip"
                                                         title="Informações sobre este assunto"></i></span>
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
            <span>Detalhes do produto <i class="fa fa-info-circle c-blue tooltip"
                                         title="Informe aqui detalhes como cores disponíveis, tamanhos e etc. Um produto bem detalhado, pode gerar menor volume de perguntas sobre o produto!"></i> <sup
                        class="c-red fontem-06 fl-right">obrigatório</sup></span>
            {!! Form::textarea('details', null, ['id' => 'textarea_tiny', 'class' => 'textarea_tiny limited_text_withtag required-field', 'placeholder' => 'Informações sobre este produto', 'rows' => 14, 'data-required' => 'minlength', 'data-minlength' => '20']) !!}
            <span class="alert{{ $errors->has('details') ? '' : ' hidden' }}">{{ $errors->first('details') }}</span>
        </label>
        <br>
        <p class="c-pop fontw-500">Dados do correio <sup class="c-red fontem-06">obrigatório</sup></p>
        <div class="colbox">
            <div class="colbox-4">
                <label>
                    <span>Comprimento (cm)</span>
                    {!! Form::number('length_cm', null, ['placeholder' => '0', 'class' => 'masksInt', 'maxlength' => 5, 'data-required' => 'notzero']) !!}
                    <span class="alert{{ $errors->has('length_cm') ? '' : ' hidden' }}">{{ $errors->first('length_cm') }}</span>

                </label>
            </div>
            <div class="colbox-4">
                <label>
                    <span>Largura (cm)</span>
                    {!! Form::text('width_cm', null, ['placeholder' => '0', 'class' => 'masksInt', 'maxlength' => 5, 'data-required' => 'notzero']) !!}
                    <span class="alert{{ $errors->has('width_cm') ? '' : ' hidden' }}">{{ $errors->first('width_cm') }}</span>
                </label>
            </div>
            <div class="colbox-4">
                <label>
                    <span>Altura (cm)</span>
                    {!! Form::text('height_cm', null, ['placeholder' => '0', 'class' => 'masksInt', 'maxlength' => 5, 'data-required' => 'notzero']) !!}
                    <span class="alert{{ $errors->has('height_cm') ? '' : ' hidden' }}">{{ $errors->first('height_cm') }}</span>

                </label>
            </div>
            <div class="colbox-4">
                <label>
                    <span>Peso (gramas) </span>
                    {!! Form::text('weight_gr', null, ['placeholder' => '0', 'class' => 'masksInt', 'maxlength' => 6, 'data-required' => 'notzero']) !!}
                    <span class="alert{{ $errors->has('weight_gr') ? '' : ' hidden' }}">{{ $errors->first('weight_gr') }}</span>
                </label>
            </div>
        </div>
        <div class="clear-both"></div>
        <br>
        <p class="c-pop fontw-500">Galeria de imagens deste produto
            <i class="fa fa-info-circle c-blue tooltip"
               title="Você pode cadastrar além da imagem principal do produto, mais 4 imagens para demonstrar seu produto. Escolha imagens limpas e com preferência de fundo de cor clara. Isto pode ajudar na venda de seu produto. Lembre-se que uma imagem bem elaborada do seu produto, pode trazer uma maior conversão de venda e se destacar entre os demais"></i>
        </p>
        <div class="colbox">
            @for ($i = 1; $i < 5; $i++)
                <div class="colbox-4 product-gallery">
                    <p class="c-blue fontw-500">Imagem {{$i}}
                        <a href="javascript:void(0)" class="c-pop fl-right jq-remove-img-gallery"
                                                                 data-id="{{ (isset($galleries[$i]) ? $galleries[$i]['id'] : 0) }}"
                                                                 data-preview="{{ $i }}"
                                                                 data-action="{{ (Request::segment('5') == 'edit' ? 'update' : 'create') }}"><i
                                    class="fa fa-times-circle"></i> remover</a></p>
                    <div class="txt-center">
                        <div id="preview_img{{$i}}" class="prevImg">
                            @if(isset($galleries))
                                <img src="{{ isset($galleries[$i]) ? url('imagem/produto/'.$galleries[$i]['image'].'?h=110') :  url('image/img-exemple.jpg')}}">
                            @else
                                <img src="{{ url('image/img-exemple.jpg') }}">
                            @endif
                        </div>
                        <div class="file" style="padding: 10px;">
                            {!! Form::file('image.'.$i, ['data-preview' => $i, 'onchange' => 'previewFile($(this))']) !!}
                            @if(isset($galleries))
                                <input type="text" value="{{isset($galleries[$i]) ? $galleries[$i]['image' ] : ''}}">
                                <input type="hidden" name="image_name.{{$i}}"
                                       value="{{isset($galleries[$i]) ? $galleries[$i]['image' ] : ''}}"/>
                            @else
                                <input type="text"/>
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
@endsection
