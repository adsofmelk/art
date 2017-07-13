
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
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">1</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tienes 1 mensaje</li>
              <li>
                <!-- inner menu: contains the messages -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <!-- User Image -->
                        <img src="adminLTE-2.4/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <!-- Message title and timestamp -->
                      <h4>
                        Mensaje de prueba
                        <small><i class="fa fa-clock-o"></i> 5 min</small>
                      </h4>
                      <!-- The message -->
                      <p>Contenido del mensaje</p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
                <!-- /.menu -->
              </li>
              <li class="footer"><a href="#">Ver bandeja de mensajes</a></li>
            </ul>
          </li>
          <!-- /.messages-menu -->

          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">1</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tiene 1 notificación</li>
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                  <li><!-- start notification -->
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> Proceso disciplinario evaluado
                    </a>
                  </li>
                  <!-- end notification -->
                </ul>
              </li>
              <li class="footer"><a href="#">Ver todos</a></li>
            </ul>
          </li>
          <!-- Tasks Menu -->
          <li class="dropdown tasks-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">1</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tiene 1 tarea pendiente</li>
              <li>
                <!-- Inner menu: contains the tasks -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <!-- Task title and progress text -->
                      <h3>
                        Elaborar informe para junta del viernes
                        <small class="pull-right">40%</small>
                      </h3>
                      <!-- The progress bar -->
                      <div class="progress xs">
                        <!-- Change the css width attribute to simulate progress -->
                        <div class="progress-bar progress-bar-aqua" style="width: 40%" role="progressbar"
                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Completado</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">Ver todas las tareas</a>
              </li>
            </ul>
          </li>
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">Usuario: {{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="adminLTE-2.4/dist/img/avatar5.png" class="img-circle" alt="User Image">

                <p>
                  Usuario: {{ Auth::user()->name }}
                  <small>{{ Auth::user()->roles->pluck('name')->first() }}</small>
                </p>
              </li>
             
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Cambiar Pasword</a>
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