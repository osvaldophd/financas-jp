<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    //
    protected $table = 'despesas';
    protected $fillable = ['valor', 'user_id', 'item_despesa_id'];

    //usuario tem despesas
    public function user()
    {
        return $this->hasOne(User::class);
    }

    //as despesas estao associadas a itens
    public function ItemDespesas()
    {
        return $this->hasMany(Item::class);
    }

}
