@if($type === 'users')
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
@endif

@if($type === 'sallesman')
    <table id="jq-search-table-result" class="table table-action">
        <thead>
        <tr>
            <th>Nome</th>
            <th class="t-medium">Loja</th>
            <th class="t-medium">Local</th>
            <th class="t-small">Produtos</th>
            <th class="t-medium">Moip</th>
            <th class="t-small">Status</th>
            <th class="t-small">Taxa</th>
            <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
        </tr>
        </thead>

        <tbody>
        @for($i = 0;$i < 3; $i++)
            <tr>
                <td>Maria Luíza da Silva</td>
                <td>Da Juca</td>
                <td>Volta Redonda/RJ</td>
                <td>5</td>
                <td>DonaMaria</td>
                <td>ativo</td>
                <td>12,00%</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-user" data-user="{{$i}}">detalhes</a>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
@endif

@if($type === 'products')
    <table id="jq-search-table-result" class="table table-action">
        <thead>
        <tr>
            <th class="t-medium" style="width: 60px;">Imagem</th>
            <th>Nome</th>
            <th class="t-medium">Vendedor</th>
            <th class="t-small">Estoque</th>
            <th class="t-small">Visível</th>
            <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
        </tr>
        </thead>

        <tbody>
        @for ($i = 0; $i < 5; $i++)
            <tr>
                <td><img src="{{ url('image/img-exemple.jpg') }}" alt="[]" title=""></td>
                <td>Produto X</td>
                <td>nome do vendedor<br> <a href="/juca" style="color: #B71C1C">loja</a></td>
                <td class="txt-center">5</td>
                <td class="t-draft txt-center">não</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-product">detalhes</a>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
@endif