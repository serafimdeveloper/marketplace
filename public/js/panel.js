$(function(){
    /*
     -------------------------------------------------------------
     Menu do painel de controle flutuante de acordo com o scroll
     */

    var objScrollMenu = {
        ePNM: $('.panel-nav > div'),
        SPxSPNMTop: $('.panel-nav > div').offset().top,
        SPxSPNMBottom: $('.panel-nav > div').offset().top + $('.panel-nav > div').outerHeight(),
        SPxSPNBottom: $('.panel-nav').offset().top + $('.panel-nav').outerHeight()
    }

    /**
     * Scroll Window Indentificador
     */
    $(this).bind('scroll', window, function () {
        var SPxWindow = $(window).height() + $(this).scrollTop();
        var maxCurrentVal = objScrollMenu.SPxSPNBottom - objScrollMenu.SPxSPNMBottom;
        var currentScroll = SPxWindow - objScrollMenu.SPxSPNMBottom;
        var reverseCurrentScroll = (objScrollMenu.SPxSPNBottom - objScrollMenu.SPxSPNMBottom) - currentScroll;
        var pxToNavMenu = $(this).scrollTop() - 90;

        if ($(this).scrollTop() > objScrollMenu.SPxSPNMTop) {
            if (SPxWindow > objScrollMenu.SPxSPNMBottom) {
                if (objScrollMenu.ePNM.height() > $(window).height()) {
                    if ((reverseCurrentScroll > 0 && reverseCurrentScroll < maxCurrentVal)) {
                        objScrollMenu.ePNM.addClass('floatmenu').css({bottom: reverseCurrentScroll + 15 + 'px'});
                    }
                } else {
                    console.log(objScrollMenu.SPxSPNMBottom, pxToNavMenu);
                    if (pxToNavMenu > 0 && pxToNavMenu < objScrollMenu.SPxSPNMBottom + 150) {
                        objScrollMenu.ePNM.addClass('floatmenu').css({'margin-top': pxToNavMenu, bottom: 'inherit'});
                    } else {
                        objScrollMenu.ePNM.addClass('floatmenu').css({'margin-top': 'inherit', bottom: 10});
                    }
                }
            } else {
                objScrollMenu.ePNM.removeClass('floatmenu');
            }
        }else{
            objScrollMenu.ePNM.css({top: 'inherit', 'margin-top': 'inherit'}).removeClass('floatmenu');
        }
    });

    /**
     * Procura de loja em tempo real no painel
     */
    $(".jq-input-search").keyup(function () {
        var data = 'name=' + $(this).val();
        getData(1, data);
    });

    $(document).on('click', '.pagination a',function(event){
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var page=$(this).attr('href').split('page=')[1];
        var data = 'name='+ $(".jq-input-search").val();
        getData(page, data);
    });

    $(window).on('hashchange', function() {
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

    function getData(page, data){
        $.ajax({
            url: '/accont/searchstore?page='+page,
            type: "get",
            data: data,
            datatype: "html",
            beforeSend: function(){
                $('#jq-search-table-result tbody').html("<tr><td colspan=\"2\"><i class='fa fa-spin fa-spinner'></i> procurando...</td></tr>");
            }
        }).done(function(data){
            $("#result").empty().html(data);
            location.hash = page;
        }).fail(function(jqXHR, ajaxOptions, thrownError){
            alertify.error(response.responseJSON.msg);
        });
    }
});
/*

 -------------------------------------------------------------

 Menu do painel de controle flutuante de acordo com o scroll

 */



/**

 * Scroll Window Indentificador

 */

var objScrollMenu = dataScrollMenu();

$(this).bind('scroll', window, function () {

    var SPxWindow = $(window).height() + $(this).scrollTop();

    var maxCurrentVal = objScrollMenu.SPxSPNBottom - objScrollMenu.SPxSPNMBottom;

    var currentScroll = SPxWindow - objScrollMenu.SPxSPNMBottom;

    var reverseCurrentScroll = (objScrollMenu.SPxSPNBottom - objScrollMenu.SPxSPNMBottom) - currentScroll;

    var pxToNavMenu = $(this).scrollTop() - 90;



    if ($(this).scrollTop() > objScrollMenu.SPxSPNMTop) {

        if (SPxWindow > objScrollMenu.SPxSPNMBottom) {

            if (objScrollMenu.ePNM.height() > $(window).height()) {

                if ((reverseCurrentScroll > 0 && reverseCurrentScroll < maxCurrentVal)) {

                    objScrollMenu.ePNM.addClass('floatmenu').css({bottom: reverseCurrentScroll + 15 + 'px'});

                }

            } else {

                if (SPxWindow <= objScrollMenu.SPxSPNBottom + 170) {

                    objScrollMenu.ePNM.addClass('floatmenu').css({'margin-top': pxToNavMenu, bottom: 'inherit'});

                } else {

                    objScrollMenu.ePNM.addClass('floatmenu').css({'margin-top': 'inherit', bottom: 10});

                }

            }

        } else {

            objScrollMenu.ePNM.removeClass('floatmenu');

        }

    } else {

        objScrollMenu.ePNM.css({top: 'inherit', 'margin-top': 'inherit'}).removeClass('floatmenu');

    }

});

function dataScrollMenu() {

    this.ePNM = $('.panel-nav > div');

    this.SPxSPNMTop = $('.panel-nav > div').offset().top;

    this.SPxSPNMBottom = $('.panel-nav > div').offset().top + $('.panel-nav > div').outerHeight();

    this.SPxSPNBottom = $('.panel-nav').offset().top + $('.panel-nav').outerHeight();

}



/**

 * Procura de loja em tempo real no painel

 */

$(".jq-input-search").keyup(function () {

    var data = 'name=' + $(this).val();

    getData(1, data);

});



$(document).on('click', '.pagination a',function(event){

    $('li').removeClass('active');

    $(this).parent('li').addClass('active');

    event.preventDefault();

    var page=$(this).attr('href').split('page=')[1];

    var data = 'name='+ $(".jq-input-search").val();

    getData(page, data);

});



$(window).on('hashchange', function() {

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



function getData(page, data){

    $.ajax({

        url: '/accont/searchstore?page='+page,

        type: "get",

        data: data,

        datatype: "html",

        beforeSend: function(){

            $('#jq-search-table-result tbody').html("<tr><td colspan=\"2\"><i class='fa fa-spin fa-spinner'></i> procurando...</td></tr>");

        }

    }).done(function(data){

        $("#result").empty().html(data);

        location.hash = page;

    }).fail(function(jqXHR, ajaxOptions, thrownError){

        alertify.error(response.responseJSON.msg);

    });

}
