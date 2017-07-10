<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class UserController extends Controller
{
    use Authorizable; //Verificar permisos 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = User::latest()->paginate();
        
        foreach($result as $key=>$val){
        	$personas[$val->id] = \App\PersonasModel::find($val->personas_idpersonas);
        }

        return view('user.index', ['result' => $result, 'personas' => $personas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        $sedes = \App\SedesModel::pluck('nombre','idsedes');
		$centroscosto = \App\CentroscostoModel::pluck('nombre','idcentroscosto');
		$subcentroscosto = \App\SubcentroscostoModel::pluck('nombre','idsubcentroscosto');
		$tipocontrato = \App\TipocontratoModel::pluck('nombre','idtipocontrato');
		$genero = \App\GeneroModel::pluck('nombre','idgenero');
		$ciudades = \App\CiudadesModel::pluck('nombre','idciudades');        
		
		return view('user.new', [
				'persona'=> new \App\PersonasModel(),
        		'roles' => $roles,
        		'sedes' => $sedes,
        		'centroscosto' => $centroscosto,
        		'subcentroscosto' => $subcentroscosto, 
        		'tipocontrato' => $tipocontrato,
        		'generos' => $genero,
				'ciudades' => $ciudades,
				'estados' => [0 => 'Inactivo',1 => 'Activo'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombres' => 'bail|required|min:2',
        	'apellidos' => 'bail|required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles' => 'required|min:1'
        ]);

        // hash password
        $request->merge(['password' => bcrypt($request->get('password'))]);
        
        try{
        	
        	DB::beginTransaction();

        	$persona = [
        			'nombres' => $request['nombres'],
        			'apellidos' => $request['apellidos'],
        			'email' => $request['email'],
        			'estado' => $request['estado'],
        			'sedes_idsedes' => $request['sedes_idsedes'],
        			'centroscosto_idcentroscosto' => $request['centroscosto_idcentroscosto'],
        			'subcentroscosto_idsubcentroscosto' => $request['subcentroscosto_idsubcentroscosto'],
        			'tipocontrato_idtipocontrato' => $request['tipocontrato_idtipocontrato'],
        			'genero_idgenero' => $request['genero_idgenero'],
        			'ciudades_idciudades' => $request['ciudades_idciudades'],
        	];
        	if($persona = \App\PersonasModel::create($persona)){
	        	
        		
        		$request['personas_idpersonas'] = $persona->idpersonas;
        		
        		if($user = User::create($request->except('roles', 'permissions'))){
        			
        			
        			$this->syncPermissions($request, $user); //Set los permisos
        			
        			flash('Usuario Creado.');
        			
        			DB::commit();
        		}
        		
	        } else {
	        	flash()->error('No pudo crearse el usuario.');
	        	DB::rollBack();
	        }
	        
        } catch (Exception $ex) {
        	
        	flash()->error('No pudo crearse el usuario.');
        	DB::rollBack();
        	
        }

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $persona = \App\PersonasModel::find($user->personas_idpersonas);
        $roles = Role::pluck('name', 'id');
        $permissions = Permission::all('name', 'id');
        $sedes = \App\SedesModel::pluck('nombre','idsedes');
        $centroscosto = \App\CentroscostoModel::pluck('nombre','idcentroscosto');
        $subcentroscosto = \App\SubcentroscostoModel::pluck('nombre','idsubcentroscosto');
        $tipocontrato = \App\TipocontratoModel::pluck('nombre','idtipocontrato');
        $generos = \App\GeneroModel::pluck('nombre','idgenero');
        $ciudades = \App\CiudadesModel::pluck('nombre','idciudades');
        $estados = [0 => 'Inactivo',1 => 'Activo'];
        
        
        return view('user.edit',[ 
        		'user' => $user, 
        		'persona' => $persona,
        		'roles' => $roles, 
        		'permissions' => $permissions,
        		'sedes' => $sedes,
        		'centroscosto' => $centroscosto,
        		'subcentroscosto' => $subcentroscosto,
        		'tipocontrato' => $tipocontrato,
        		'generos' => $generos,
        		'ciudades' => $ciudades,
        		'estados' => $estados,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombres' => 'bail|required|min:2',
        	'apellidos' => 'bail|required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required|min:1'
        ]);

        try{
        	
        	DB::beginTransaction();
	        // Get the user
	        $user = User::findOrFail($id);
	
	        // Update user
	        $user->fill($request->except('roles', 'permissions', 'password'));
	
	        // check for password change
	        if($request->get('password')) {
	            $user->password = bcrypt($request->get('password'));
	        }
	
	        // Handle the user roles
	        $this->syncPermissions($request, $user);
	
	        $user->save();
	        
	        $persona = \App\PersonasModel::findOrFail($user->personas_idpersonas);
	        $persona->fill($request->all());
	        $persona->save();
        
	        
	        flash()->success('Usuario Modificado.');
	        
	        
	        DB::commit();
        } catch (Exception $ex) {
        	
        	flash()->error('No pudo modificarse el usuario.');
        	DB::rollBack();
        	
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function destroy($id)
    {
        if ( Auth::user()->id == $id ) {
            flash()->warning('No se permite borrar el usuario que esta actualmente logueado :(')->important();
            return redirect()->back();
        }

        $user = User::findOrFail($id);
        $persona = \App\PersonasModel::findOrFail($user->personas_idpersonas);
        if( $user->delete() && $persona->delete()) {
            flash()->success('Usuario Borrado');
        } else {
            flash()->success('No puede borrarse el usuario');
        }

        return redirect()->back();
    }

    /**
     * Sync roles and permissions
     *
     * @param Request $request
     * @param $user
     * @return string
     */
    private function syncPermissions(Request $request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if( ! $user->hasAllRoles( $roles ) ) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        return $user;
    }
}
