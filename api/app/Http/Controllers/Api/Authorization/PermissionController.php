<?php

namespace App\Http\Controllers\Api\Authorization;

use Validator;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
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
                'permissions' => Permission::where('id', '>', 0)->orderBy('id', 'desc')->get()
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'nao_foi_possivel_trazer_permissions'], 500);
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
                
                $permission = new Permission;
                $permission->name = $request->name;
                $permission->display_name = $request->display_name;
                $permission->description = $request->description;
                $permission->save();

                return response()->json(['status' => true, 'message' => 'permission_adicionado_com_succeso', 'permission' => $permission], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_adicionar_permission', 'errors'=>$e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $permission = Permission::find($id);
        
            if($permission!=null){
                return response()->json(['status' => true, 'permission' =>  Role::where('id', $id)->with(['roles'])->get()], 200);
            }else{
                return response()->json(['message' => 'permission_nao_encontrado'], 200);
            }

        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_procurar_permission'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $id
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

                $permission = Permission::find($id);
        
                if($permission!=null){
                
                    $permission->name = $request->name;
                    $permission->display_name = $request->display_name;
                    $permission->description = $request->description;
                    $permission->save();

                    return response()->json(['status' => true, 'message' => 'permission_actualizada_com_succeso', 'permission' =>  $permission], 200);

                }else{
                    return response()->json(['message' => 'permission_nao_encontrado'], 200);
                }
            }
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_actualizar_permission', 'errors'=>$e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $permission = Permission::find($id);
        
            if($permission!=null){
                $permission->delete();
                return response()->json(['status' => true, 'permission' => 'permission_excluido'], 200);
            }else{
                return response()->json(['message' => 'permission_nao_encontrada'], 200);
            }
            
        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_excluir_permission'], 500);
        }
    }
}
