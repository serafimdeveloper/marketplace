<div class="alertbox address" id="alert-address">
        <div class="alertbox-container">
            <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
            <div class="alertbox-content">
                <h2 class="alertbox-title">Cadastrar novo endereço</h2>
                <form action="javascript:void(0)" class="form-modern" id="form-adress">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value=""/>
                    <div class="colbox">
                        <div class="colbox-2">
                            <label>
                                <span>Destinatário: </span>
                                {!! Form::text('name', null, ['placeholder' => 'Informe um nome', 'data-required' => 'notnull']) !!}
                                <span class="alert hidden"></span>
                            </label>
                        </div>
                        <div class="colbox-2">
                            <div class="colbox">
                                <div class="colbox-2">
                                    <label>
                                        <span>CEP:</span>
                                        <input type="text" id="zip_code" name="zip_code" value="" placeholder="Digite um CEP" onkeyup="maskInt(this)">
                                        <span class="alert hidden"></span>
                                    </label>
                                </div>
                                <div class="colbox-2">
                                    <div class="form-btn-cep">
                                        <a href="javascript:void(0)" class="btn btn-small btn-popmartin jq-whichcep" style="color: #FFF;">Não sei meu cep</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="colbox">
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
                        <div class="colbox-3">
                            <label>
                                <span>Bairro:</span>
                                {!! Form::text('neighborhood', null, ['placeholder' => 'Digite seu Bairro', 'data-required' => 'notnull']) !!}
                                <span class="fa fa-spinner fa-spin jq-loader dp-none loader-address"></span>
                                <span class="alert hidden"></span>
                            </label>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                    <label>
                        <span>Endereço:</span>
                        {!! Form::text('public_place', null, ['placeholder' => 'Digite seu Endereço', 'data-required' => 'minlength', 'data-minlength' => 5]) !!}
                        <span class="fa fa-spinner fa-spin jq-loader dp-none loader-address"></span>
                        <span class="alert hidden"></span>
                    </label>
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
                    <div class="checkbox-container padding10" id="chk-master">
                        <div class="checkboxies">
                            <label class="checkbox" style="border-color: #888888;border: none;">
                                <span><span class="fa fa-square-o"></span> marcar como endereço principal</span>
                                {!! Form::checkbox('master', 1) !!}
                            </label>
                        </div>
                    </div>
                    <div class="txt-center">
                        <button type="submit" class="btn btn-popmartin">cadastrar</button>
                    </div>
                    <div class="form-result"></div>
                </form>
                <div class="txt-right" style="margin-top: 10px;">
                    <div class="address_remove"></div>
                </div>
            </div>
        </div>
    </div>
<div class="alertbox whichcep">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <div class="padding20"></div>
            <form class="form-modern" action="javascript:void(0)" method="POST">
                <label>
                    {!! Form::text('', null, ['placeholder' => 'Informe seu endereço. Exemplo: Rua Joaquim Pacheco', 'data-required' => 'minlength', 'data-minlength' => 8]) !!}
                    <span class="alert hidden"></span>
                    <button type="submit" class="btn btn-small btn-popmartin" style="float: right;margin: -35px 10px 0 0;">buscar</button>
                </label>
            </form>
            <div class="scroll" style="max-height: 300px;">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="t-small">CEP</th>
                        <th>Endereço</th>
                    </tr>
                    </thead>
                    <tbody class="pop-select-cep">
                    {{--<tr data-cep="27286210">--}}
                    {{--<td>27286210</td>--}}
                    {{--<td>Rua Dom Antônio cabral | <b>São Luís - Volta Redonda</b> - RJ</td>--}}
                    {{--</tr>--}}
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>