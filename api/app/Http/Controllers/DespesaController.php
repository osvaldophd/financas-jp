<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class DespesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
           $dados= DB::table('despesas')
                    ->join('items', function ($join) {$join->on('items.id', '=', 'despesas.item_id');})
                    ->orderBy('despesas.created_at','DESC')
                    ->where("despesas.user_id","=",$id)
                    ->get();
            return response()->json([
                'status'    => true,
                    'Despesa' => $dados
                    ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_trazer_Empresa', 'errors'=>$e], 500);
        }
    }

    //Total de despesas
    public function totalDispesa($id)
    {   
         try {
                $totaldespesa = DB::table('despesas')
                ->select(DB::raw('SUM(valor) as MONTANTE'))
                ->where('despesas.user_id','=',$id)
                ->get();
                return response()->json([$totaldespesa], 200);
            } catch (\Throwable $th) {
                    return response()->json(['message' => 'nao_foi_possivel_estatistica'], 500);
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
                'valor' => 'required',
                'prazo_pagamento' => 'required',
                'rendimento_id' => 'required'
            ]);
 
            if($validator->fails()){
                return response()->json(['status' => 'fail', 'message' => $validator->errors()->all()]);
            }else{
                $despesa = new Despesa;
                $despesa->valor = $request->valor;    
                $despesa->prazo_pagamento = $request->prazo_pagamento;            
                $despesa->item_id =  (int)$request->item_id;                            
                $despesa->user_id =  (int)$request->user_id;
                $despesa->rendimento_id = (int)$request->rendimento_id;
                $despesa->save();
                return response()->json(['status' => true, 'message' => 'Despesa_adicionado_com_succeso', 
                'data'=>['despesa' =>  $despesa]
                ], 200);
            }
 
        } catch (\Exception $e) {
            return  $e;
            return response()->json(['message' => 'nao_foi_possivel_adicionar_despesa', 'errors'=>$e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Despesa  $despesa
     * @return \Illuminate\Http\Response
     */
    public function show(Despesa $despesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Despesa  $despesa
     * @return \Illuminate\Http\Response
     */
    public function edit(Despesa $despesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Despesa  $despesa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Despesa $despesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Despesa  $despesa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Despesa $despesa)
    {
        //
    }
    
    //metodo que retorna todos os items
    public function despesa($id)
    {
        try {
            $tipoDespesa =DB::table('despesas')
            ->join('items', function ($join) {$join->on('items.id', '=', 'despesas.item_id');})
            ->orderBy('despesas.created_at','DESC')
            ->where('despesas.user_id', '=',$id)
            ->get();
           
            if($tipoDespesa!=null)
            {              
                  return response()->json(["despesas"=>$tipoDespesa], 200);
            }
            else{
                return response()->json(['message' => 'tipos_de_despesas_nao_encontrada'], 200);
            }

        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_editar_tipo_despeas'], 500);
        }
    }
   


    //SELECT i.nome as despesa, d.valor, d.prazo_pagamento FROM despesa d INNER JOIN item_despesa i WHERE d.id=i.id 
}
