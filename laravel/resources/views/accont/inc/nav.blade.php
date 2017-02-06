<span class="panel-icon-mobile">menu <i class="fa fa-chevron-down"></i></span>
<nav class="panel-nav">
     <div class="panel-nav-acsess">
         <h3>Área do cliente</h3>
         <ul>
             <li><a href="{{route('accont.home')}}">meu cadastro</a></li>
             <li><a href="{{route('accont.requests')}}">meus pedidos</a></li>
             <li><a href="{{route('accont.searchstore')}}">procurar loja</a></li>
             <li><a href="{{route('accont.messages')}}">mensagens <span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">2</span></a></li>
         </ul>
     </div>
    @can('vendedor')
        <div class="panel-nav-acsess">
             <h3>Área do vendedor</h3>
             <ul>
                 <li><a href="{{route('accont.salesman.info')}}">informações</a></li>
                 <li><a href="{{route('accont.salesman.stores')}}">minha loja</a></li>
                 <li><a href="{{route('accont.salesman.products')}}">meus produtos</a></li>
                 <li><a href="{{route('accont.salesman.sales')}}">minhas vendas <span class="fl-right padding05-10 radius bg-reddark" style="margin-top: -5px;">2</span></a></li>
                 <li><a href="{{route('accont.salesman.messages')}}">mensagens <span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">2</span></a></li>
             </ul>
         </div>
    @endcan
    @cannot('vendedor')
        <div class="panel-nav-acsess">
            <h3>Área do vendedor</h3>
            <ul>
                <li><a href="{{route('accont.salesman.info')}}">Torna-se um Vendedor</a></li>
            </ul>
        </div>
    @endcannot
    @can('admin')
         <div class="panel-nav-acsess">
             <h3>Área administrativa</h3>
             <ul>
                 <li><a href="{{route('accont.report.users')}}">Usuários</a></li>
                 <li><a href="{{route('accont.report.salesman')}}">vendedores <span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">2</span></a></a></li>
                 <li><a href="{{route('accont.report.products')}}">produtos</a></li>
                 <li><a href="{{route('account.categories')}}">categorias</a></li>
                 <li><a href="/accont/banners">banners</a></li>
                 <li><a href="{{route('accont.report.sales')}}">vendas e comissões</a></li>
                 <li><a href="{{route('accont.report.notifications')}}">notificações <span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">2</span></a></li>
                 <li><a href="{{route('accont.pages')}}">páginas</a></li>
             </ul>
         </div>
    @endcan
 </nav>