<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Cores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoresController extends Controller
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
                'data'=>[
                    'cores' => Cores::where('id', '>', 0)->orderBy('id', 'desc')->get()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'nao_foi_possivel_trazer_cores'], 500);
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
                'nome'=>'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
            }else{
                
                $cor = new Cores;
                $cor->nome = $request->nome;
                $cor->save();

                return response()->json(['status' => true, 'message' => 'cor_adicionado_com_succeso', 
                    'data'=>['cor' => $cor->where('id', $cor->id)->get() ]
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_adicionar_cor', 'errors'=>$e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cores  $cor id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $cor = Cores::find($id);
        
            if($cor!=null){
                return response()->json(['status' => true, 'data'=>[
                    'cor' =>  $cor->where('id', $id)->get()
                    ]
                ], 200);
            }else{
                return response()->json(['message' => 'cor_nao_encontrado'], 200);
            }

        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_procurar_cor'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cores  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'nome'=>'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
            }else{

                $cor = Cores::find($id);
        
                if($cor!=null){
                
                    $cor->nome = $request->nome;
                    $cor->save();

                    return response()->json(['status' => true, 'message' => 'cor_actualizada_com_succeso', 
                    'data'=>[
                        'cor' =>  $cor->where('id', $cor->id)->get() 
                        ]
                    ], 200);

                }else{
                    return response()->json(['message' => 'cor_nao_encontrado'], 200);
                }
            }
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_actualizar_cor', 'errors'=>$e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cores  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $cor = Cores::find($id);
        
            if($cor!=null){
                $cor->delete();
                return response()->json(['status' => true, 'message' => 'cor_excluido'], 200);
            }else{
                return response()->json(['message' => 'cor_nao_encontrada'], 200);
            }
            
        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_excluir_cor'], 500);
        }
    }
}
