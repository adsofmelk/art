
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                  		@foreach($menu as $submenu)
                  			<li>
                            <a href=""><i class="{{$submenu['icon']}}"></i> {{$submenu['name']}}</a>
                            <ul class="nav nav-second-level">
                            	<li>
                            	<a href="/factura"><i class="fa fa-caret-square-o-down fa-fw"></i> Facturación</a>
                                	<ul class="nav nav-third-level">
                                		<li>
                                			<a href="/factura/create"><i class="fa fa-plus fa-fw"></i> Nueva Factura</a>
                                		</li>
                                		<li>
                                			<a href="/factura"><i class="fa fa-list fa-fw"></i> Listado Facturas</a>
                                		</li>
                                		<li>
                                			<a href="/factura"><i class="fa fa-search fa-fw"></i> Buscar Facturas</a>
                                		</li>
                                	</ul>
                                
                                </li>
                                <li>
                            	<a href="/factura"><i class="fa fa-caret-square-o-down fa-fw"></i> Cartera</a>
                                	<ul class="nav nav-third-level">
                                		<li>
                                			<a href="/factura/create"><i class="fa fa-plus fa-fw"></i> Nueva Factura</a>
                                		</li>
                                		<li>
                                			<a href="/factura"><i class="fa fa-list fa-fw"></i> Listado Facturas</a>
                                		</li>
                                		<li>
                                			<a href="/factura"><i class="fa fa-search fa-fw"></i> Buscar Facturas</a>
                                		</li>
                                	</ul>
                                
                                </li>
                            </ul>
                        </li>
                  		@endforeach      
                  
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        