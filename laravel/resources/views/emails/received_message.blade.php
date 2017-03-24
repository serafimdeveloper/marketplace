<div style="text-align: justify; font-size: 14px; font-family: Arial,Helvetica,Sans-Serif">
    <a href="{{route('/')}}" style="color: #336699; line-height: 50px" target="_blank">
        <img alt="Pop Martin" src="{{url('imagem/popmartin/popmartin.jpg')}}" border="0" />
    </a>
    <p style="font-size: 16px; font-weight: bold; color: #800000">Olá {{$message->recipent->name}},</p>

    <p>
        Você recebeu uma mensagem.
    </p>

    <p><a href="#">Clique aqui para visualizar sua mensagem.</a></p>

    <br />
    <p>
        Atenciosamente,<br />
        Equipe Pop Martin.
    </p>
</div>