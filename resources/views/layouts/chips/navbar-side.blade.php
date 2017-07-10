
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                  		@foreach($menu as $submenu)
                  			<li>
                            <a href=""><i class="{{$submenu['icon']}}"></i> {{$submenu['name']}}</a>
                            <ul class="nav nav-second-level">
                            	<li>
                            	<a href="/factura"><i class="fa fa-caret-square-o-down fa-fw"></i> Disciplinarios</a>
                                	<ul class="nav nav-third-level">
                                		<li>
                                			<a href="/disciplinarios/create"><i class="fa fa-plus fa-fw"></i> Nuevo Proceso</a>
                                		</li>
                                		<li>
                                			<a href="/disciplinarios"><i class="fa fa-list fa-fw"></i> Procesos Activos</a>
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
        