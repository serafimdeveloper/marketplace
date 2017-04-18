<div class="alertbox" id="alert-newcategory">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Cadastrar categoria</h2>
            <form class="form-modern pop-form" action="javascript:void(0)">
                {{ csrf_field() }}
                <input type="hidden" name="id" />
                <div class="colbox">
                    <div class="colbox-2">
                        <label>
                            <span>Nome</span>
                            <input type="text" name="name">
                        </label>
                    </div>
                    <div class="colbox-2">
                        <label>
                            <span>categoria Pai <i class="fa fa-info-circle c-blue tooltip" title="Não selecionar se esta for uma categoria genérica"></i></span>
                            <select name="category_id">
                                <option selected="true" disabled="true">Escolher uma categoria pai</option>
                            </select>
                        </label>
                    </div>

                </div>
                <div class="clear-both"></div>
                <div class="txt-center">
                    <button type="submit" class="btn btn-popmartin">cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>