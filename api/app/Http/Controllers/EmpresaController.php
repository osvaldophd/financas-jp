<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use JWTAuth;

class EmpresaController extends Controller
{
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
                    'Empresa' => Empresa::where('id', '>', 0)->orderBy('nome_empresa', 'desc')->get()
 
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_trazer_Empresa', 'errors'=>$e], 500);
        }
    }
    
    public function show($id)
    {
      try {
            
            return response()->json([
                'status'    => true,
                'data'=>[
                    'Empresa' => Empresa::where('id', '=', $id)->first()
 
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_trazer_Empresa', 'errors'=>$e], 500);
        }
    }

   public function store(Request $request)
   {
       try {

           $validator = Validator::make($request->all(), 
           [
               'nome_empresa' => 'required | unique:empresas',
               'descricao' => 'required',
           ]);

           if($validator->fails()){
               return response()->json(['status' => 'fail', 'message' => $validator->errors()->all()]);
           }else{

               $Empresa = new Empresa;
               $Empresa->nome_empresa = $request->nome_empresa;
               $Empresa->descricao = $request->descricao;
               $Empresa->save();
               return response()->json(['status' => true, 'message' => 'Empresa_adicionado_com_succeso', 
               'data'=>['Empresa' =>  $Empresa]
               ], 200);
           }

       } catch (\Exception $e) {
           return response()->json(['message' => 'nao_foi_possivel_adicionar_Empresa', 'errors'=>$e], 500);
       }
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Empresa  $Empresa id
    * @return \Illuminate\Http\Response
    */
   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Empresa  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request)
   {
       try {

           $validator = Validator::make($request->all(), [
               'nome_empresa' => 'required | unique:Empresas',
               'descricao' => 'required',
           ]);

           if($validator->fails()){
               return response()->json(['status' => 'fail', 'message' => $validator->errors()->all()]);
           }else{

               $Empresa = Empresa::find($request->id);
       
               if($Empresa!=null){                
                   $Empresa->nome_empresa = $request->nome_empresa;
                   $Empresa->descricao = $request->descricao;
                   $Empresa->save();

                   return response()->json(['status' => true, 'message' => 'Empresa_actualizado_com_succeso', 
                       'data' =>[ 
                               'Empresa' => Empresa::where('id', $Empresa->id)->get()
                           ]
                   ], 200);

               }else{
                   return response()->json(['message' => 'Empresa_nao_encontrado'], 404);
               }
           }
           
       } catch (\Exception $e) {
           return response()->json(['message' => 'nao_foi_possivel_editar_Empresa'], 500);
       }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Empresa  $Empresa
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       try {

           $Empresa = Empresa::find($id);
           if($Empresa!=null){
               $Empresa->delete();
               return response()->json(['status' => true, 'message' => 'Empresa_excluido'], 200);
           }else{
               return response()->json(['message' => 'Empresa_nao_encontrado'], 200);
           }
           
       } catch (\Throwable $th) {
           return response()->json(['message' => 'nao_foi_possivel_excluir_Empresa'], 500);
       }
   }
}
