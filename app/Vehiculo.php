<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $casts = [
        'updated_at'  => 'datetime:d-m-Y H:i:s',
    ];

    protected $fillable = [
        'placa','conductor', 'esActivo', 'tipocliente_id','user_created','user_updated','esActivo'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_updated', 'id');
    }
   
    public function tipo()
    {
        return $this->belongsTo(Tipocliente::class,'tipocliente_id');
    }

    public function estadia()
    {
        return $this->hasOne(Estadia::class);
    }

    
 

    public function save(array $options = array())
    {
        if( ! isset( $this->id ) )
        {
            $this->user_created = Auth::id();
        }

        $this->user_updated = Auth::id();

        parent::save($options);
    }

}
