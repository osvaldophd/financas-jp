<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rendimento extends Model
{
    //
    protected $table = 'rendimentos';
    protected $fillable = ['valor', 'user_id', 'empresa_id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function empresa()
    {
        return $this->hasMany(Empresa::claass);
    }
}
