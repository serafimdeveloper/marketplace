$(function(){

    /*
     -------------------------------------------------------------
     Menu do painel de controle flutuante de acordo com o scroll
     */
    /** definição de variáveis*/
    var boundaries =
        {top: 0, bottom: 0, position: 'absolute'},
        menuContainer = $('.panel-nav'),
        menu = $('.panel-nav > div'),
        wnd = $(window);

    wnd.on('scroll', function(){
        if(menuContainer.height() > wnd.height()){
            menu.css({position: boundaries.position});
            var offset = menuContainer.offset();
            boundaries.top = offset.top;
            boundaries.bottom = offset.top + menuContainer.height() - menu.height();


            var st = boundaries.top;
            st = wnd.scrollTop() > st ? wnd.scrollTop() - 40 : st;
            st = st > boundaries.bottom ? st = boundaries.bottom : st;

            menu.css({top: st});
        }

    }).triggerHandler('scroll');

    /**
     * Procura de loja em tempo real no painel
     */
    $(".jq-input-search").keyup(function () {
        var data = 'name=' + $(this).val();
        getData(1, data);
    });
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