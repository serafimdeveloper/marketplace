/**
 * Criado por asiw
 * @author: asiw - contato@asiw.com.br
 */
$(function () {

    /**
     * Carousel para container de publicidade no topo do site
     * @type {{loop: boolean, margin: number, responsive: {0: {items: number}, 400: {items: number}, 600: {items: number}, 700: {items: number}, 900: {items: number}}, autoplay: boolean, autoplayTimeout: number, autoplayHoverPause: boolean}}
     */
    var owlAds = {
        loop: true,
        margin: 30,
        responsive: {0: {items: 1}, 400: {items: 2}, 600: {items: 3}, 700: {items: 4}, 900: {items: 5}},
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
    }
    $(".pop-ads").owlCarousel(owlAds);

    /**
     * Carousel para container de apresentação de produtos na página inicial do site
     * @type {{loop: boolean, margin: number, nav: boolean, navText: [*], dots: boolean, responsive: {0: {items: number}, 400: {items: number}, 600: {items: number}, 700: {items: number}, 900: {items: number}}, autoplay: boolean, autoplayTimeout: number, autoplayHoverPause: boolean}}
     */
    var owlHomeProducts = {
        loop: true,
        margin: 30,
        nav: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        dots: false,
        responsive: {0: {items: 1}, 400: {items: 2}, 600: {items: 3}, 700: {items: 4}, 900: {items: 5}},
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
    }
    $(".pop-home-prd").owlCarousel(owlHomeProducts);


    /**
     * Alert Dialog Systen
     * @type {{open: boolean, width: string, maxWidth: number, description: boolean, type: string}}
     */
    var obsrequest = {
        open: true,
        width: '80%',
        maxWidth: 500,
        description: false,
        type: 'form'
    }
    $('.obsRequest').on('click', function () {
        $(this).bsdialog(obsrequest);
    });



    /** Inicia plugin tooltipster */
    $('.tooltip').tooltipster();

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

    $('.pop-search').submit(function () {
        var val = ($(this).find("input[name=search]").val() != '' ? $(this).find("input[name=search]").val() : 'pesquisa');
        window.location = $(this).attr('action') + '/' + val;
        return false;
    })


    /**
     * efeito slidetoogle do menu no topo com nome do usuário
     */
    $('.pop-top-header').find('.menu > a').click(function () {
        $(this).siblings('.menu-hidden').slideToggle();
    });

    /**
     * Abre modal com formulário de preenchimento de endereço
     * Requisita endereço via ajax caso seja uma edição
     * Caso seja um cadastro, apnenas abre para preenchimento
     */
    $(document).on('click', '.jq-address', function () {
        if (typeof ($(this).data('id')) !== "undefined") {
            var action = $(this).data('action');
            console.log(action);
            $('.alertbox-title').text('Editar endereço');
            $('.address_remove').html('<span class="btn btn-small btn-red jq-remove-address" data-id("' + $(this).data('id') + '")><i class="fa fa-trash"></i> remover endereço</span>');
            $('.address').find('button').text('atualizar');
            $.get('/accont/adresses/'+action+'/'+ $(this).data('id'), function (data) {
                console.log(data);
                inputvalue(data);
            }, 'json');
        } else {

            $('.alertbox-title').text('Cadastrar endereço');
            $('.address').find('button').text('cadastrar');
        }
        $('.address').find('form').attr('data-action',action);
        $('.address').show();
    });

    /**
     * Menu mobile do painel de administração dos usuários
     */
    $('.panel-icon-mobile').click(function () {
        if ($('.panel-nav').is(':visible')) {
            $(this).find('i').attr('class', 'fa fa-chevron-down');
        } else {
            $(this).find('i').attr('class', 'fa fa-chevron-up');
        }
        $('.panel-nav').slideToggle();
    });

    /**
     * Procura de loja em tempo real no painel
     */
    $(".jq-input-search").keyup(function () {
        var data = '_token=' + $('input[name=_token]').val() + '&name=' + $(this).val();
        var implementTr = $('#jq-search-table-result tbody');
        $.ajax({
            url: '/accont/searchstore',
            data: data,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                implementTr.html("<tr><td colspan=\"2\"><i class='fa fa-spin fa-spinner'></i> procurando...</td></tr>")
            },
            success: function (e) {
                implementTr.html('');
                $.each(e, function (i, element) {
                    console.log(element);
                    implementTr.append('<tr><td><a href="/' + element.slug + '" class="fontem-12 c-green-avocadodark">' + element.name + '</a></td><td>' + element.salesman + '</td></tr>');
                });
            }
        });

    });

    /**
     * Busca o cep na API do correio
     */

    $('#zip_code').focusout(function () {
        var cep = $(this).val();
        if ((/^\d{5}-?\d{3}$/).test(cep)) {
            $.get('/accont/adresses/zip_code/' + cep, function (data) {
                var dados = {
                    'state': data.uf,
                    'city': data.cidade,
                    'neighborhood': data.bairro,
                    'public_place': data.logradouro
                };
                inputvalue(dados);
            }, "json");
        } else {
            inputerror(false, $(this), 'Cep inválido');
        }
    });

    /**
     * Máscara do Telefone e Celular
     */
     $('.celphone').bind("keyup", function(e){
             var valor = $(this).val();
         console.log(valor.length);
         if((',8,37,39,').indexOf(','+e.keyCode+',')){
             valor = valor.replace(/[^0-9]+g/, "");

             if (valor.length > 2 && valor.length <= 5) {
                 $(this).val('(' + valor.substring(0, 2) + ') ');
             }
             else if (valor.length == 9) {
                 $(this).val(valor.substring(0,9) + "-");
             }
             else if (valor.length == 14) {
                 var hifen = valor.indexOf('-');
                 if (hifen != 9) {
                     var elem = valor.charAt(hifen - 1);
                     valor = valor.replace(elem + '-', '-' + elem);
                 }
                 $(this).val(valor.substring(0, 14));
             }
             else if (valor.length == 15) {
                 var hifen = valor.indexOf('-');
                 if (hifen == 9) {
                     var elem = valor.charAt(hifen + 1);
                     valor = valor.replace('-' + elem, elem + '-');
                 }
                 $(this).val(valor.substring(0, 15));
             }
         }
    });

    $('.celphone').on('focusout', function(e){
       if (!(/\([0-9]{2}\)[\s][0-9]{4,5}-[0-9]{4}/.test($(this).val()))){
           $(this).val('');
           $(this).next('span').removeClass('hidden').text('Telefone inválido');
       }
    });

    $('.alertbox-close').click(function () {
        var form = $(this).siblings('div').find('form');
        clear_input(form);
        if(form.find(":checkbox").is(":checked")){
            form.find(":checkbox").click();
        }
        // console.log();
    })
    /**
     * grava ou atualiza o novo endereço
     */

    $('#form-adress').on('submit', function (event) {
        var form = $(this);
        var action = $(this).data('action');
        var dados = form.serialize();
        var id = form.find('input[name=id]').val();
        if (id.length == 0) {
            $.ajax({
                url: '/accont/adresses/'+ action,
                type: 'POST',
                dataType: 'json',
                data: dados,
                beforeSend: function () {
                    form.find('button').html('<i class="fa fa-spin fa-spinner"></i> cadastrando...');
                },
                error: function (data, status) {
                    form.find('button').html('cadastrar');
                    var trigger = JSON.parse(data.responseText);
                    $.each(trigger, function (index, element) {
                        inputerror(false, form.find('input[name=' + index + ']'), element[0]);
                    });
                },
                success: function (data) {
                    if (!data.status) {
                        form.find('button').html('cadastrar');
                        form.find('.form-result').html('<p class="trigger error">' + data.msg + '</p>');
                    } else {
                        $("#isAddress").remove();
                        form.find('button').html('cadastrado com sucesso!');
                        form.parents('.address').slideUp(function () {
                            if (data.adress.master) {
                                $('#group-pnl-end').find('.address-master').text('');
                                $('#group-pnl-end').prepend(window_adress(data.adress, data.action));
                            } else {
                                $('#group-pnl-end').append(window_adress(data.adress, data.action));
                            }
                        });
                    }
                }
            });
        } else {
            $.ajax({
                url: '/accont/adresses/'+ action +'/'+ id,
                type: 'POST',
                dataType: 'json',
                data: dados,
                beforeSend: function () {
                    form.find('button').html('<i class="fa fa-spin fa-spinner"></i> atualizando...');
                },
                success: function (data) {
                    form.find('button').html('atualizado com sucesso!');
                    form.parents('.address').slideUp(function () {
                        if(data.adress.master == 1){
                            $('.panel-end h4 .address-master').text(" ");
                        }
                        $('#end_' + data.adress.id).replaceWith(window_adress(data.adress, data.action));
                    });
                }
            });
        }
        clear_input(form);
        return false;
    });

    /**
     * Modelo de container aprecer conforme clique menu
     */
    $(".select_type_sallesman input").on("click", function () {
        $(".selects_people:visible").slideUp();
        if ($(this).val() === 'F') {
            $('.select_cpf').slideDown();
            $(".selects_people").find('input[name=cpf]').removeAttr('disabled');
        } else {
            $('.select_cnpj').slideDown();
            $(".select_cnpj").find('input').val('');
            $(".selects_people").find('input[name=cpf]').attr('disabled','disabled');
        }
        call(radiobox);
        return false;
    });

    /** Trazer subcategoria de acordo com a categoria selecionada */
    $('.select_subcat').change(function () {
        var id = $(this).val();
        $.post('', {category_id: id}, function (data) {
            $('.subcat_info').html(data.option);
        }, "json");
    });

    /**
     * Verificar ao clicar em selecionar mensagem se o botão de remover aparece ou não
     */
    $(".select_msg").click(function () {
        var array = checkInputsMsg($(this).attr('class'));
        if (array.length !== 0) {
            $("#pop-remove-msg").show();
        } else {
            $("#pop-remove-msg").hide();
        }
    });

    /**
     * Apagar mensagens selecionadas em tempo real
     */
    $("#pop-remove-msg").click(function () {
        var indexes = arrayToObject(checkInputsMsg('select_msg'));
        $.get('', indexes, function (response) {
            if (response.status) {
                indexes.each(function (e) {
                    $('.select_msg').eq(e).hide();
                });
            }
        }, 'json');
        return false;
    });

    /**  */
    $(".wt-header span").click(function () {
        windowToggle($(this), 'wt-selected');
    });

    /** Eventos para a troca de imagens da galeria */
    $(".pop-product-galery img").click(function () {
        $(this).parent().siblings().css({opacity: 0.5})
        $(this).parent().css({opacity: 1});
        var src = $(this).attr('src');
        var src = src.split('?');
        var newSrc = src[0] + '?w=500&h=500&fit=crop';
        console.log(newSrc);

        $("#img-product").attr('src', newSrc);
    });

    $('.show-formobs').click(function () {
        $(this).hide().siblings('form').show().find('textarea').focus();
    });
    $('.pop-cart-obs form a').click(function () {
        $(this).parents('form').hide().siblings('.show-formobs').show();
    });
    $('.panel-nav').height($(document).height() - $('.footer').height() - $('.pop-top-header').height());
});
/** Modal de informações de usuarios */
$(document).on('click', '.jq-info-user', function(){
    $("#jq-info-user").slideDown();
});
/** Modal de informações de produtos */
$(document).on('click', '.jq-info-sales', function(){
    $("#jq-info-sales").slideDown();
});

/** Modal de informações das notificações */
$(document).on('click', '.jq-notification', function(){
    $("#jq-notification").slideDown();
});

/** Modal de informações de produtos */
$(document).on('click', '.jq-info-product', function(){
    $("#jq-info-product").slideDown();
});


/** Modal de atualização e cadastro de banners */
$(document).on('click', '.jq-new-banner', function(){
    var e = $(this);
    var modal = $("#jq-new-banner");
    var form = modal.find('form');
    var title = (e.data('banner') ? 'Atualizar banner - loja' : 'Cadastrar banner');
    var buttonText = (e.data('banner') ? 'atualizar' : 'cadastrar');
    modal.find('h2').text(title);
    modal.find('button').text(buttonText);

    $.get('', e.data('banner'), function (response) {
        inputvalue(response);
        form.find('select').find('option').each(function () {
            if($(this).val() == response.id){
                $(this).attr('selected', 'true');
                return false;
            }
        });
    })
    $("#jq-new-banner").slideDown();
});

/**
 * Abrir modal de categoria
 */
$(document).on('click', '.jq-new-category', function(){
    var e = $(this);
    var modal = $("#jq-new-category");
    var form = modal.find('form');
    var title = (e.data('category') ? 'Atualizar categoria - nome da categoria' : 'Cadastrar categoria');
    var buttonText = (e.data('category') ? 'atualizar' : 'cadastrar');
    var category = (e.data('category') ? '/'+e.data('category') : '');
    modal.find('h2').text(title);
    modal.find('button').text(buttonText);

    $.get('/accont/category'+category, function (response) {
        var select = form.find('select');
        select.html('<option value="">Escolher uma categória pai</option>');
        if(response.category){
            var dados = {'id':response.category.id,'name':response.category.name};
            inputvalue(dados);
        }
        $.each(response.categories, function (i,obj) {
            var selected = '';
            if(response.category){
                selected = (response.category.category_id === i) ? ' selected="selected"' : '';
            }
            select.append('<option value="'+i+'"'+selected+'>'+obj+'</option>');
        });
    });

    $("#jq-new-category").slideDown();
});

/**
 * Atualizar e cadastrar categorias no sistema
 */
$(document).on('submit', '#jq-new-category form', function(){
    var form = $(this);
    var dados = form.serialize();
    console.log(dados);
    var id = $('input[name=id]').val();
    var buttonText = form.find('button').text();
    var buttonTextloading = '<i class="fa fa-spin fa-spinner"></i> processando...';

    if (!id) {
        $.ajax({
            url: '/accont/category',
            type: 'POST',
            dataType: 'json',
            data: dados,
            beforeSend: function () {
                form.find('button').html(buttonTextloading);
            },
            error: function (data, status) {
                form.find('button').html(buttonText);
            },
            success: function (data) {
                form.find('button').html(buttonText);
            }
        });
    } else {
        $.ajax({
            url: '/accont/category/'+id,
            type: 'PUT',
            dataType: 'json',
            data: dados,
            beforeSend: function () {
                form.find('button').html(buttonTextloading);
            },
            success: function (data) {
                form.find('button').html(buttonText);
            }
        });
    }
    clear_input(form);
    return false;
});

// $(document).on('click', '.pop-remove-product-cart', function(){
//     var pr = $(this).parents("tr");
//     var countProducts = $("#jq-count-product");
//     var prId = pr.attr('id');
//     var prThis = pr.parents('tbody').find('tr').length;
//
//
//     console.log(prThis);

    // $.get('', {product_id: prId}, function (response) {
    //     if(response.status === true){
    //         countProducts.text((parseInt(countProducts.text() - 1) >= 0 ? parseInt(countProducts.text() - 1) : 0));
    //         if (prThis > 1) {
    //             pr.slideUp().remove('');
    //         } else {
    //             pr.parents('.pop-cart').slideUp().html('');
    //         }
    //     }
    // }, "json");
// });


/**
 * verivica se um determinado grupo de mensagens de array estão checados(marcados) ou não
 * Retorna um array com a posição index e os valores dos inputs marcados respectivamente
 * @param class_element - classe em comun dos elementos
 * @returns {Array}
 */
function checkInputsMsg(class_element) {
    var status = [];
    $('.' + class_element).each(function () {
        var idx = $(this).index('.' + class_element);
        if ($(this).is(':checked')) {
            status[idx] = $(this).val();
        }
    });
    return status;
}

/**
 * Verifica qual o campo do input para filtrar de acordo com sua característica
 * @param t object html DOM <input>
 * @returns {boolean}
 */
function switchForm(t) {
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
function verifySubmit(f) {
    var r = false;
    f.find('input').each(function () {
        var t = $(this);
        r = switchForm(t);
        if (!r) {
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
    } else {
        return true;
    }
}

/**
 * Recebe um objeto e faz iteração neles passando pra uns inputs
 * @param inputs object
 */

function inputvalue(inputs, e) {
    if (inputs instanceof Object) {
        $.each(inputs, function (index, element) {
            if(element) {
                if (index === 'state') {
                    element = element.substr(0, 2);
                }
                if (!is_Number(element)) {
                    element = element.replace(/\s+/g, " ");
                }
                $('input[name=' + index + ']').val(element);

                var master = $("#form-adress .checkbox").find("input[name=master]");

                if (index === 'master' && element) {
                    $("#form-adress .checkbox").find('.fa').attr('class', 'fa fa-check-square-o');
                    if (!master.is(":checked")) {
                        master.click();
                    }
                } else {
                    if (master.is(":checked")) {
                        master.click();
                    }
                }
            }
        });

    }
}

function window_adress(obj, action) {
    obj.master = (obj.master ? 'principal' : '');
    var janela = '<div class="panel-end" id="end_' + obj.id + '">';
    if(action === 'user'){
        janela += '<h4>' + obj.name + ' <span class="fl-right address-master">' + obj.master + '</span></h4>';
    }else{
        janela += '<h4><span>Endereço da Loja</span></h4>';
    }
    janela += '<div class="panel-end-content">';
    janela += '<p>CEP: ' + obj.zip_code + '</p>';
    janela += '<p> ' + obj.public_place + ', ' + obj.number + ' - ' + obj.city + '</p>';
    janela += '</div>';
    janela += '<a href="javascript:void(0)" class="panel-end-edit vertical-flex jq-address" data-id="' + obj.id + '" data-action="' + action + '">editar|excluir</a>';
    janela += '</div>';
    return janela;
}

function clear_input(form){
    var _token = form.find('input[name=_token]').val();
    form.find('input').val('');
    form.find('input[name=_token]').val(_token);
}