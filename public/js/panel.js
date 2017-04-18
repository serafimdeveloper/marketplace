$(function(){
    /** Definição de variáveis globais dentro deste escopo*/
    var boundaries = {top: 0, bottom: 0, position: 'relative', marginTop: '-50px'};
    var menuContainer = $('.panel-nav');
    var menu = $('.panel-nav > div');
    var wnd = $(window);

    /** Flutuar menu do painel de controle ao rolar scroll e ajeitar de acordo! */
    wnd.on('scroll', function(){
        if(menuContainer.height() > wnd.height()){
            menu.css({position: boundaries.position});
            var offset = menuContainer.offset();
            boundaries.top = offset.top;
            boundaries.bottom = offset.top + menuContainer.height() - menu.height();
            var st = boundaries.top;
            st = wnd.scrollTop() > st ? wnd.scrollTop() - 40 : st;
            st = st > boundaries.bottom ? st = boundaries.bottom : st;
            menu.css({top: st, 'margin-top': boundaries.marginTop});
        }
    }).triggerHandler('scroll');

    /** Flutuar informação de mensagem relacionada na página de mensagens */
    wnd.scroll(function () {
        var scroll = $(this).scrollTop();
        if (scroll > 85) {
            $('.jq-scrollposition').addClass('pop-notice-msg-fixed');
        } else {
            $('.jq-scrollposition').removeClass('pop-notice-msg-fixed');
        }
    });

    tinymce.init({
        selector: '.textarea_tiny',
        toolbar: "bold italic underline",
        menu : {},
        plugins: "link",
        link_list: [{title: 'Popmartin', value: 'https://popmartin.com.br'}],
        target_list: [{title: 'Mesma Página', value: '_self'},{title: 'Nova Aba', value: '_blank'}]
    });

    $('.jq-check-aval').find('input').each(function (e) {
        $(this).on('click', function(){
            if($(this).val() == 'devolvido'){
                $('.jq-aval-devolvido').show();
            }else{
                $('.jq-aval-devolvido').hide();
            }
        })
    })

    /** orderdar tabelas */
    $(".orderTable").on('change', function(){
        $(this).submit();
    });

    /** Menu mobile do painel de controle */
    $('.panel-nav').height($(document).height() - $('.footer').height() - $('.pop-top-header').height());
    $('.panel-icon-mobile').click(function () {
        if ($('.panel-nav').is(':visible')) {
            $(this).find('i').attr('class', 'fa fa-chevron-down');
        } else {
            $(this).find('i').attr('class', 'fa fa-chevron-up');
        }
        $('.panel-nav').slideToggle();
    });

    /** Procura de loja em tempo real no painel */
    $(".jq-input-search").bind('keyup change', function () {
        var data = $('.form-search').serialize();
        getData(1, data);
    });

    /** Hash para integração de paginação na procura de lojas*/
    wnd.on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            var data = 'name='+ $(".jq-input-search").val();
            if (page == Number.NaN || page <= 0) {
                return false;
            }else{
                getData(page, data);
            }
        }
    });

    /** Modelo de container aprecer conforme clique menu CPF ou CNPJ accont do painel */
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
        if (category !== "") {
            $.ajax({
                url: '/accont/categories/subcategories/' + category,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $("." + loader).show();
                },
                error: function (response) {
                    alertify.error(response.responseJSON);
                },
                success: function (response) {
                    var subcatResponse = response.subcategories;
                    if (Object.keys(subcatResponse).length > 0) {
                        $('.subcat_info').html('<option selected >Selecione uma Subcategoria</option>');
                        $.each(response.subcategories, function (i) {
                            $('.subcat_info').append('<option value="' + response.subcategories[i].id  + '">' + response.subcategories[i].name + '</option>');
                        });
                    } else {
                        $('.subcat_info').html('<option selected disabled>Nenhuma Subcategória</option>');
                    }
                    $("." + loader).hide();
                }
            });
        } else {
            $('.subcat_info').html('<option selected disabled>Nenhuma Subcategória</option>');
        }
    });

    /** Verificar ao clicar em selecionar mensagem se o botão de remover aparece ou não */
    $(".select_msg").click(function () {
        var array = checkInputsMsg($(this).attr('class'));
        if (array.length !== 0) {
            $("#pop-remove-msg").removeClass('btn-gray cursor-nodrop').addClass('btn-popmartin');
        } else {
            $("#pop-remove-msg").removeClass('btn-popmartin').addClass('btn-gray cursor-nodrop');
        }
    });

    /** Operação de controle de estoque de produto */
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
                    $('.' + loader).hide();
                    alertify.error(response.responseJSON.msg);
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

    /** Apagar mensagens selecionadas em tempo real */
    $(document).on('click', "#pop-remove-msg.btn-popmartin", function () {
        var token = $(this).data('token');
        alertify.confirm(alertfyConfirmTitle, 'Tem certeza de que deseja remover?',
            function () {
                var indexes = arrayToObject(checkInputsMsg('select_msg'));
                var dados = {'ids': indexes, '_token': token};
                $.post('/accont/messages/destroy', dados, function (response) {
                    if (response.status) {
                        $.each(indexes, function (key, value) {
                            $('.select_msg').eq(key).parents('tr').hide(800);
                        });
                    } else {
                        alertify.error(response.msg);
                    }
                }, 'json').fail(function (response) {
                    alertify.error(response.responseJSON.msg);
                });
            }, function () {
                return true;
            });
        return false;
    });

    /** Busca o cep na API do correio */
    $('#zip_code').focusout(function () {
        var element = $(this);
        var cep = element.val();
        if ((/^\d{5}-?\d{3}$/).test(cep)) {
            $.ajax({
                url: '/accont/adresses/zip_code/' + cep,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    element.parents('form').find('.loader-address').show();
                },
                error: function (response) {
                    alertify.error(response.responseJSON.msg);
                },
                success: function (data) {
                    data = data[0];
                    var dados = {
                        'state': data.uf,
                        'city': data.cidade,
                        'neighborhood': data.bairro,
                        'public_place': data.logradouro
                    };
                    element.parents('form').find('.loader-address').hide();
                    inputValue(element.parents('form'), dados);
                }
            })
        } else {
            inputError(false, $(this), 'Cep inválido');
        }
    });

    /** Grava ou atualiza o novo endereço*/
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
                        inputError(false, form.find('input[name=' + index + ']'), element[0]);
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
                                $('#group-pnl-end').prepend(windowAdress(data.adress, data.action));
                            } else {
                                $('#group-pnl-end').append(windowAdress(data.adress, data.action));
                            }
                        });
                    }
                    location.reload();
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
                        inputError(false, form.find('input[name=' + index + ']'), element[0]);
                    });
                },
                success: function (data) {
                    form.find('button').html('atualizado com sucesso!');
                    form.parents('.address').slideUp(function () {
                        if (data.adress.master == 1) {
                            $('.panel-end h4 .address-master').text(" ");
                        }
                        $('#end_' + data.adress.id).replaceWith(windowAdress(data.adress, data.action));
                    });
                    clearInput(form);
                    location.reload();
                }
            });
        }
        return false;
    });

    /**
     * Abre modal com formulário de preenchimento de endereço
     * Requisita endereço via ajax caso seja uma edição
     * Caso seja um cadastro, apnenas abre para preenchimento
     */
    $(document).on('click', '.jq-address', function () {
        var form = $('#form-adress');
        $(".alertbox .alertbox-container").css({top: $(document).scrollTop()});
        var action = $(this).data('action')
        if (action == 'store') {
            form.find("label span").first().text('Loja');
            form.find("label input").first().val('Endereço').attr('readonly', true);
        }
        if (typeof ($(this).data('id')) !== "undefined") {
            $('.alertbox-title').text('Editar endereço');
            $('.address_remove').html('<span class="btn btn-small btn-red jq-remove-address" data-id="' + $(this).data('id') + '"><i class="fa fa-trash"></i> remover endereço</span>');
            $('.address').find('button').text('atualizar');
            $.ajax({
                url: '/accont/adresses/' + action + '/' + $(this).data('id'),
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    form.find('.loader-address').show();
                },
                error: function (response) {
                    form.find('.loader-address').hide();
                    alertify.error(response.responseJSON.msg);
                },
                success: function (response) {
                    form.find('.loader-address').hide();
                    inputValue(form, response);
                }
            });
        } else {
            $('.alertbox-title').text('Cadastrar endereço');
            $('.address').find('button').text('cadastrar');
        }
        $('.address').find('form').attr('data-action', action);
        $('.address').show();
    });

    /** Remover endereço do usuário */
    $(document).on('click', '.jq-remove-address', function () {
        var element = $(this);
        alertify.confirm(alertfyConfirmTitle, 'Tem certeza de que deseja remover este endereço?',
            function () {
                var id = element.data('id');
                $.get('/accont/adresses/destroy/' + id, function (response) {
                    if (response.status) {
                        alertify.success('Endereço removido!');
                        $('#end_'+id).remove();
                    } else {
                        alertify.error(response.msg);
                    }
                }, 'json');
                $('.alertbox-close').click();
            }, function () {
                return true;
            });
        return false;
    });

    /** Captar cep e implementar na modal de endereço */
    $(document).on('click', '.pop-select-cep tr', function () {
        var cep = $(this).data('cep');
        $('#zip_code').val(cep).focusout();
        $(this).parents('.alertbox').find('.alertbox-close').click();
    });

    /** Cheamar modal de busca de cep (não sei meu endereço!)*/
    $(document).on('click', '.jq-whichcep', function () {
        $('.whichcep').show();
    });

    /** Formulário de rastreio de cep */
    $(document).on('submit', '.whichcep form', function () {
        var element = $(this);
        var data = element.find('input').val();
        var implementTr = $('.pop-select-cep');
        $.ajax({
            url: '/accont/adresses/zip_code/' + cleanAccents(data),
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                implementTr.html('<tr><td colspan="2"><i class="fa fa-spin fa-spinner"></i></td></tr>');
            },
            error: function (response) {
                implementTr.html('');
                alertify.error(response.responseJSON.msg);
            },
            success: function (response) {
                element.find('button').text('buscar').css({background: '#B71C1C'});
                implementTr.html('');
                $.each(response, function (i, element) {
                    implementTr.append('<tr data-cep="' + element.cep + '"><td>' + element.cep + '</td><td>' + element.logradouro + ' | <b>' + element.bairro + ' - ' + element.cidade + '</b> - ' + element.uf + '</td></tr>');
                });
            }
        });
        return false;
    });


    /** Modal de informações das notificações */
    $(document).on('click', '.jq-notification', function () {
        var e = $(this);
        loaderAjaxScreen(true, 'carregando..');
        $.get('/accont/report/notification/' + e.data('id'), function(response){
            loaderAjaxScreen(false, '');
            $("#notificationParties").html(response);
            e.parents('tr').removeClass('t-unread');
            var notify = $('.notify-admin');
            var v = (parseInt(notify.text()) > 0 ? parseInt(notify.text()) - 1 : 0);
            notify.text(v);
            $(document).ready(function () {
                toggleAlertbox(e);
            })
        });

    });

    $(document).on('submit', '.form-notfy', function(){
        var e = $(this);
        var s = e.serialize();
        console.log(s);
        $.ajax({
            url: '/accont/report/notification/edit',
            type: 'POST',
            data: s,
            dataType: 'json',
            beforeSend: function () {},
            error: function (response) {
                alertify.error(response.responseJSON.msg);
                e.find("button[type=submit]").text('editar mensagem').css({background: '#B40004'});
            },
            success: function (response) {
                alertify.success(response.msg);
                e.find("button[type=submit]").text('editar mensagem').css({background: '#B40004'});
            }
        });
        return false;
    });

    $(document).on('click', '.adm-remove-message', function(){
        var e = $(this);
        alertify.confirm(alertfyConfirmTitle, 'Tem certeza de que deseja remover a mensagem deste usuário?',
            function () {
                var data = {'_token': e.data('token'), 'id': e.data('id')};
                $.post('/accont/report/notification/remove_message', data, function(){
                    $("#jq-info-product").slideUp();
                    $("#notificationParties").html('');
                    $("#ntf" + data.id).slideUp();
                });
            }, function () {
                return true;
            });
        return false;
    });


    /** Modal de informações de gerais */
    $(document).on('click', '.jq-info', function () {
        var e = $(this);
        var id = (e.data('id') !== "") ?  e.data('id') : 'create';
        var type = e.data('type');
        loaderAjaxScreen(true, 'carregando..');
        $.get('/accont/report/'+type+'/'+id, function (response) {
            loaderAjaxScreen(false, '');
            $('#resp_modal').empty().html(response);
            toggleAlertbox(e);
        },'html');
    });

    /**
     * Remoção de usuário por parte do administrador
     */
    $(document).on('click', '.jq-remove-user', function(){
        var e = $(this);
        var data =  {'_token': e.data('token'), 'id': e.data('id')};
        alertify.confirm(alertfyConfirmTitle, 'Tem certeza de que deseja remover esse usuário?',
            function () {
                var data = {'_token': e.data('token'), 'id': e.data('id')};
                $.post('/accont/report/users/' + data.id + '/delete', data, function(){
                    e.parents('#resp_modal').empty();
                    $('.trUser' + data.id).slideUp().remove();
                    alertify.success("Usuário removido com sucesso!");
                }).error(function (response) {
                    alertify.error(response.responseJSON.msg);
                });
            }, function () {
                return true;
            });
    })

    /** Desbloquer e bloquear vendedor */
    $(document).on('click','.btn-unlock-salesman', function(){
        var salesman = $(this).data('id');
        var element = $(this);
        var txt = element.text().trim();
        var msg = (txt == 'bloquear vendedor' ? 'Tem certeza de que deseja bloquear o vendedor e toda sua loja?<br> Todos os produtos cadastrado serão bloqueados.' : 'O vendedor será desbloqueado e seus produtos e sua loja estará visível para todos verem!')
        alertify.confirm(alertfyConfirmTitle, msg,
            function () {
                $.get('/accont/report/salesmans/'+salesman+'/change', function(response){
                    if(response.status){
                        element.html('<i class="fa fa-unlock vertical-middle"></i> bloquear vendedor');
                        msg_alert = 'Vendedor Desbloqueado';
                    }else{
                        element.html('<i class="fa fa-lock vertical-middle"></i> desbloquear vendedor');
                        msg_alert = 'Vendedor Bloqueada';
                    }
                    alertify.success(msg_alert);
                },'json').fail(function(response){
                    alertify.error(response.responseJSON.msg);
                });
            },function(){});
        return false;
    });

    /** Chamada de função para remoção de produtos */
    $(document).on('click', '.jq-remove-product', removePrduct);

    /** Chamada de função para remoção de galerias relaciona a produtos */
    $(document).on('click', '.jq-remove-img-galery', removeImgGarely);

    /** Chamada de função para bloquear ou desbloqueer loja */
    $(document).on('click', '.jq-block-store', blockStore);

    /** Modal de atualização e cadastro de banners */
    $(document).on('submit', '.form-banner', function () {
        var e = $(this);
        $.post(e.attr('action'), e.serialize(), function (response) {
            alertfy.succes(response.msg);
        },'json').fail(function (response) {
            alertify.error(response.responseJSON.msg);
        });
        $("#jq-new-banner").slideDown();
    });

    /** Abri modal de categoria */
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
                inputValue(form, dados);
            }
            $.each(response.categories, function (i, obj) {
                var selected = '';
                if (response.category) {
                    selected = (response.category.category_id === i) ? ' selected="selected"' : '';
                }
                select.append('<option value="' + i + '"' + selected + '>' + obj + '</option>');
            });
        }).fail(function (response) {
            alertify.error(response.responseJSON.msg);
        });
        $("#jq-new-category").slideDown();
    });

    /** Cadastrar e atualizar categorias no sistema */
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
                error: function (response, status) {
                    form.find('button').html(buttonText);
                    alertify.error(response.responseJSON.msg);
                },
                success: function (response) {
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
                error: function (response) {
                    alertify.error(response.responseJSON.msg);
                },
                success: function (response) {
                    form.find('button').html(buttonText);
                }
            });
        }
        clearInput(form);
        return false;
    });
});

/***************************************************************
 ********** DECLARAÇÃO DE FUNÇÕES *****************************
 ***************************************************************/

/**
 * Buscar lojas e tempo real e exibilas de aordo
 * @param page
 * @param data
 */
function getData(page, data){
    var url_cr = window.location.href;
    var url = url_cr.split('#',1);
    $.ajax({
        url: url[0]+'?page='+page,
        type: "get",
        data: data,
        datatype: "html",
        beforeSend: function(){
            $('#jq-search-table-result tbody').html("<tr><td><i class='fa fa-spin fa-spinner'></i> procurando...</td></tr>");
        },
        error: function(response){
            alertify.error(response.responseJSON.msg);
        },
        success: function(response){
            $("#result").empty().html(response);
            location.hash = page;
        }
    });
}

/**
 * Bloquear e desbloquear loja
 */
function blockStore() {
    var element = $(this);
    var txt = element.text().trim();
    var msg = (txt == 'bloquear loja' ? 'Tem certeza de que deseja bloquear sua loja?<br> Todos os seus produtos cadastrado serão bloqueados.' : 'Sua loja será desbloqueada e estará visível para todos verem!')
    alertify.confirm(alertfyConfirmTitle, msg,
        function () {
            var msg_alert;
            $.get('/accont/salesman/stores/block', function (response) {
                if (response.status) {
                    if (response.lock) {
                        element.html('<i class="fa fa-unlock vertical-middle"></i> bloquear loja');
                        msg_alert = 'Loja Desbloqueada';
                    } else {
                        element.html('<i class="fa fa-lock vertical-middle"></i> desbloquear loja');
                        msg_alert = 'Loja Bloqueada';
                    }
                    alertify.success(msg_alert);
                } else {
                    alertify.error(response.msg);
                }
            }, 'json').fail(function (response) {
                alertify.error(response.responseJSON.msg);
            });
        }, function () {
            return true;
        });
}

/**
 * Remoção de imagens de produtos em tempo real
 * Remoçao de imagens de produtos temporário
 * @returns {boolean}
 */
function removeImgGarely() {
    var element = $(this);
    var action = element.data('action');
    var textImg = $(this).parents('.product-galery').find('input[type=text]').val();
    if (action == 'create') {
        clearImgGalery(element);
    }
    if (textImg.length > 0) {
        alertify.confirm(alertfyConfirmTitle, 'Tem certeza de que deseja remover esta imagem?',
            function () {
                var id = element.data('id');
                var prev = element.data('preview');
                $.get('/accont/salesman/products/remove/image/' + id, function (response) {
                    if (response.status) {
                        clearImgGalery(element);
                        alertify.success('Produto removido!');
                    } else {
                        alertify.error(response.msg);
                    }
                }, 'json').fail(function (response) {
                    alertify.error(response.responseJSON.msg);
                });
            }, function () {
                return true;
            });
    }
    return false;
}

/**
 * Remoção de produtos em tempo real
 * @returns {boolean}
 */
function removePrduct() {
    var element = $(this);
    var id = element.data('id');
    alertify.confirm(alertfyConfirmTitle, 'Tem certeza de que deseja remover este produto?',
        function () {
            $.ajax({
                url: '/accont/salesman/products/' + id,
                method: 'DELETE',
                type: 'json',
                success: function (response) {
                    if (response.status) {
                        element.parents('tr').slideUp(500);
                        alertify.success('Produto removido');
                    } else {
                        alertify.error(response.msg);
                    }
                },
                error: function (response) {
                    if (response.status === 406) {
                        alertify.confirm(alertfyConfirmTitle, 'Voce tem pendências, você não pode remover este produto, no máximo pode desativar deseja fazer isso agora?  ',
                            function () {
                                $.get('accont/salesman/products/change/' + id, function (response) {
                                    if (response.status) {
                                        element.parents('tr').slideUp(500);
                                        alertify.success('Produto removido');
                                    }
                                }, 'json').fail(function (response) {
                                    alertify.error(response.responseJSON.msg);
                                });
                            }, function () {
                                return true;
                            });
                    } else {
                        alertify.error(response.responseJSON.msg);
                    }
                }
            });
        }, function () {
            return true;
        });
    return false;
}

/**
 * Limpar imagem proviória e  limpar input file ao remover produto
 * @param element
 * @return void
 */
function clearImgGalery(element) {
    element.parents('.product-galery').find('.prevImg img').attr('src', '/image/img-exemple.jpg?h=110')
    element.parents('.product-galery').find('.file input[type=text]').val('');
    element.parents('.product-galery').find('.file').prepend('<input data-preview="' + prev + '" onchange="previewFile($(this))" name="image.' + prev + '" type="file">');
    element.parents('.product-galery').find('.file input[type=file]').remove();
}

/**
 * Atualizar e apresentar container de endereço no painel no lugar paropriado
 * @param obj
 * @param action
 * @returns {string}
 */
function windowAdress(obj, action) {
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


// $(document).on('submit', '.form-create-product', function(){
//    if(getCharsTinymec('textarea_tiny').chars < 10){
//        alertify.error('Detalhes do prosuto ultrapassou o limite de caracteres');
//        return false;
//    }
//     document.forms[0].submit();
// });
// function getCharsTinymec(id) {
//     var body = tinymce.get(id).getBody(), text = tinymce.trim(body.innerText || body.textContent);
//     return {
//         chars: text.length,
//         words: text.split(/[\w\u2019\'-]+/).length
//     };
// }