<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poupanca extends Model
{
    //
    protected $table = 'poupancas';
    protected $fillable = ['valor', 'user_id','datap'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
