@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Detalhe do produto</h1>
        </header>
        <form class="form-modern pop-form" action="" method="POST">
            <label>
                <span>Nome do produto</span>
                {!! Form::text('name',null, ['placeholder' => 'Nome do produto']) !!}
            </label>
            <div class="coltable">
                <div class="coltable-3">
                    <div id="preview_img1" class="prevImg"><img src="{{ url('image/img-exemple.jpg') }}"></div>
                </div>
                <div class="coltable-9">
                    <label>
                        <div class="file" style="margin-top: 2.5%;">
                            {!! Form::file('image_master', ['data-preview' => '1', 'onchange' => 'previewFile($(this))']) !!}
                            <input type="text" placeholder="informe aqui a imagem principal deste produto">
                            <button type="button" class="btn btn-orange">Imagem</button>
                            <div class="clear-both"></div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="colbox">
                <div class="colbox-3">
                    <label>
                        <span>Categoria</span>
                        <select name="category_id" class="select_subcat">
                            <option value="" disabled="true" selected="true">Selecionar categoria</option>
                            <option value="1">categoria 1</option>
                            <option value="2">categoria 2</option>
                        </select>
                    </label>
                </div>
                <div class="colbox-3">
                    <label>
                        <span>Subcategoria</span>
                        {!! Form::select('subcategory_id', array('5' => 'sub category1', '6' => 'sub category2'), 0, ['class' => 'subcat_info']) !!}
                    </label>
                </div>
                <div class="colbox-3">
                    <label>
                        <span>Produto visível? <i class="fa fa-info-circle c-blue tooltip"
                                                  title="Informações sobre este assunto"></i></span>
                        <div class="checkboxies">
                            <label class="radio" style="border: none;">
                                <span><span class="fa fa-circle-o"></span> sim</span>
                                {!! Form::radio('active','1') !!}
                            </label>
                            <label class="radio" style="border: none;">
                                <span><span class="fa fa-circle-o"></span> não</span>
                                {!! Form::radio('active','0') !!}
                            </label>
                        </div>
                    </label>
                </div>
            </div>
            <div class="colbox">
                <div class="colbox-4">
                    <label>
                        <span>Preço R$</span>
                        {!! Form::text('price', null, ['placeholder' => '0.00', 'class' => 'masksMoney']) !!}
                    </label>
                </div>
                <div class="colbox-4">
                    <label>
                        <span>Preço com desconto R$ <i class="fa fa-info-circle c-blue tooltip"
                                                       title="Informações sobre este assunto"></i></span>
                        {!! Form::text('price_with_desconto', null, ['placeholder' => '0.00', 'class' => 'masksMoney']) !!}
                    </label>
                </div>
                <div class="colbox-4">
                    <label>
                        <span>Prazo de envio (dias) <i class="fa fa-info-circle c-blue tooltip"
                                                       title="Informações sobre este assunto"></i></span>
                        {!! Form::text('deadline', null, ['placeholder' => '0', 'onkeyup' => 'maskInt(this)']) !!}
                    </label>
                </div>
                <div class="colbox-4">
                    <div class="checkboxies" style="margin: 0;padding: 0 15px 0 6px;">
                        <label class="checkbox" style="margin-top: 27px;">
                            <span><span class="fa fa-square-o"></span> frete grátis</span>
                            {!! Form::checkbox('active','1') !!}
                        </label>
                    </div>
                </div>
            </div>
            <div class="clear-both"></div>
            <div class="colbox">
                <div class="colbox-3">
                    <label>
                        <span>Estoque mínimo <i class="fa fa-info-circle c-blue tooltip"
                                                title="Informações sobre este assunto"></i></span>
                        {!! Form::text('minimum_tock', null, ['placeholder' => '0', 'class' => 'masksMoney']) !!}
                    </label>
                </div>
                @if (Request::segment(3))
                    <div class="colbox-3">
                        <label>
                            <span>Movimentação de estoque <i class="fa fa-info-circle c-blue tooltip"
                                                             title="Informações sobre este assunto"></i></span>
                            {!! Form::text('price_with_desconto', null, ['placeholder' => '0', 'class' => 'masksMoney']) !!}
                            {!! Form::select('type_operation_tock', array('inclusao' => 'inclusão', 'retirada' => 'retirada')) !!}
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
                {!! Form::textarea('details', null, ['placeholder' => 'Informações sobre este produto', 'rows' => 6]) !!}
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
                        {!! Form::text('diameter_cm', null, ['placeholder' => '0']) !!}
                    </label>
                </div>
                <div class="colbox-4">
                    <label>
                        <span>Preso (gramas)</span>
                        {!! Form::text('weight_gr', null, ['placeholder' => '0']) !!}
                    </label>
                </div>
            </div>
            <div class="clear-both"></div>
            <br>

            @if (Request::segment(3))
                <p class="c-pop fontw-500">Galeria de imagens deste produto
                    <i class="fa fa-info-circle c-blue tooltip" title="Informações sobre este assunto"></i>
                </p>
                <div class="colbox">
                    @for ($i = 2; $i < 6; $i++)
                        <div class="colbox-4">
                            <p class="c-blue fontw-500">Imagem {{$i}}</p>
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
