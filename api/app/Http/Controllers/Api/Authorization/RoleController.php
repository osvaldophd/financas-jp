<?php

namespace App\Http\Controllers\Api\Authorization;

use Validator;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    
    /**
     * Verify if user us authorization with JWT-AUTH
     *
     */

    public function __construct() {
        $this->middleware('jwt-auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            return response()->json([
                'status'    => true,
                'roles' => Role::where('id', '>', 0)->with(['permissions'])->orderBy('id', 'desc')->get()
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'nao_foi_possivel_trazer_papel'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name'=>'required',
                'display_name'=>'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
            }else{
                
                $role = new Role;
                $role->name = $request->name;
                $role->display_name = $request->display_name;
                $role->description = $request->description;
                $role->save();

                if($request->permissions){
                    $role->syncPermissions($request->permissions, 1);
                }

                return response()->json(['status' => true, 'message' => 'papel_adicionado_com_succeso', 'role' => Role::where('id', $role->id)->with(['permissions'])->orderBy('id', 'desc')->get()], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_adicionar_papel', 'errors'=>$e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $role = Role::find($id);
        
            if($role!=null){
                return response()->json(['status' => true, 'role' => $role->where('id', '>', $role->id)->with(['permissions'])->orderBy('id', 'desc')->get()], 200);
            }else{
                return response()->json(['message' => 'papel_nao_encontrado'], 200);
            }

        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_procurar_papel'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name'=>'required',
                'display_name'=>'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
            }else{

                $role = Role::find($id);
        
                if($role!=null){
                
                    $role->name = $request->name;
                    $role->display_name = $request->display_name;
                    $role->description = $request->description;
                    $role->save();

                    if($request->permissions){
                        $role->syncPermissions($request->permissions, 1);
                    }else{
                        $role->permissions()->detach();
                    }

                    return response()->json(['status' => true, 'message' => 'papel_actualizada_com_succeso', 'role' => Role::where('id', $role->id)->with(['permissions'])->orderBy('id', 'desc')->get()], 200);

                }else{
                    return response()->json(['message' => 'papel_nao_encontrado'], 200);
                }
            }
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_actualizar_papel', 'errors'=>$e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $role = Role::find($id);
        
            if($role!=null){
                $role->delete();
                return response()->json(['status' => true, 'role' => 'papel_excluido'], 200);
            }else{
                return response()->json(['message' => 'papel_nao_encontrada'], 200);
            }
            
        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_excluir_papel'], 500);
        }
    }
}
