
  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>MC</b>&nbsp;II</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Mr Chispa</b>&nbsp;II</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{ \App\Helpers::getUsuario()['nombres'] }} {{ \App\Helpers::getUsuario()['apellidos'] }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="{{ \App\Helpers::getUsuario()['avatar'] }}" class="img-circle" alt="User Image">

                <p>
                  {{ \App\Helpers::getUsuario()['nombres'] }} {{ \App\Helpers::getUsuario()['apellidos'] }}
                  <small>{{ Auth::user()->roles->pluck('name')->first() }}</small>
                </p>
              </li>
             
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  
                </div>
                <div class="pull-right">
                  
                  <a href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();" 
                     class="btn btn-default btn-flat" > 
                      Salir
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
          @role('Admin')
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
          @endrole
        </ul>
      </div>
    </nav>
  </header>