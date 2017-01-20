/**
 * Created by asiw.com.br on 16/01/2017.
 */
$(function () {

    /**
     * Estilização dos banners de anúncios usando o plugin owlCarousel
     */
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        responsive: {0: {items: 1}, 400: {items: 2}, 600: {items: 3}, 700: {items: 4}, 900: {items: 5}}
    });

    /**
     * Verifica os input segundo as regras atribuídas e para a escução caso haja um submit
     */
    $('.form-modern').each(function () {
        verificaform($(this));
        $(this).submit(function () {
            if (!verifySubmit($(this))) {
                return false;
            }
        });
    });

    /**
     * efeito slidetoogle do menu no topo com nome do usuário
     */
    $('.pop-top-header').find('.menu > a').click(function () {
        $(this).siblings('.menu-hidden').slideToggle();
        return false;
    });

    /**
     * Abre modal com formulário de preenchimento de endereço
     * Requisita endereço via ajax caso seja uma edição
     * Caso seja um cadastro, apnenas abre para preenchimento
     */
    $(document).on('click', '.jq-address', function(){
        if(typeof ($(this).data('id')) !== "undefined"){
            $('.alertbox-title').text('Editar endereço');
            $('.address_remove').html('<span class="btn btn-small btn-red jq-remove-address" data-id("'+$(this).data('id')+'")><i class="fa fa-trash"></i> remover endereço</span>');
            $('.address').find('button').text('atualizar');
            $.get('/accont/adresses/'+$(this).data('id'), function(data){
                inputvalue(data);
            },'json');
        }else{
            $('.alertbox-title').text('Cadastrar endereço');
            $('.address').find('button').text('cadastrar');
        }

        $('.address').show();
    });

    /**
     * Menu mobile do painel de administração dos usuários
     */
    $('.panel-icon-mobile').click(function () {
        if($('.panel-nav').is(':visible')){
            $(this).find('i').attr('class', 'fa fa-chevron-down');
        }else{
            $(this).find('i').attr('class', 'fa fa-chevron-up');
        }
        $('.panel-nav').slideToggle();
    });


    /**
     * Procura de loja em tempo real no painel
     */
    $(".searh_store input[name=search_store]").keyup(function () {
        var data = 'token=token&action=searchStore&value=' + $(this).val();
        var implementTr = $('#pop-searchStore tbody');
        $.ajax({
            url: '',
            data: data,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                implementTr.html("<tr><td colspan=\"3\"><i class='fa fa-spin fa-spinner'></i> procurando...</td></tr>")
            },
            success: function (e) {
                implementTr.html(e.resulttr);
            }
        });
    });

    /**
     * Busca o cep na API do correio
     */

     $('#zip_code').focusout(function() {
        var cep = $(this).val();
        if((/^\d{5}-?\d{3}$/).test(cep)){
            $.get('/accont/adresses/zip_code/'+cep, function(data){
               var dados =  {'state':data.uf, 'city':data.cidade,'neighborhood':data.bairro,'public_place':data.logradouro};
               inputvalue(dados);
            },"json");
        }else{
            inputerror(false,$(this),'Cep inválido');
        }
     });

    /**
     * grava ou atualiza o novo endereço
     */

    $('#form-adress').on('submit', function(event){
        var form = $(this);
        var dados = form.serialize();
        var id = form.find('input[name=id]').val();
        if(id.length == 0){
            $.ajax({
                url: '/accont/adresses/',
                type: 'POST',
                dataType: 'json',
                data: dados,
                beforeSend: function(){
                    form.find('button').html('<i class="fa fa-spin fa-spinner"></i> cadastrando...');
                },
                error: function(data, status){
                    form.find('button').html('cadastrar');
                    var trigger = JSON.parse(data.responseText);
                    console.log(trigger);
                    $.each(trigger, function(index,element){
                        inputerror(false, form.find('input[name='+index+']'), element[0]);
                    });
                },
                success: function(data){
                    if(!data.status){
                        form.find('button').html('cadastrar');
                        form.find('.form-result').html('<p class="trigger error">'+data.msg+'</p>');
                    }else{
                        form.find('button').html('cadastrado com sucesso!');
                        form.parents('.address').slideUp(function(){
                            if(data.adress.master){
                                $('#group-pnl-end').find('.address-master').text('');
                                $('#group-pnl-end').prepend(window_adress(data.adress));
                            }else{
                                $('#group-pnl-end').append(window_adress(data.adress));
                            }
                        });
                    }
                }
            });
        }else{
            $.ajax({
                url: '/accont/adresses/'+id,
                type: 'PUT',
                dataType: 'json',
                data: dados,
                beforeSend: function(){
                    form.find('button').html('<i class="fa fa-spin fa-spinner"></i> atualizando...');
                },
                success: function(data){
                    form.find('button').html('atualizado com sucesso!');
                    form.parents('.address').slideUp(function(){
                        $('#end_'+data.id).replaceWith(window_adress(data.adress));
                    });
                }
            });            
        }
        return false;
    });

    /**
     * Modelo de container aprecer conforme clique menu
     */
    $(".select_type_sallesman input").on("click", function () {
        radiobox($(this));
        $(".selects_people:visible").slideUp();
        if($(this).val() === 'F'){
            $('.select_cpf').slideDown();
        }else{
            $('.select_cnpj').slideDown();
        }
        return false;
    });

});

/**
 * Verifica qual o campo do input para filtrar de acordo com sua característica
 * @param t object html DOM <input>
 * @returns {boolean}
 */
function switchForm(t){
    var r = false;
    switch (t.attr('name')) {
        case 'email':
            r = inputerror(is_mail(t.val()), t, 'e-mail inválido!');
            break;
        case 'password':
            r = inputerror(is_count(6, t.val()), t, 'senha deve ter no mínimo 6 caracteres!');
            break;
        default:
            r = true;
    }
    return r;
}

/**
 * verifica os input de acordo com as regras estipuladas e chama uma função que determina um erro
 * @param object html DOM
 */
function verificaform(f) {
    f.find("input").focusout(function () {
        var t = $(this);
        switchForm(t);
    }).focusin(function () {
        $(this).removeClass('input-error').siblings('.alert').addClass('hidden');
    });
}
/**
 * Verifica os campos do formulário para acionar uma ação
 * @param f object html DOM <form>
 * @returns {boolean}
 */
function verifySubmit(f){
    var r = false;
    f.find('input').each(function(){
        var t = $(this);
        r = switchForm(t);
        if(!r){
            return false;
        }
    });
    return r;
}
/**
 * Verifica de o campo input. Se is retorna false, gera um erro
 * @param is retorno de uma função de verificação
 * @param param object html DOM <input>
 * @param msg string mensagem a ser apresentada
 * @returns {boolean}
 */
function inputerror(is, param, msg) {
    if (!is) {
        param.addClass('input-error').siblings('.alert').removeClass('hidden').text(msg);
        return false;
    }else{
        return true;
    }
}

/**
 * Recebe um objeto e faz iteração neles passando pra uns inputs
 * @param inputs object 
 */

function inputvalue(inputs){
    if(inputs instanceof Object){
        $.each(inputs, function(index,element){
            if(index === 'state'){
                element = element.substr(0, 2);
            }
            if(!is_Number(element)){
                element = element.replace(/\s+/g," ");
            }
            $('input[name='+index+']').val(element);

            var master = $("#form-adress .checkbox").find("input[name=master]");

            if(index === 'master' && element){
                $("#form-adress .checkbox").find('.fa').attr('class', 'fa fa-check-square-o');
                if(!master.is(":checked")){
                    master.click();
                }

            }else{
                if(master.is(":checked")){
                    master.click();
                }
            }
        });

    }
}

function window_adress(obj){
    obj.master = (obj.master ? 'principal' : '');
    var janela = '<div class="panel-end" id="end_'+obj.id+'">';
    janela+='<h4>'+obj.name+' <span class="fl-right address-master">'+obj.master+'</span></h4>';
    janela+='<div class="panel-end-content">';
    janela+='<p>CEP: '+obj.zip_code+'</p>';
    janela+='<p> '+obj.public_place+', '+obj.number+' - '+obj.city+'</p>';
    janela+='</div>';
    janela+='<a href="javascript:void(0)" class="panel-end-edit vertical-flex jq-address" data-id="'+obj.id+'">editar</a>';
    janela+='</div>';
    return janela;
}