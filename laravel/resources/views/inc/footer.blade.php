<footer class="footer">
    <div class="content">
        <h1 class="font-0">Mais informações sobre PopMartin</h1>
        <div class="nav-footer-cat colbox">
            @for($i = 0; $i < 5; $i++)
                <div class="colbox-5">
                    <ul class="nav-footer">
                        @for($j = 0; $j < 5; $j++)
                            <li><a href="/categoria/">categoria 1</a></li>
                        @endfor
                    </ul>
                </div>
            @endfor
        </div>
        <div class="clear-both"></div>
    </div>
    <div class="content">
        <div class="colbox pop-footer-info" style="padding: 0 10px;">
            <div class="colbox-2">
                <h2 class="c-white">Formas de pagamento</h2>
                <div class="footer-icons">
                    <span class="popicon visa"></span>
                    <span class="popicon mastercard"></span>
                    <span class="popicon hiper"></span>
                    <span class="popicon elo"></span>
                    <span class="popicon cart1"></span>
                    <span class="popicon itau"></span>
                    <span class="popicon bradesco"></span>
                    <span class="popicon banco-do-brasil"></span>
                    <span class="popicon boleto"></span>
                    <span class="popicon moip"></span>
                </div>
            </div>

            <div class="colbox-2">
                <ul class="nav-footer-last">
                    <li><a href="/login">monte sua loja</a></li>
                    <li><a href="/info/como-comprar">como comprar</a></li>
                    <li><a href="/contato">fale conosco</a></li>
                    <li><a href="/info/termos-de-uso">termos de uso</a></li>
                    <li><a href="/info/politicas-de-privacidade">políticas de privacidade</a></li>
                </ul>
            </div>
            <div class="clear-both"></div>
        </div>
        <br>
        <div class="txt-center padding10 c-red">
            &copy; {{date('Y')}} Pop Martin - Todos os direitos reservados
        </div>
    </div>
    <div class="clear-both"></div>
</footer>


