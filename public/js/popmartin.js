/**
 * Criado por asiw
 * @author: asiw - contato@asiw.com.br
 */

var alertfyConfirmTitle = 'Pop Martin alerta!';
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
        $(".alertbox .alertbox-container").css({top: $(document).scrollTop()});
        var action = $(this).data('action')
        console.log(action);
        if(action == 'store'){
            console.log(action);
            $('#form-adress').find("label span").first().text('Loja');
            $('#form-adress').find("label input").first().val('Endereço').attr('readonly', true);
        }
        if (typeof ($(this).data('id')) !== "undefined") {
            $('.alertbox-title').text('Editar endereço');
            $('.address_remove').html('<span class="btn btn-small btn-red jq-remove-address" data-id("' + $(this).data('id') + '")><i class="fa fa-trash"></i> remover endereço</span>');
            $('.address').find('button').text('atualizar');
            $.get('/accont/adresses/' + action + '/' + $(this).data('id'), function (data) {
                console.log(data);
                inputvalue(data);
            }, 'json');
        } else {

            $('.alertbox-title').text('Cadastrar endereço');
            $('.address').find('button').text('cadastrar');
        }
        $('.address').find('form').attr('data-action', action);
        $('.address').show();
    });

    $(document).on('click', '.jq-remove-address', function () {
        var element = $(this);
        alertify.confirm(alertfyConfirmTitle, 'Tem certesa de que deseja remover este endereço?',
            function () {
                var id = element.data('id');
                var index = {id: id}
                $.post('/adresses/destroy', index, function (response) {
                    if (response.status) {
                        alertify.success('Endereço removido!');

                    } else {
                        alertify.error(response.msg);
                    }
                }, 'json');
                $('.alertbox-close').click();
            }, function () {
                return true;
            });

        return false;
    })


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
                    implementTr.append('<tr><td><a href="/' + element.slug + '" class="fontem-12 c-green-avocadodark">' + element.name + '</a></td><td>' + element.salesman + '</td></tr>');
                });
            }
        });

    });

    /**
     * Busca o cep na API do correio
     */

    $('#zip_code').focusout(function () {
        var element = $(this);
        var cep = element.val();
        if ((/^\d{5}-?\d{3}$/).test(cep)) {
            $.ajax({
                url : '/accont/adresses/zip_code/' + cep,
                type: 'GET',
                dataType: 'json',
                beforeSend: function(){
                    element.parents('form').find('.loader-address').show();
                },
                success: function (data) {
                    var dados = {
                        'state': data.uf,
                        'city': data.cidade,
                        'neighborhood': data.bairro,
                        'public_place': data.logradouro
                    };
                    element.parents('form').find('.loader-address').hide();
                    inputvalue(dados);
                }
            })
        } else {
            inputerror(false, $(this), 'Cep inválido');
        }
    });

    /**
     * Máscara do Telefone e Celular
     */
    $('.celphone').bind("keyup", function (e) {
        var valor = $(this).val();
        console.log(valor.length);
        if ((',8,37,39,').indexOf(',' + e.keyCode + ',')) {
            valor = valor.replace(/[^0-9]+g/, "");

            if (valor.length > 2 && valor.length <= 5) {
                $(this).val('(' + valor.substring(0, 2) + ') ');
            }
            else if (valor.length == 9) {
                $(this).val(valor.substring(0, 9) + "-");
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

    /**
     * Máscara de telefone e celular.
     */
    $('.celphone').on('focusout', function (e) {
        if (!(/\([0-9]{2}\)[\s][0-9]{4,5}-[0-9]{4}/.test($(this).val()))) {
            $(this).val('');
            $(this).next('span').removeClass('hidden').text('Telefone inválido');
        }
    });

    /**
     * LIMPEZA DE CAMPOS AO FECHAR UM ALERTBOX
     */
    $('.alertbox-close').click(function () {
        var form = $(this).siblings('div').find('form');
        clear_input(form);
        if (form.find(":checkbox").is(":checked")) {
            form.find(":checkbox").click();
        }

        $('.jq-remove-address').hide();
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
                url: '/accont/adresses/' + action,
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
                url: '/accont/adresses/' + action + '/' + id,
                type: 'POST',
                dataType: 'json',
                data: dados,
                beforeSend: function () {
                    form.find('button').html('<i class="fa fa-spin fa-spinner"></i> atualizando...');
                },
                error: function (data, status) {
                    form.find('button').html('atualizar');
                    var trigger = JSON.parse(data.responseText);
                    $.each(trigger, function (index, element) {
                        inputerror(false, form.find('input[name=' + index + ']'), element[0]);
                    });
                },
                success: function (data) {
                    form.find('button').html('atualizado com sucesso!');
                    form.parents('.address').slideUp(function () {
                        if (data.adress.master == 1) {
                            $('.panel-end h4 .address-master').text(" ");
                        }
                        $('#end_' + data.adress.id).replaceWith(window_adress(data.adress, data.action));
                    });
                    clear_input(form);
                }
            });
        }
        return false;
    });

    /** CHAMAR MODAL BUSCA DE CEP*/
    $(document).on('click', '.jq-whichcep', function(){
        $('.whichcep').show();
    });

    /**
     * FORMULÁRIO DE RASTREIO DE CEP
     */
    $(document).on('keyup', '.whichcep .form-modern input', function(){
        var element = $(this);
        var data = element.val();
        var implementTr = $('.pop-select-cep');
        $.ajax({
            url : '/accont/adresses/zip_code/' + data,
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){
                implementTr.html('<tr><td colspan="2"><i class="fa fa-spin fa-spinner"></i></td></tr>');
            },
            success: function (response) {
                implementTr.html('');
                $.each(response, function (i, element) {
                    implementTr.append('<tr data-cep="' + element.cep + '"><td>' + element.cep + '</td><td>' + element.logradouro + ' | <b>' + element.bairro + ' - ' + element.cidade + '</b> - ' + element.estado + '</td></tr>');
                });
            }
        })
    });

    /**
     * CAPTAR CEP E IMPLEMENTAR NA MODAL DE ENDEREÇO
     */
    $(document).on('click', '.pop-select-cep tr', function(){
        var cep = $(this).data('cep');
        $('#zip_code').val(cep).focusout();
        $(this).parents('.alertbox').find('.alertbox-close').click();
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
            $(".selects_people").find('input[name=cpf]').attr('disabled', 'disabled');
        }
        call(radiobox);
        return false;
    });

    /** Trazer subcategoria de acordo com a categoria selecionada */
    $('.select_subcat').change(function () {
        var category = $(this).val();
        var loader = $(this).data('loader');
        if(category !== "") {
            $.ajax({
                url: '/accont/categories/subcategories/' + category,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $('.' + loader).show();
                },
                success: function (response) {
                    if(Object.keys(response.subcategories).length > 0){
                        $('.subcat_info').html('<option selected >Selecione uma Subcategoria</option>');
                        $.each(response.subcategories, function (i, e){
                            $('.subcat_info').append('<option value="'+i+'">'+e+'</option>');
                        });
                    }else{
                        $('.subcat_info').html('<option selected disabled>Nenhuma Subcategória</option>');
                    }
                    $('.' + loader).hide();

                }
            });
        }else{
            $('.subcat_info').html('<option selected disabled>Nenhuma Subcategória</option>');
        }
    });

    /**
     * Verificar ao clicar em selecionar mensagem se o botão de remover aparece ou não
     */
    $(".select_msg").click(function () {
        var array = checkInputsMsg($(this).attr('class'));
        if (array.length !== 0) {
            $("#pop-remove-msg").removeClass('btn-gray cursor-nodrop').addClass('btn-popmartin');
        } else {
            $("#pop-remove-msg").removeClass('btn-popmartin').addClass('btn-gray cursor-nodrop');
        }
    });

    /**
     * OPERAÇÃO DE CONTROLE DE ESTOQUE DE PRODUTOS
     */
    $('#type_operation_stock').on('change', function (e) {
        e.preventDefault();
        var count = $(this).siblings('input');
        var type = $(this).val() ? '/' + $(this).val() : '';
        console.log(type);
        var product_id = $('#product_id').val();
        var token = $('input[name=_token]').val();
        var loader = $(this).data('loader');
        if (count.val() > 0) {
            var data = {
                'product_id': product_id,
                'count': count.val(),
                '_token': token
            }
            $.ajax({
                url: '/accont/movement_stock' + type,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                    $('.' + loader).show();
                },
                error: function (response) {
                    console.log(response);
                },
                success: function (response) {
                    $('#quantity').val(response.product);
                    count.val(0);
                    $('.' + loader).hide();
                }
            });
        }
        resetChange($(this));
    });

    /**
     * resetar select
     * @param e
     */
    function resetChange(e) {
        e.children().removeAttr('selected');
    }
    /**
     * Apagar mensagens selecionadas em tempo real
     */

    $(document).on('click', "#pop-remove-msg.btn-popmartin", function () {
        var token = $(this).data('token');
        alertify.confirm(alertfyConfirmTitle, 'Tem certeza de que deseja remover?',
            function () {
                var indexes = arrayToObject(checkInputsMsg('select_msg'));
                var dados = {'ids':indexes, '_token':token};
                $.post('/accont/messages/destroy', dados, function (response) {
                    if (response.status) {
                        $.each(indexes, function (key, value) {
                            $('.select_msg').eq(key).parents('tr').hide(800);
                        });
                        // $('body').append('<p class="ajax-trigger accept">Menssagens excluída com sucesso</p>');
                    } else {
                        alertify.error(response.msg);
                    }
                }, 'json');
            }, function () {
                return true;
            });
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
$(document).on('click', '.jq-info-user', function () {
    $("#jq-info-user").slideDown();
});
/** Modal de informações de produtos */
$(document).on('click', '.jq-info-sales', function () {
    $("#jq-info-sales").slideDown();
});

/** Modal de informações das notificações */
$(document).on('click', '.jq-notification', function () {
    $("#jq-notification").slideDown();
});

/** Modal de informações de produtos */
$(document).on('click', '.jq-info-product', function () {
    $("#jq-info-product").slideDown();
});

/** Modal de atualização e cadastro de banners */
$(document).on('click', '.jq-new-banner', function () {
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
            if ($(this).val() == response.id) {
                $(this).attr('selected', 'true');
                return false;
            }
        });
    })
    $("#jq-new-banner").slideDown();
});

/**
 * ABRIR MODAL DE CATEGORIA
 */
$(document).on('click', '.jq-new-category', function () {
    var e = $(this);
    var modal = $("#jq-new-category");
    var form = modal.find('form');
    var title = (e.data('category') ? 'Atualizar categoria - nome da categoria' : 'Cadastrar categoria');
    var buttonText = (e.data('category') ? 'atualizar' : 'cadastrar');
    var category = (e.data('category') ? '/' + e.data('category') : '');
    modal.find('h2').text(title);
    modal.find('button').text(buttonText);

    $.get('/accont/categories' + category, function (response) {
        var select = form.find('select');
        select.html('<option value="">Escolher uma categória pai</option>');
        if (response.category) {
            var dados = {'id': response.category.id, 'name': response.category.name};
            inputvalue(dados);
        }
        $.each(response.categories, function (i, obj) {
            var selected = '';
            if (response.category) {
                selected = (response.category.category_id === i) ? ' selected="selected"' : '';
            }
            select.append('<option value="' + i + '"' + selected + '>' + obj + '</option>');
        });
    });

    $("#jq-new-category").slideDown();
});

/**
 * ATUALIZAR E CADASTRAR CATEGORIAS NO SISTEMA
 */
$(document).on('submit', '#jq-new-category form', function () {
    var form = $(this);
    var dados = form.serialize();
    console.log(dados);
    var id = $('input[name=id]').val();
    var buttonText = form.find('button').text();
    var buttonTextloading = '<i class="fa fa-spin fa-spinner"></i> processando...';

    if (!id) {
        $.ajax({
            url: '/accont/categories',
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
            url: '/accont/categories/' + id,
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
    switch (t.data('required')) {
        case 'notnull':
            r = inputerror(!compareLenght(t.val(), '<', 1), t, 'Campo não pode ser vazio');
            break;
        case 'name':
            var response = function () {
                if(is_numberString(t.val()) || compareLenght(t.val(), '<', 2)){
                    return false;
                }else{
                    return true;
                }
            }
            r = inputerror(response(), t, 'Nome inválido!');
            break;
        case 'last_name':
            var response = function () {
                if(is_numberString(t.val()) || compareLenght(t.val(), '<', 2)){
                    return false;
                }else{
                    return true;
                }
            }
            r = inputerror(response(), t, 'Sobrenome inválido!');
            break;
        case 'email':
            r = inputerror(is_mail(t.val()), t, 'e-mail inválido!');
            break;
        case 'email_confirm':
            var response = function(){
                if(!is_mail(t.val()) || (t.val() != t.parents('form').find('input[name=email_register]').val())){
                    return false;
                }else{
                    return true;
                }
            }
            r = inputerror(response(), t, 'e-mail não confere');
            break;
        case 'cpf':
            var response = function(){
                if(compareLenght(t.val(), '<', 14) || !is_cpf(t.val())){
                    return false;
                }else{
                    return true;
                }
            }
            r = inputerror(response(), t, 'cpf inválido!');
            break;

        case 'fullphone':
            r = inputerror(!compareLenght(t.val(), '<', 14), t, 'Telefone inválido');
            break;
        case 'cellphone':
            r = inputerror(!compareLenght(t.val(), '<', 15), t, 'Telefone inválido');
            break;
        case 'whatsapp':
            r = inputerror(!compareLenght(t.val(), '<', 14), t, 'Whatsapp inválido');
            break;
        case 'password':
            r = inputerror(!compareLenght(t.val(), '<', 6), t, 'senha deve ter no mínimo 6 caracteres!');
            break;
        case 'password_confirm':
            var response = function(){
                if(compareLenght(t.val(), '<', 6) || (t.val() != t.parents('form').find('input[name=password_register]').val())){
                    return false;
                }else{
                    return true;
                }
            }
            r = inputerror(response(), t, 'senha não confere!');
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
            if (element) {
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

/**
 * ATUALIZAR E APRESENTAR BOX DE ENDEREÇO NO PAINEL
 * @param obj
 * @param action
 * @returns {string}
 */
function window_adress(obj, action) {
    obj.master = (obj.master ? 'principal' : '');
    var janela = '<div class="panel-end" id="end_' + obj.id + '">';
    if (action === 'user') {
        janela += '<h4>' + obj.name + ' <span class="fl-right address-master">' + obj.master + '</span></h4>';
    } else {
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

/**
 * LIMPAR CAMPOS DE IMPUT EXETO TOKEN
 * @param form
 */
function clear_input(form) {
    var _token = form.find('input[name=_token]').val();
    form.find('input').val('');
    form.find('input[name=_token]').val(_token);
}

/**
 * BLOQUEAR E DESBLOQUEAR LOJA
 */
function blockStore() {
    var element = $(this);
    var id = element.data('id');
    var index = {id: id}
    var txt = element.text().trim();
    var msg = (txt == 'bloquear loja' ? 'Tem certesa de que deseja bloquear sua loja?<br> Todos os seus produtos cadastrado serão bloqueados.' : 'Sua loja será desbloqueada e estará visível para todos verem?')
    alertify.confirm(alertfyConfirmTitle, msg,
        function () {
            $.get('', index, function (response) {
                if (response.status) {
                    if (response.lock) {
                        element.html('<i class="fa fa-lock vertical-middle"></i> bloquear loja');
                    } else {
                        element.html('<i class="fa fa-unlock vertical-middle"></i> desbloquear loja');
                    }
                    alertify.success('Produto removido');
                } else {
                    alertify.error(response.msg);
                }
            }, 'json');
        }, function () {
            return true;
        });
}
/**
 * REMOÇÃO DE PRODUTO EM TEMPO REAL
 * @returns {boolean}
 */
function removePrduct() {
    var element = $(this);
    var id = element.data('id');
    var index = {id: id}

    alertify.confirm(alertfyConfirmTitle, 'Tem certeza de que deseja remover este produto?',
        function () {
            $.get('', index, function (response) {
                if (response.status) {
                    element.parents('tr').slideUp(500);
                    alertify.success('Produto removido');
                } else {
                    alertify.error(response.msg);
                }
            }, 'json');
        }, function () {
            return true;
        });
    return false;
}

/**
 * REMOÇÃO DE IMAGEM DE PRODUTO EM TEMPO REAL
 * REMOÇÃO DE IMAGEM DE PRODUTO TEMPORÁRIA
 * @returns {boolean}
 */
function removeImgGarely() {
    var element = $(this);
    var action = element.data('action');
    var textImg = $(this).parents('.product-galery').find('input[type=text]').val();
    if (action == 'create') {
        clearImgGalery(element);
    }
    if(textImg.length > 0){
        alertify.confirm(alertfyConfirmTitle, 'Tem certesa de que deseja remover esta imagem?',
            function () {
                var id = element.data('id');
                var prev = element.data('preview');
                $.get('/accont/salesman/products/remove/image/'+id, function (response) {
                    if (response.status) {
                        clearImgGalery(element);
                        alertify.success('Produto removido!');
                    } else {
                        alertify.error(response.msg);
                    }
                }, 'json');
            }, function () {
                return true;
            });
    }
    return false;
}

/**
 * LIMPAR IMAGEM PROVISÓRIA E INPUT FILE AO REMOVER PRODUTO
 * @param element
 */
function clearImgGalery(element) {
    element.parents('.product-galery').find('.prevImg img').attr('src', '/image/img-exemple.jpg?h=110')
    element.parents('.product-galery').find('.file input[type=text]').val('');
    element.parents('.product-galery').find('.file').prepend('<input data-preview="' + prev + '" onchange="previewFile($(this))" name="image.' + prev + '" type="file">');
    element.parents('.product-galery').find('.file input[type=file]').remove();

}


$(document).on('submit', '.form-modern', function () {
    $(this).find("button[type=submit]").text('processando..').css({background: '#E57373'});
});
$(document).on('click', '.jq-remove-product', removePrduct);
$(document).on('click', '.jq-remove-img-galery', removeImgGarely);
$(document).on('click', '.jq-block-store', blockStore);


/**
 * CONFIGURAÇÃO DE MÁSKARA PARA CAMPOS INPUT DE FORMULÁRIOS
 */
$(function () {
    $(".masked_date").mask("00/00/0000", {placeholder: "mm/dd/yyyy"});
    $(".masked_phone").mask("(00) 0000-0000");
    $(".masked_cellphone").mask("(00) 00000-0000");
    $(".masked_cpf").mask("000.000.000-00");
    $(".masked_cnpj").mask("00.000.000/0000-00");
})

var fullPhone = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    phoneOptions = {
        onKeyPress: function (val, e, field, options) {
            field.mask(fullPhone.apply({}, arguments), options);
        }
    };

$('.masked_fullphone').mask(fullPhone, phoneOptions);