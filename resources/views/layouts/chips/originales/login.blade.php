	<div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                    	<h2 class="row">
                    	<div class='col-lg-1'> </div>
                    	<div class='col-lg-3'><i class="fa fa-user-md fa-2x	"></i></div>
                    	<div class='col-lg-8'>{{ config('app.name', '') }}</div>
                    	</h2>
                        <h3 class="panel-title"> </h3>
                    </div>
                    <div class="panel-body">
                        {!!Form::open(['route'=>'log.store','method'=>'POST','role'=>'form'])!!}
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
                                
                                
                                {!!Form::submit('Ingresar',['class'=>'btn btn-lg btn-success btn-block'])!!}
                                {!!Form::close()!!}
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>