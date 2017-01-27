<span class="panel-icon-mobile">menu <i class="fa fa-chevron-down"></i></span>
<nav class="panel-nav">
     <div class="panel-nav-acsess">
         <h3>Área do cliente</h3>
         <ul>
             <li><a href="/accont">meu cadastro</a></li>
             <li><a href="/accont/requests">meus pedidos</a></li>
             <li><a href="/accont/searchstore">procurar loja</a></li>
             <li><a href="/accont/messages">mensagens <span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">2</span></a></li>
         </ul>
     </div>
    @can('vendedor')
        <div class="panel-nav-acsess">
             <h3>Área do vendedor</h3>
             <ul>
                 <li><a href="/accont/salesman/info">informações</a></li>
                 <li><a href="/accont/salesman/stores">minha loja</a></li>
                 <li><a href="/accont/salesman/products">meus produtos</a></li>
                 <li><a href="/accont/salesman/sales">minhas vendas <span class="fl-right padding05-10 radius bg-reddark" style="margin-top: -5px;">2</span></a></li>
                 <li><a href="/accont/salesman/messages">mensagens <span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">2</span></a></li>
             </ul>
         </div>
    @endcan
    @cannot('vendedor')
        <div class="panel-nav-acsess">
            <h3>Área do vendedor</h3>
            <ul>
                <li><a href="/accont/salesman/create">Torna-se um Vendedor</a></li>
            </ul>
        </div>
    @endcannot
    @can('admin')
         <div class="panel-nav-acsess">
             <h3>Área administrativa</h3>
             <ul>
                 <li><a href="/accont/report/users">Usuários</a></li>
                 <li><a href="/accont/report/salesmans">vendedores</a></li>
                 <li><a href="/accont/report/products">produtos</a></li>
                 <li><a href="/accont/categories">categorias</a></li>
                 <li><a href="/accont/banners">banners</a></li>
                 <li><a href="/accont/report/sales">vendas e comissões</a></li>
                 <li><a href="/accont/report/notifications">notificações <span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">2</span></a></li>
             </ul>
         </div>
    @endcan
 </nav>