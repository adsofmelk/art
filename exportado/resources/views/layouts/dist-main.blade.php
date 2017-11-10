<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es')}}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ config('app.name', '') }}">
    <meta name="author" content="adsofmelk@gmail.com">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '') }}</title>

    <!-- Bootstrap Core CSS -->
    {!!Html::style('/app/sb-admin/vendor/bootstrap/css/bootstrap.min.css')!!}
    <!-- MetisMenu CSS -->
    {!!Html::style('/app/sb-admin/vendor/metisMenu/metisMenu.min.css')!!}
    <!-- Custom CSS -->
    {!!Html::style('/app/sb-admin/dist/css/sb-admin-2.css')!!}
    <!-- Morris Charts CSS -->
    {!!Html::style('/app/sb-admin/vendor/morrisjs/morris.css')!!}
    <!-- Custom Fonts -->
    {!!Html::style('/app/sb-admin/vendor/font-awesome/css/font-awesome.min.css')!!}
    
    <!-- Jquery UI CSS -->
    {!!Html::style('/js/jquery-ui/jquery-ui.min.css')!!}
    
    <!-- Bootrtrap Switch CSS -->
    {!!Html::style('/css/bootstrap-switch.min.css')!!}
    
    <!-- DataTables CSS -->    
    {!!Html::style('https://cdn.datatables.net/v/dt/dt-1.10.15/r-2.1.1/se-1.2.2/datatables.min.css')!!}
    
	<!-- jQuery -->
	{!!Html::script("/js/jquery-3.1.0.min.js")!!}
	
	<!-- jQuery UI -->
	{!!Html::script("/js/jquery-ui/jquery-ui.min.js")!!}
	
	 <!-- Bootstrap Switch JS -->
	{!!Html::script("/js/bootstrap-switch.min.js")!!}
	
	<!-- DataTables JS -->
	{!!Html::script("https://cdn.datatables.net/v/dt/dt-1.10.15/r-2.1.1/se-1.2.2/datatables.min.js")!!}
    	
		
	<style>
        .result-set { margin-top: 1em }
    </style>
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
    

</head>

	<body>
	
	
		<div id="wrapper" class='container-fluid'><!-- BEGIN WRAPPER BODY -->
			@if(Auth::check())			
				@include('layouts.chips.content')
			@else
				@include('layouts.chips.login')
			@endif
		</div> <!-- END WRAPPER BODY -->
		
	
	
	    <!-- Bootstrap Core JavaScript -->
	    {!!Html::script("/app/sb-admin/vendor/bootstrap/js/bootstrap.min.js")!!}
	
	    <!-- Metis Menu Plugin JavaScript -->
	    {!!Html::script("/app/sb-admin/vendor/metisMenu/metisMenu.min.js")!!}
	    
	    <!-- Morris Charts JavaScript -->
	    @if(isset($graph))
		    {!!Html::script("/app/sb-admin/vendor/raphael/raphael.min.js")!!}
		    {!!Html::script("/app/sb-admin/vendor/morrisjs/morris.min.js")!!}
		    {!!Html::script("/app/sb-admin/data/morris-data.js")!!}
		@endif
		
	    <!-- Custom Theme JavaScript -->
	    {!!Html::script("/app/sb-admin/dist/js/sb-admin-2.js")!!}
	    
	    
	   
		
	
	</body>

</html>