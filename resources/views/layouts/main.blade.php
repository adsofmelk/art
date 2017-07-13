<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es')}}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', '') }}</title>
  
  <script> window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};</script>
  
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  {!!Html::style('/adminLTE-2.4/bower_components/bootstrap/dist/css/bootstrap.min.css')!!}
  
  <!-- Font Awesome -->
  {!!Html::style('/adminLTE-2.4/bower_components/font-awesome/css/font-awesome.min.css')!!}
  <!-- Ionicons -->
  {!!Html::style('/adminLTE-2.4/bower_components/Ionicons/css/ionicons.min.css')!!}
  
  <!-- Theme style -->
  {!!Html::style('/adminLTE-2.4/dist/css/AdminLTE.min.css')!!}
  

  
  <!-- AdminLTE Skins -->
        
  {!!Html::style('/adminLTE-2.4/dist/css/skins/skin-red.min.css')!!}
  

    <!-- Jquery UI CSS -->
    {!!Html::style('/js/jquery-ui/jquery-ui.min.css')!!}
    
    <!-- Bootrtrap Switch CSS -->
    {!!Html::style('/css/bootstrap-switch.min.css')!!}
  
  <!-- Custom style -->
  
  {!!Html::style('/css/custom.css')!!}
  
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  {!!Html::style('/css/fonts.googleapis.com.css')!!}
        
  
<!-- jQuery 3 -->

{!!Html::script("/js/jquery-3.1.0.min.js")!!}

<!-- jQuery UI -->
{!!Html::script("/js/jquery-ui/jquery-ui.min.js")!!}


<!-- Bootstrap Switch JS -->
{!!Html::script("/js/bootstrap-switch.min.js")!!}
	

<!-- DataTables JS -->
	{!!Html::style('/css/datatables.min.css')!!}
	{!!Html::script("/js/datatables.min.js")!!}
  
</head>

<body class="hold-transition skin-red sidebar-mini">
	
	<div class="wrapper">
	
			@if(Auth::check())			
				@include('layouts.chips.content')
			@else
				@include('layouts.chips.login')
			@endif
	</div
	><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- Bootstrap 3.3.7 -->
{!!Html::script("/adminLTE-2.4/bower_components/bootstrap/dist/js/bootstrap.min.js")!!}

<!-- AdminLTE App -->
{!!Html::script("/adminLTE-2.4/dist/js/adminlte.min.js")!!}

     @yield('scripts')

     
     
</body>
</html>