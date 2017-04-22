<div class="alertbox" id="alert-newcategory">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Cadastrar categoria</h2>
            @if(isset($category))
                {!! Form::model($category,['class' => 'form-modern pop-form form-category', 'route' =>['accont.report.categories.update',$category->id], 'method' => 'PUT']) !!}
            @else
                {!! Form::open(['class' => 'form-modern pop-form form-category', 'route' => ['accont.report.categories.store'], 'method' => 'POST']) !!}
            @endif
                {{ csrf_field() }}
                <input type="hidden" name="id" />
                <div class="colbox">
                    <div class="colbox-2">
                        <label>
                            <span>Nome</span>
                            <input type="text" name="name" value="{{ (isset($category) ? $category->name : null) }}">
                        </label>
                    </div>
                    <div class="colbox-2">
                        <label>
                            <span>categoria Pai <i class="fa fa-info-circle c-blue tooltip" title="Não selecionar se esta for uma categoria genérica"></i></span>
                            @if($categories)
                                {!! Form::select('category_id',$categories,(isset($category) ? $category->category_id : null),['placeholder' => 'Selecione uma categoria pai', 'class'=>'jq-input-search']) !!}
                                @endif
                        </label>
                    </div>
                </div>
                <div class="clear-both"></div>
                <div class="txt-center">
                    <button type="submit" class="btn btn-popmartin" datat>{{isset($category) ? 'atualizar' : 'cadastrar'}}</button>
                </div>
            </form>
        </div>
    </div>
</div>