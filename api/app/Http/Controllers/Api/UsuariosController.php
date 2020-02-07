<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsuariosController extends Controller
{
    /**
     * Verify if user us authorization with JWT-AUTH
     *
     */

    // public function __construct() {
    //     $this->middleware('jwt-auth');
    // }

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
                'data'=>[
                    'usuarios' => User::where('id', '>', 0)
                    ->orderBy('id', 'desc')->get()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_trazer_usuarios', 'errors'=>$e], 500);
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
                'name' => 'required',
                'email' => 'required | email | unique:users',
                'password' => 'required',
            ]);

            if($validator->fails()){
                return response()->json(['status' => 'fail', 'message' => $validator->errors()->all()]);
            }else{

                $usuario = new User;
                $usuario->name = $request->name;
                $usuario->email = $request->email;
                $usuario->password = bcrypt($request->password);
                $usuario->save();

                return response()->json(['status' => true, 'message' => 'usuario_adicionado_com_succeso', 
                'data'=>[
                    'usuario' => User::where('id', $usuario->id)->get(), 
                    'token_type' => 'bearer', 'token' => JWTAuth::fromUser($usuario)
                    ]
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_adicionar_usuario', 'errors'=>$e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $usuario id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $usuario = User::find($id);
        
            if($usuario!=null){
                return response()->json(['status' => true, 'data' =>[ 
                    'data'=>[
                        'usuario' => User::where('id', $usuario->id)->with(['roles.permissions', 'permissions'])->get()
                    ]
                ]], 200);
            }else{
                return response()->json(['message' => 'usuario_nao_encontrado'], 404);
            }

        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_procurar_usuario'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'password' => 'sometimes|min:8',
            ]);

            if($validator->fails()){
                return response()->json(['status' => 'fail', 'message' => $validator->errors()->all()]);
            }else{

                $usuario = User::find($id);
        
                if($usuario!=null){
                
                    $usuario->name = $request->name;
                    $usuario->email = $request->email;

                    if(isset($request->password)){
                        $usuario->password = bcrypt($request->password);
                    }

                    $usuario->save();

                    return response()->json(['status' => true, 'message' => 'usuario_actualizado_com_succeso', 
                        'data' =>[ 
                                'usuario' => User::where('id', $usuario->id)->with(['roles.permissions', 'permissions'])->get()
                            ]
                    ], 200);

                }else{
                    return response()->json(['message' => 'usuario_nao_encontrado'], 404);
                }
            }
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_adicionar_usuario'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $usuario = User::find($id);
        
            if($usuario!=null){
                $usuario->delete();
                return response()->json(['status' => true, 'message' => 'usuario_excluido'], 200);
            }else{
                return response()->json(['message' => 'usuario_nao_encontrado'], 200);
            }
            
        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_excluir_usuario'], 500);
        }
    }
}
