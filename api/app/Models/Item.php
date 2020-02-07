<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $table = 'items';
    protected $fillable = ['nome', 'descricao'];

    //cada despesas esta associado a item
    public function despesas()
    {
        return $this->belongsTo(Despesa::class);
    }
}
