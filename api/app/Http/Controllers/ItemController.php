<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Despesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use JWTAuth;

class ItemController extends Controller
{
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
                    'item' => Item::where('id', '>', 0)->orderBy('id', 'desc')->get()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_trazer_usuarios', 'errors'=>$e], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

            $validator = Validator::make($request->all(), 
            [
                'nome' => 'required | unique:items',
                'descricao' => 'required',
            ]);
 
            if($validator->fails()){
                return response()->json(['status' => 'fail', 'message' => $validator->errors()->all()]);
            }else{
 
                $Item = new Item;
                $Item->nome = $request->nome;
                $Item->descricao = $request->descricao;
                $Item->save();
                return response()->json(['status' => true, 'message' => 'Item_adicionado_com_succeso', 
                'data'=>['Item' =>  $Item]
                ], 200);
            }
 
        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_adicionar_Item', 'errors'=>$e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'nome' => 'required | unique:items',
                'descricao' => 'required',
            ]);
 
            if($validator->fails()){
                return response()->json(['status' => 'fail', 'message' => $validator->errors()->all()]);
            }else{
 
                $Item = Item::find($request->id);
        
                if($Item!=null){                
                    $Item->nome = $request->nome;
                    $Item->descricao = $request->descricao;
                    $Item->save();
 
                    return response()->json(['status' => true, 'message' => 'Tipo_de_despesa_actualizado_com_succeso', 
                        'data' =>[ 
                                'Item' => Item::where('id', $Item->id)->get()
                            ]
                    ], 200);
 
                }else{
                    return response()->json(['message' => 'Tipo_de_despesa_nao_encontrada'], 404);
                }
            }
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_editar_Tipo_de_despesa'], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $verifica = Despesa::where("item_id","=",$id)->first();
            $dados = Item::find($id);
            if($verifica){
                return response()->json(['status' => true, 'message' => 'Item_associado_despesa'], 200);
            
            }
            if($dados!=null){
                $dados->delete();
                return response()->json(['status' => true, 'message' => 'Tipo_de_despesa_excluido'], 200);
            }else{
                return response()->json(['message' => 'Tipo_de_despesa_nao_encontrado'], 200);
            }
            
        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_excluir_Tipo_de_despesa'], 500);
        }
    }
}
