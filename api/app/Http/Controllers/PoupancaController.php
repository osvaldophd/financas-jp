<?php

namespace App\Http\Controllers;

use App\Models\Poupanca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use JWTAuth;

class PoupancaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            
            $poupanca =DB::table('poupancas')
            ->join('rendimentos', function ($join) {$join->on('rendimentos.id', '=', 'poupancas.rendimento_id');})
            ->orderBy('poupancas.created_at','DESC')
            ->where("poupancas.user_id","=",$id)
            ->get();

            if($poupanca!=null)
            {              
                return response()->json(["poupanca"=>$poupanca], 200);
            }
            else{
                return response()->json(['message' => 'poupanca_nao_encontrada'], 200);
            }


        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_trazer_poupanca', 'errors'=>$e], 500);
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

            $validator = Validator::make($request->all(), 
            [
                'valor' => 'required',
                'datap' => 'required',
                'rendimento_id' => 'required',
            ]);
 
            if($validator->fails()){
                return response()->json(['status' => 'fail', 'message' => $validator->errors()->all()]);
            }else{
 
                $poupanca = new Poupanca();
                $poupanca->valor = $request->valor;
                $poupanca->user_id = $request->user_id;
                $poupanca->rendimento_id = $request->rendimento_id;
                $poupanca->datap = $request->datap;
                $poupanca->save();
                return response()->json(['status' => true, 'message' => 'Item_adicionado_com_succeso'
                ], 200);
            }
 
        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_adicionar_Item', 'errors'=>$e], 500);
        }
    }

}
