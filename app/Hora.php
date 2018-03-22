<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    public $timestamps = false;

    protected $dates = [
        'entrada',
        'salida',
    ];

    public function user(){ return $this->belongsTo('App\User'); }
    public function client(){ return $this->belongsTo('App\Client'); }
}
