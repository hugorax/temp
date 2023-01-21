<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Estadia extends Model
{
    protected $fillable = [
        'vehiculo_id','ingreso', 'egreso', 'valorEstadia','observacion','esActivo','finalizado'
    ];


    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_updated', 'id');
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
