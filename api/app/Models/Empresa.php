<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    //
    protected $table = 'empresas';
    protected $fillable = ['nome_empresa', 'descricao'];

    //os rendimentos estao associados a empresas
    public function rendimentos()
    {
        return $this->belongsTo(Rendimento::class);
    }
}
