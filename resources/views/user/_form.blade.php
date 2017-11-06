<!-- First Name Form Input -->
<div class="col-lg-6 form-group @if ($errors->has('nombres')) has-error @endif">
    
    {!! Form::text('nombres', $persona['nombres'], ['class' => 'form-control', 'placeholder' => 'Nombres']) !!}
    @if ($errors->has('nombres')) <p class="help-block">{{ $errors->first('nombres') }}</p> @endif
</div>

<!-- Last Name Form Input -->
<div class="col-lg-6 form-group @if ($errors->has('apellidos')) has-error @endif">
    {!! Form::text('apellidos', $persona['apellidos'], ['class' => 'form-control', 'placeholder' => 'Apellidos']) !!}
    @if ($errors->has('apellidos')) <p class="help-block">{{ $errors->first('apellidos') }}</p> @endif
</div>

<!-- Genero -->
<div class="col-lg-6 form-group @if ($errors->has('genero_idgenero')) has-error @endif">
    {!!Form::select("genero_idgenero",$generos,$persona['genero_idgenero'],['class'=>'form-control','placeholder'=>'-- Genero --'])!!}
    @if ($errors->has('genero_idgenero')) <p class="help-block">{{ $errors->first('genero_idgenero') }}</p> @endif
</div>

<!-- email Form Input -->
<div class="col-lg-6 form-group @if ($errors->has('email')) has-error @endif">
    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
    @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
</div>

<!-- password Form Input -->
<div class="col-lg-6 form-group @if ($errors->has('password')) has-error @endif">
    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
    @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
</div>


<!-- Ciudades -->
<div class="col-lg-3 form-group @if ($errors->has('ciudades_idciudades')) has-error @endif">
    {!!Form::select("ciudades_idciudades",$ciudades,$persona['ciudades_idciudades'],['class'=>'form-control','placeholder'=>'-- Ciudad --'])!!}
    @if ($errors->has('ciudades_idciudades')) <p class="help-block">{{ $errors->first('ciudades_idciudades') }}</p> @endif
</div>

<!-- Sedes -->
<div class="col-lg-3 form-group @if ($errors->has('password')) has-error @endif">
    {!!Form::select("sedes_idsedes",$sedes,$persona['sedes_idsedes'],['class'=>'form-control','placeholder'=>'-- Sede --'])!!}
    @if ($errors->has('sedes_idsedes')) <p class="help-block">{{ $errors->first('sedes_idsedes') }}</p> @endif
</div>


<!-- Centros de costo -->
<div class="col-lg-3 form-group @if ($errors->has('centroscosto_idcentroscosto')) has-error @endif">
    {!!Form::select("centroscosto_idcentroscosto",$centroscosto,$persona['centroscosto_idcentroscosto'],['class'=>'form-control','placeholder'=>'-- Centro de Costo --'])!!}
    @if ($errors->has('centroscosto_idcentroscosto')) <p class="help-block">{{ $errors->first('centroscosto_idcentroscosto') }}</p> @endif
</div>

<!-- Subcentros de costo -->
<div class="col-lg-3 form-group @if ($errors->has('subcentroscosto_idsubcentroscosto')) has-error @endif">
    {!!Form::select("subcentroscosto_idsubcentroscosto",$subcentroscosto,$persona['subcentroscosto_idsubcentroscosto'],['class'=>'form-control','placeholder'=>'-- Subcentro de Costo --'])!!}
    @if ($errors->has('subcentroscosto_idsubcentroscosto')) <p class="help-block">{{ $errors->first('subcentroscosto_idsubcentroscosto') }}</p> @endif
</div>

<!-- tipo de contrato -->
<div class="col-lg-6 form-group @if ($errors->has('tipocontrato_idtipocontrato')) has-error @endif">
    {!!Form::select("tipocontrato_idtipocontrato",$tipocontrato,$persona['tipocontrato_idtipocontrato'],['class'=>'form-control','placeholder'=>'-- Tipo de contrato --'])!!}
    @if ($errors->has('tipocontrato_idtipocontrato')) <p class="help-block">{{ $errors->first('tipocontrato_idtipocontrato') }}</p> @endif
</div>

<!-- Roles Form Input -->
<div class="col-lg-6 form-group @if ($errors->has('roles')) has-error @endif">
    {!! Form::label('roles[]', 'Roles') !!}
    {!! Form::select('roles[]', $roles, isset($user) ? $user->roles->pluck('id')->toArray() : null,  ['class' => 'form-control', 'multiple']) !!}
    @if ($errors->has('roles')) <p class="help-block">{{ $errors->first('roles') }}</p> @endif
</div>

<!-- firma -->
<div class='col-sm-6 form-group'>
	<?php 
	   if(isset($user['firma'])){
	       $firma = $user['firma'];
	   }else {
	       $firma = "";
	   }
	?>
	{!! Form::label('firma', 'Firma') !!}
	<div class='row'>
        <div id='firmapng' class='col-sm-6'>
        	<img src="{!!$firma!!}">
        </div>
        {{Form::hidden('firma',$firma,['id'=>'firma'])}}
        <div id="signature-pad" class="m-signature-pad col-sm-6" style='width:305px;' >
            <div id='contenedorcanvas' class="m-signature-pad--body" style='border:1px solid #333;'>
              <canvas></canvas>
            </div>
            
              	<button type="button" class="btn btn-danger" data-action="clear">Limpiar</button>
                <button type="button" class="btn btn-success" data-action="save-png">Guardar</button>
                
              
            <div class="m-signature-pad--footer">
              <div class="description">
              
              </div>
            </div>
    	</div>
	</div>
</div>

<!-- estados -->
<div class="col-lg-6 form-group">
	{!! Form::label('estado', 'Estado') !!}
    {!!Form::select("estado",$estados,$persona['estado'],['class'=>'form-control','placeholder'=>'-- Estado --'])!!}
</div>
<div class='col-lg-12'>
<hr>
</div>
<!-- Permissions -->
@if(isset($user))
	<div class='col-lg-12 form-group'>
		@include('shared._permissions', ['closed' => 'true', 'model' => $user ])
	</div>
    
@endif


