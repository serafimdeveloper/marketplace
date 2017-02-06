<div class="alertbox address">
        <div class="alertbox-container">
            <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
            <div class="alertbox-content">
                <h2 class="alertbox-title">Cadastrar novo endereço</h2>
                <form action="javascript:void(0)" class="form-modern" id="form-adress">
                    {{ csrf_field() }}
                    <label><input type="hidden" name="id" value=""/></label>
                    <div class="colbox">
                        <div class="colbox-2">
                            <label>
                                <span>Destinatário: </span>
                                <input type="text" name="name" value="" placeholder="Informe um nome">
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
                                        <a href="javascript:void(0)" class="btn btn-small btn-popmartin" style="color: #FFF;">Não sei meu cep</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="colbox">
                        <div class="colbox-3">
                            <label>
                                <span>UF:</span>
                                <input type="text" name="state" value="" placeholder="Digite sua UF">
                                <span class="alert hidden"></span>
                            </label>
                        </div>
                        <div class="colbox-3">
                            <label>
                                <span>Município:</span>
                                <input type="text" name="city" value="" placeholder="Digite seu Município">
                                <span class="alert hidden"></span>
                            </label>
                        </div>
                        <div class="colbox-3">
                            <label>
                                <span>Bairro:</span>
                                <input type="text" name="neighborhood" value="" placeholder="Digite seu Bairro">
                                <span class="alert hidden"></span>
                            </label>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                    <label>
                        <span>Endereço:</span>
                        <input type="text" name="public_place" value="" placeholder="Digite seu Endereço">
                        <span class="alert hidden"></span>
                    </label>
                    <div class="colbox">
                        <div class="colbox-2">
                            <label>
                                <span>Número:</span>
                                <input type="text" name="number" value="" placeholder="Digite seu número">
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
                    <div class="checkbox-container padding10">
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