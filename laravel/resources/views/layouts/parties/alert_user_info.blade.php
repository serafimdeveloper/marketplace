<div class="alertbox" id="jq-info-user">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Nome completo do usuário</h2>
            <div class="pop-user-info">
                <div class="pop-user-info-action">
                    <a class="btn btn-small btn-popmartin fl-right"><i class="fa fa-trash"></i> remover usuário</a>
                </div>
                <div class="clear-both"></div>

                <div class="accordion">
                    <div class="accordion-box">
                        <div class="accordion-header"><span class="c-pop fontw-500">Dados do usuário:</span> <span
                                    class="fa fa-chevron-right"></span></div>
                        <div class="accordion-content">


                            <div class="colbox">
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>Nome</p>
                                        <span>Bruno Moura de jesus</span>
                                    </div>
                                </div>
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>Tipo</p>
                                        <span>vendedor</span>
                                        {{--<span>consumidor</span>--}}
                                    </div>
                                </div>
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>CPF</p>
                                        <span>124.758.7965-86</span>
                                    </div>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                            <div class="colbox">
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Gênero</p>
                                        <span>masculino</span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>nascimento</p>
                                        <span>03/06/1994</span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Data de cadastro</p>
                                        <span>03/06/1994</span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Último acesso</p>
                                        <span>03/06/1994</span>
                                    </div>
                                </div>
                                <div class="colbox-full">
                                    <div class="pop-info-user">
                                        <p>Contato</p>
                                        <span class="dp-inblock">e-mail | </span>
                                        <span class="dp-inblock">telefone fixo | </span>
                                        <span class="dp-inblock">telefone celular | </span>
                                        <span class="dp-inblock"><i class="fa fa-whatsapp c-green"></i> whatsapp</span>
                                    </div>
                                </div>
                                <div class="colbox-full">
                                    <div class="pop-info-user">
                                        <p>Endereço</p>
                                        <span>Rua Miguel Gustavo | 109 | Volta Redonda | RJ | Brasil | 27281-490</span>
                                    </div>
                                </div>
                            </div>
                            <div class="colbox">
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Moip</p>
                                        <span>login</span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Documento com foto</p>
                                        <span><a href="" class="btn btn-smallextreme btn-popmartin"
                                                 target="_blank">ver documento</a></span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Comprovante de residência</p>
                                        <span><a href="" class="btn btn-smallextreme btn-popmartin"
                                                 target="_blank">ver documento</a></span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Status</p>
                                        <form class="form-modern" action="" method="POST">
                                            <div class="checkbox-container">
                                                <div class="checkboxies">
                                                    <label class="checkbox" style="border: none;padding: 0;">
                                                        <span><span class="fa fa-square-o"></span> ativo</span>
                                                        {!! Form::checkbox('status','0') !!}
                                                    </label>
                                                </div>
                                                <span class="alert{{ $errors->has('genre') ? '' : ' hidden' }}">{{ $errors->first('genre') }}</span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Comissão (%)</p>
                                        <form class="form-modern pop-form pst-relative pop-tracking" action=""
                                              method="POST">
                                            <label>
                                                {!! Form::text('commission', '12.00', ['class' => 'masksMoney', 'placeholder' => 'código']) !!}
                                            </label>
                                            <button type="submit" class="btn btn-small btn-popmartin">atualizar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                    </div>
                    <div class="accordion-box">
                        <div class="accordion-header"><span class="c-pop fontw-500">Dados da loja:</span> <span
                                    class="fa fa-chevron-right"></span></div>
                        <div class="accordion-content">

                            <div class="colbox">
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>Loja <a href="/loja" class="btn btn-smallextreme btn-popmartin fl-right"
                                                   target="_blank">ver
                                                loja</a></p>
                                        <span>Nome da Loja</span>
                                    </div>
                                </div>
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>Nome fantasia</p>
                                        <span>nome</span>
                                    </div>
                                </div>
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>CNPJ</p>
                                        <span>não informado</span>
                                    </div>
                                </div>
                                <div class="colbox-full">
                                    <div class="pop-info-user">
                                        <p>Razão Social</p>
                                        <span>nome</span>
                                    </div>
                                </div>
                                <div class="colbox-2">
                                    <div class="pop-info-user">
                                        <p>Contato</p>
                                        <span>telefone | celular</span>
                                    </div>
                                </div>
                                <div class="colbox-full">
                                    <div class="pop-info-user">
                                        <p>Endereço</p>
                                        <span>Rua Miguel Gustavo | 109 | Volta Redonda | RJ | Brasil | 27281-490</span>
                                    </div>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>