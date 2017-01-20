<div class="alertbox address">
        <div class="alertbox-container">
            <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
            <div class="alertbox-content">
                <h2 class="alertbox-title">Cadastrar novo endereço</h2>
                <form action="javascript:void(0)" class="form-modern pop-form" id="form-adress">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value=""/>
                    <div class="colbox">
                        <div class="colbox-2">
                            <label>
                                <span class="title">Nome:</span>
                                <input type="text" name="name" value="" placeholder="Digite um Nome para o endereço">
                            </label>
                        </div>
                        <div class="colbox-2">
                            <label>
                                <span class="title">CEP:</span>
                                <input type="text" id="zip_code" name="zip_code" value="" placeholder="Digite um CEP">
                            </label>
                        </div>
                    </div>
                    <div class="colbox">
                        <div class="colbox-2">
                            <label>
                                <span class="title">UF:</span>
                                <input type="text" name="state" value="" placeholder="Digite sua UF">
                            </label>
                        </div>
                        <div class="colbox-2">
                            <label>
                                <span class="title">Município:</span>
                                <input type="text" name="city" value="" placeholder="Digite seu Município">
                            </label>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                    <label>
                        <span>Bairro:</span>
                        <input type="text" name="neighborhood" value="" placeholder="Digite seu Bairro">
                    </label>
                    <label>
                        <span>Endereço:</span>
                        <input type="text" name="public_place" value="" placeholder="Digite seu Endereço">
                    </label>
                    <div class="colbox">
                        <div class="colbox-2">
                            <label>
                                <span>Número:</span>
                                <input type="text" name="number" value="" placeholder="Digite seu número">
                            </label>
                        </div>
                        <div class="colbox-2">
                            <label>
                                <span>Complemento:</span>
                                <input type="text" name="complements" value="" placeholder="Seu Complemento"> 
                            </label>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                    <div class="txt-center">
                        <button type="submit" class="btn btn-teal">cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>