<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\Rendimento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RendimentoController extends Controller
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
    public function index($id)
    {
        try {

            $rendimento =DB::table('rendimentos')
            ->join('empresas', function ($join) {$join->on('empresas.id', '=', 'rendimentos.empresa_id');})
            ->orderBy('rendimentos.id','DESC')
            ->where("rendimentos.user_id","=",$id)
            ->get(['rendimentos.id', 'rendimentos.valor', 'rendimentos.created_at',
             'rendimentos.updated_at', 'rendimentos.user_id', 'rendimentos.empresa_id', 'rendimentos.mes',
              'empresas.nome_empresa', 'empresas.descricao']);

            if($rendimento!=null)
            {              
                  return response()->json(["rendimento"=>$rendimento], 200);
            }
            else{
                return response()->json(['message' => 'rendimento_nao_encontrada'], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'nao_foi_possivel_trazer_Rendimento'], 500);
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
                'valor'=>'required',
                'mes'=>'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
            }else{
                
                $rendimento = new Rendimento;
                $rendimento->valor = $request->valor;
                $rendimento->user_id = $request->user_id;
                $rendimento->mes = $request->mes;
                $rendimento->empresa_id = $request->empresa_id;
                $rendimento->save();

                return response()->json(['status' => true, 'message' => 'rendimento_adicionado_com_succeso'
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_adicionar_rendimento', 'errors'=>$e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rendimento  $rendimento id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $rendimento = Rendimento::find($id);
        
            if($rendimento!=null){
                return response()->json(['status' => true, 'data'=>[
                    'rendimento' =>  $rendimento->where('id', $id)->with(['modelos'])->get()
                    ]
                ], 200);
            }else{
                return response()->json(['message' => 'rendimento_nao_encontrado'], 200);
            }

        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_procurar_rendimento'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rendimento  $id
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

                $rendimento = Rendimento::find($id);
        
                if($rendimento!=null){
                
                    $rendimento->nome = $request->nome;
                    $rendimento->save();

                    return response()->json(['status' => true, 'message' => 'rendimento_actualizada_com_succeso', 
                    'data'=>[
                        'rendimento' =>  $rendimento->where('id', $rendimento->id)->with(['modelos'])->get() 
                        ]
                    ], 200);

                }else{
                    return response()->json(['message' => 'rendimento_nao_encontrado'], 200);
                }
            }
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'nao_foi_possivel_actualizar_rendimento', 'errors'=>$e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rendimento  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $rendimento = Rendimento::find($id);
        
            if($rendimento!=null){
                $rendimento->delete();
                return response()->json(['status' => true, 'message' => 'rendimento_excluido'], 200);
            }else{
                return response()->json(['message' => 'rendimento_nao_encontrada'], 200);
            }
            
        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_excluir_rendimento'], 500);
        }
    }

    public function estatistica($id){
        try {
            
             $rendimento = DB::table('rendimentos')
             ->select(DB::raw('SUM(valor) as TOTAL_RENDIMENTO'))
             ->where('rendimentos.user_id','=',$id)
             ->first();

             $poupanca = DB::table('poupancas')
             ->select(DB::raw('SUM(valor) as TOTAL_POUPANCA'))
             ->where('poupancas.user_id','=',$id)
             ->first();

             $despesa = DB::table('despesas')
             ->select(DB::raw('SUM(valor) as TOTAL_DESPESA'))
             ->where('despesas.user_id','=',$id)
             ->first();
        
               return response()->json([$rendimento, $poupanca, $despesa], 200);
            
        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_estatistica'], 500);
        }
    }

    public function mensal($id){
        try {
            
            $dados =DB::table('rendimentos')
            ->join('poupancas', function ($join) {$join->on('rendimentos.id', '=', 'poupancas.rendimento_id');})
            ->join('despesas', function ($join) {$join->on('rendimentos.id', '=', 'despesas.rendimento_id');})
            ->orderBy('poupancas.created_at','DESC')
            ->where("rendimentos.user_id","=",$id)
            ->get(
                [
                    'rendimentos.valor as valor_r', 'rendimentos.mes',
                    'despesas.valor as valor_d',
                    'poupancas.valor as valor_p',

                ]
            );

               return response()->json(["rendimento"=>$dados], 200);
            
        } catch (\Throwable $th) {
            return response()->json(['message' => 'nao_foi_possivel_estatistica'], 500);
        }
    }
}
