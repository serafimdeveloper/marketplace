<div class="alertbox" id="jq-new-rating">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Avaliar {{ $request->store->name }}</h2>
            <div class="jq-content-rate">

                <p class="fontem-16 txt-center">
                    @if(!isset($request->shopvaluation))
                        Avalie como foi sua experiência com esse vendedor?
                    @else
                        Pedido já avaliado. <b>Obrigado!</b>
                    @endif
                </p>
                <div class="colbox">
                    <div class="colbox-3">
                        <div class="pop-rating">
                            <h3>Prazo de entrega</h3>
                            <div class="rating"
                                 data-rate-value={{isset($request->shopvaluation) ? $request->shopvaluation->note_term : 5}} data-item="delivery"></div>
                        </div>
                    </div>
                    <div class="colbox-3">
                        <div class="pop-rating">
                            <h3>Qualidade do produto</h3>
                            <div class="rating"
                                 data-rate-value={{isset($request->shopvaluation) ? $request->shopvaluation->note_term : 5}} data-item="product"></div>
                        </div>
                    </div>
                    <div class="colbox-3">
                        <div class="pop-rating">
                            <h3>Atendimento</h3>
                            <div class="rating"
                                 data-rate-value={{isset($request->shopvaluation) ? $request->shopvaluation->note_service : 5}} data-item="attendance"></div>
                        </div>
                    </div>
                </div>
                <div class="clear-both"></div>
                @if(!isset($request->shopvaluation))
                    <form class="form-modern pop-form sendRating" action="javascript:void(0)" method="POST">
                        {!! Form::textarea('message', null ,['id' => 'msgS2', 'class' => 'limiter-textarea', 'maxlength' => '500', 'placeholder'=>'Informe aqui sua mensagem', 'rows'=>'7']) !!}
                        <span class="limiter-result" for="msgS2" data-limit="500">500</span>
                        <div class="clear-both"></div>
                        @if(!isset($request->shopvaluation))
                            <div class="txt-center">
                                <button type="submit" class="btn btn-popmartin">enviar</button>
                            </div>
                        @endif
                    </form>
                @else
                    <div class="content">
                        <p>Comentário</p>
                        <div class="padding10-20 bg-white">
                            {{ $request->shopvaluation->comment }}
                        </div>
                    </div>
                    <div class="txt-center">
                        <span class="btn btn-popmartin jq-close-alertbox">fechar</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
