<div style="text-align: justify; font-size: 14px; font-family: Arial,Helvetica,Sans-Serif">
    <a href="{{route('homepage')}}" style="color: #336699; line-height: 50px" target="_blank">
        <img alt="Pop Martin" src="{{url('imagem/popmartin/logo-popmartin-msg.png')}}" border="0">    </a>
    <p style="font-size: 16px; font-weight: bold; color: #800000">Olá {{$user->name}},</p>
    <p>
        Seja bem vindo ao Pop Martin!.<br>
        Para utilizar nossa plataforma é necessário que você confirme seu cadastro.<br>
    </p>
    <a style="display:inline-block;padding: 5px 15px; margin:10px 0 15px 0;font-weight: bold; background: #800000; color:#fff; text-decoration: none;" class="btn-confirm" href="{{route('auth.confirm',[$user->email, $user->confirm_token])}}" target="_blank">Confirme sua Conta</a>
    <p>
        Atenciosamente...<br>
        Equipe Pop Martin.
    </p>
</div>
