<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    public function user(){ return $this->belongsTo('App\User'); }
    public function tipo_gasto(){ return $this->belongsTo('App\Tipo_gasto'); }
}
