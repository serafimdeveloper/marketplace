<div style="text-align: justify; font-size: 14px; font-family: Arial,Helvetica,Sans-Serif">
    <a href="{{route('homepage')}}" style="color: #336699; line-height: 50px" target="_blank">
        <img alt="Pop Martin" src="{{url('imagem/popmartin/logo-popmartin-msg.png')}}" border="0" />    </a>
    <p style="font-size: 16px; font-weight: bold; color: #800000">Olá {{$user->name}},</p>
    <p>
        Seja bem vindo ao Pop Martin!.<br />
        Para utilizar nossa plataforma é necessário que você confirme seu cadastro.<br />
        Para isso é bem simples basta clicar no botão abaixo e aceitar os nossos termos!<br/>
    </p>
    <a style="padding: 5px 15px; font-weight: bold; background: #800000; color:#fff" class="btn-confirm" href="{{route('auth.confirm',[$user->email, $user->confirm_token])}}" target="_blank">Confirme sua Conta</a>
    <br/>
    <p>
        Atenciosamente,<br />
        Equipe Pop Martin.
    </p>
</div>
