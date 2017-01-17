@include('inc.header')

<section class="pop-forms content">
    <div class="colbox">
        <div class="colbox-2">
            <h2>Já sou usuário do Popmartin</h2>
            <div class="txt-center">
                <a class="modal modal-blueface" href="">
                    <span><i class="fa fa-facebook-f"></i> | conecte-se usando o facebook</span>
                </a>
            </div>
            <form class="form-modern" action="" method="POST">
                <label>
                    <span>e-mail</span>
                    <input type="email" name="email" placeholder="informe seu e-mail">
                    <span class="alert-hidden"></span>
                </label>
                <label>
                    <span>senha</span>
                    <input type="password" name="password" placeholder="informe sua senha">
                    <span class="alert-hidden"></span>
                </label>
                <div class="txt-center">
                    <button class="btn btn-popmartin" type="submit" style="padding: 10px 60px;margin-top: 30px;">Entrar</button>
                    <br><br>
                    <a class="txt-decoration-underline c-gray" href="" style="margin-top: 10px;">esqueci minha senha</a>
                </div>
            </form>
        </div>
        <div class="colbox-2">
            <h2>Quero fazer parte do Popmartin</h2>
            <div class="txt-center">
                <a class="modal modal-blueface" href="">
                    <span><i class="fa fa-facebook-f"></i> | cadastre-se usando o facebook</span>
                </a>
            </div>

            <form class="form-modern" action="" method="POST">
                <label>
                    <span>Nome</span>
                    <input type="text" name="name" placeholder="João">
                    <span class="alert-hidden"></span>
                </label>
                <label>
                    <span>e-mail</span>
                    <input type="email" name="email" placeholder="exemplo@exemplo.com">
                    <span class="alert-hidden"></span>
                </label>
                <label>
                    <span>confirmar e-mail</span>
                    <input type="email" name="email_repeat" placeholder="exemplo@exemplo.com">
                    <span class="alert-hidden"></span>
                </label>
                <label>
                    <span>criar senha</span>
                    <input type="password" name="password">
                    <span class="alert-hidden"></span>
                </label>
                <label>
                    <span>repetir senha</span>
                    <input type="password" name="password">
                    <span class="alert-hidden"></span>
                </label>
                <div style="border: 1px solid #B0BEC5; padding: 10px;">
                    <span>Ao clicar em "Cadastrar", você confirma que aceita o <a href="/termos">Termos de Uso</a> e <a
                                href="/politicas">Politica de Privacidade</a> .</span>
                </div>
                <div class="txt-center" style="padding: 0 30px;margin-top: 20px;">
                    <button class="btn btn-blue" type="submit">Cadastrar</button>
                </div>

            </form>
        </div>
    </div>
    <div class="clear-both"></div>
</section>

@include('inc.footer')