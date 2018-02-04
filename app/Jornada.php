<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    public $timestamps = false;

    public function user(){ return $this->belongsTo('App\User'); }
    public function client(){ return $this->belongsTo('App\Client'); }
}
