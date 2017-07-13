
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">{{ config('app.name', '') }}</a>
            </div>
            <!-- /.navbar-header -->

           <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (Auth::check())
                            

                            @can('view_posts')
                                <li class="{{ Request::is('posts*') ? 'active' : '' }}">
                                    <a href="{{ route('posts.index') }}">
                                        <span class="text-success glyphicon glyphicon-text-background"></span> Posts
                                    </a>
                                </li>
                            @endcan
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right" style='margin-right:0 !important;'>
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else

                            @can('view_users')
                            <li class="{{ Request::is('users*') ? 'active' : '' }}">
                                <a href="{{ route('users.index') }}">
                                   <span class="text-info glyphicon glyphicon-user"></span> Usuarios
                                </a>
                            </li>
                            @endcan
                            @can('view_roles')
                            <li class="{{ Request::is('roles*') ? 'active' : '' }}">
                                <a href="{{ route('roles.index') }}">
                                    <span class="text-info glyphicon glyphicon-lock"></span> Grupos
                                </a>
                            </li>
                            @endcan

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                    <span class="label label-default">{{ Auth::user()->roles->pluck('name')->first() }}</span>
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="glyphicon glyphicon-log-out"></i> Salir
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            <!-- /.navbar-top-links -->