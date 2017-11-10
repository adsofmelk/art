  

  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Configuración</h3>
        <ul class="control-sidebar-menu">
        @can('view_users')
          <li>
            <a href="{{ route('users.index') }}">
              <i class="menu-icon fa fa-user  bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Usuarios</h4>

                <p>Usuarios, permisos, passwords ...</p>
              </div>
            </a>
          </li>
        @endcan
        @can('view_roles')
          <li>
            <a href="{{ route('roles.index') }}">
              <i class="menu-icon fa fa-users  bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Grupos</h4>

                <p>Administrar roles del sistema</p>
              </div>
            </a>
          </li>
        @endcan
        </ul>
        <!-- /.control-sidebar-menu -->
      </div>
      
    </div>
  </aside>
  
    <div class="control-sidebar-bg"></div>
