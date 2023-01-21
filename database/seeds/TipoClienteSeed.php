<?php

use App\Tipocliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TipoClienteSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        TipoCliente::insert(
            [
                [ 'nombre' => 'Oficial'  ],
                [ 'nombre' => 'Residente'  ],
                [ 'nombre' => 'No residente'  ]
            ]
        );

        
    }
}
