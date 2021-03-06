
	<div class="row" style="min-height: 100%; min-height: 100vh; display: flex; align-items: center;">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                    	<h2 class="row">
                    	<div class='col-lg-1'> </div>
                    	<div class='col-lg-3'><i class="fa fa-cubes fa-2x"></i></div>
                    	<div class='col-lg-8'>Mr Chispa II</div>
                    	</h2>
                        <h3 class="panel-title"> </h3>
                    </div>
                    <div class="panel-body">
                        {!!Form::open(['route'=>'login','method'=>'POST','role'=>'form'])!!}
                            <fieldset>
                                <div class="form-group">
                                    {!!Form::email('email',null,['class'=>'form-control','placeholder'=>'Username','autofocus'=>'true'])!!}
                                </div>
                                <div class="form-group">
                                    {!!Form::password('password',['class'=>'form-control','placeholder'=>'Password'])!!}
                                </div>
                                <div class="form-group">
                                    @include('layouts.chips.errors')
                    				@include('layouts.chips.message')
                                </div>	
                                
                                <div class='col-sm-6'>
                                	{!!Form::submit('Ingresar',['class'=>'btn btn-lg btn-danger btn-block'])!!}
                                	{!!Form::close()!!}
                                </div>
                                
                                <div class='col-sm-6'>
                                	<a href="{{ route('social.oauth', 'google') }}" 
                                		class="btn btn-lg waves-effect waves-light btn-block google">Google+</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
