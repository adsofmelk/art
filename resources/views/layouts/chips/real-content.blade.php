  <div class="content-wrapper">
  
    
	<!--  Menu module  -->
	<section class="content-header">
		<div class="btn-group">
		@yield('modmenu')
		</div>
	</section>
	<!--  /. Menu module  -->
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('title')
        <small>@yield('desc')</small>
      </h1>
    </section>
	<!-- /. Content Header (Page header) -->
		
    <!-- Main content -->
    <section class="content container-fluid">
		
		
     @yield('content')

    </section>
    <!-- /.content -->
  </div>