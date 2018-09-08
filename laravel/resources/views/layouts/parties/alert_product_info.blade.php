<div class="alertbox" id="jq-info-product">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">{{$result->name}}</h2>
            <div class="pop-user-info">
                <div class="pop-user-info-action">
                    <a class="btn btn-small btn-popmartin fl-left" href="/accont/salesman/products/{{ $result->id }}/edit" target="_blank"><i class="fa fa-edit"></i> editar</a>
                    <a class="btn btn-small btn-popmartin fl-right jq-remove-product" data-id="{{$result->id}}" data-token="{{ csrf_token() }}"><i class="fa fa-trash"></i> remover produto</a>
                </div>
                <div class="clear-both"></div>
                <p class="c-pop fontw-500">Dados do produto:</p>
                <div class="colbox">
                    <div class="colbox-3">
                        <div class="pop-info-user">
                            <p>{{$result->name}}
                                <a href="{{route('pages.product',[$result->store->slug, $result->category->slug, $result->slug])}}" class="btn btn-smallextreme btn-popmartin fl-right"
                                   target="_blank">ver produto</a>
                            </p>
                        </div>
                    </div>
                    <div class="colbox-3">
                        <div class="pop-info-user">
                            <p>Loja</p>
                            <span>{{$result->store->name}}</span>
                        </div>
                    </div>
                    <div class="colbox-3">
                        <div class="pop-info-user">
                            <p>Vendedor</p>
                            <span>{{$result->store->salesman->user->name}}</span>
                        </div>
                    </div>
                </div>
                <div class="colbox">
                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Categoria</p>
                            <span>roupas</span>
                        </div>
                    </div>
                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Subcategoria</p>
                            <span>camisas</span>
                        </div>
                    </div>
                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Valor</p>
                            <span>R$ 14,90</span>
                        </div>
                    </div>
                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Vendidos</p>
                            <span>0</span>
                        </div>
                    </div>
                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Prazo de envio</p>
                            <span>5 dias</span>
                        </div>
                    </div>
                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Frete</p>
                            <span>Grátis</span>
                        </div>
                    </div>
                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Estoque</p>
                            <span>5</span>
                        </div>
                    </div>
                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Status</p>
                            <form class="form-modern" action="" method="POST">
                                <div class="checkbox-container">
                                    <div class="checkboxies">
                                        <label class="checkbox" style="border: none;padding: 0;">
                                            <span><span class="fa fa-square-o"></span> visível</span>
                                            {!! Form::checkbox('status','0') !!}
                                        </label>
                                    </div>
                                    <span class="alert{{ $errors->has('genre') ? '' : ' hidden' }}">{{ $errors->first('genre') }}</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="colbox">

                </div>
                <div class="colbox">
                    <div class="colbox-full">
                        <div class="pop-info-user">
                            <p>Descrição</p>
                            <span>{!! $result->details !!}</span>
                        </div>
                    </div>
                    <div class="colbox-full">
                        <div class="pop-info-user">
                            <p>Galeria</p>
                            <div class="colbox">
                                @forelse( $result->galeries as $galery)
                                <div class="colbox-5">
                                    <img src="{{url('imagem/produto/'.$galery->image.'?w=130&h=130&fit=crop')}}">
                                </div>
                                @empty
                                    <div class="colbox-5">
                                        <img src="s">
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear-both"></div>
            </div>
        </div>
    </div>
</div>
</div>