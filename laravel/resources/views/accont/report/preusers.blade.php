<table id="jq-search-table-result" class="table table-action">
    <thead>
    <tr>
        <th>Nome</th>
        <th class="t-medium">E-mail</th>
        <th class="t-medium">Último acesso</th>
        <th class="t-small">Pedidos</th>
        <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
    </tr>
    </thead>

    <tbody>
    @for($i = 0;$i < 3; $i++)
        <tr>
            <td>Maria Luíza da Silva</td>
            <td>marialuiza@hotmail.com</td>
            <td>ontem às 18:65:25</td>
            <td>0</td>
            <td class="txt-center">
                <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-user" data-user="{{$i}}">detalhes</a>
            </td>
        </tr>
    @endfor
    </tbody>
</table>