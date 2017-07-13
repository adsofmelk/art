		<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<!-- NAVBAR TOP -->
				@include('layouts.chips.navbar-top')
			<!-- END NAVBAR TOP -->
		</nav>	
		
		
		<nav class="sidebar navbar-default" role="navigation" >
			<!-- NAVBAR SIDE -->
				{!! \App\Helpers::getLeftMenu() !!}
			<!-- END NAVBAR SIDE -->
		</nav>
		<!-- End Navigation -->
		
			
		<!-- Page Content -->
        <div id="page-wrapper" >
            
                <div class="row">
                    <div class="col-lg-4">
                    	@include('layouts.chips.errors')
                    	@include('layouts.chips.message')
                    </div>
                </div>
                <!-- /.row -->
            
            <!-- BEGIN CONTENT /.container-fluid -->
            <div  style='padding:12px 5px 20px 5px;  id='content'>
            	@yield('content')
            </div>	
            <!-- END CONTENT /.container-fluid -->
            
        </div>
        <!-- End Page Content /#page-wrapper -->
