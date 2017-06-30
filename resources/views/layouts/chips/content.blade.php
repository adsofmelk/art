		<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<!-- NAVBAR TOP -->
				@include('layouts.chips.navbar-top')
			<!-- END NAVBAR TOP -->
			
			<!-- NAVBAR SIDE -->
				{!! \App\Helpers::getLeftMenu() !!}
			<!-- END NAVBAR SIDE -->
		</nav>
		<!-- End Navigation -->
		
			
		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                    	@include('layouts.chips.errors')
                    	@include('layouts.chips.message')
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- BEGIN CONTENT /.container-fluid -->
            	@yield('content')
            <!-- END CONTENT /.container-fluid -->
        </div>
        <!-- End Page Content /#page-wrapper -->
