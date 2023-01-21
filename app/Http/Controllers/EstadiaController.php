<?php

namespace App\Http\Controllers;

use App\Estadia;
use App\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return Estadia::where(['esActivo'=>1, 'finalizado'=>0])
       ->with(
        [
            'vehiculo:id,tipocliente_id,placa,conductor,esActivo',
            'vehiculo.tipo:id,nombre',
            'user:id,name'
        ]
        )
       ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehiculo = Estadia::create($request->all());
        return response()->json($vehiculo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\estadia  $estadia
     * @return \Illuminate\Http\Response
     */
    public function show($placa)
    {   
        $resp = [];   //
        $Vehiculo =  Vehiculo::where(['esActivo'=>1, 'placa'=>$placa])->first();
        $idVehiculo = (int) isset($Vehiculo->id)? $Vehiculo->id: 0;

        if(!$idVehiculo > 0){
            $resp['std'] = 'NotFond';
            $resp['msj'] = 'Vehículo no registrado';
        }else{
            $findCarro =  Estadia::where(['finalizado'=>0, 'egreso'=>null, 'vehiculo_id'=>$idVehiculo, 'esActivo'=>1])
                                    ->with([
                                            'vehiculo:id,tipocliente_id,placa,conductor,esActivo',
                                            'vehiculo.tipo:id,nombre',
                                            'user:id,name'
                                           ])
                                    ->latest('created_at')->first();
            
            if(!isset($findCarro->id)){
                $resp['std'] = 'NewEnter';
                $resp['msj'] = 'Ingreso de Vehículo';
                $resp['datos'] = $Vehiculo ;
            }else{
                $resp['std'] = 'GetOut';
                $resp['msj'] = 'Salida de Vehículo';
                $resp['datos'] = $findCarro;
            }
        }
        
        return response()->json($resp);
    }

   
    /**
     * informe se cobros por mess
     *
     */
    public function informe( $anio, $mes)
    {
       $data =  Estadia::select( DB::raw('placa, sum(valorEstadia) valor ') )
       ->join('vehiculos', 'vehiculos.id', '=', 'estadias.vehiculo_id')
       ->where(["finalizado" => 2])
        ->whereYear('estadias.created_at', '=', $anio)
        ->whereMonth('estadias.created_at', '=', $mes)
        ->groupBy('placa')
        ->get();

         return view('informe', compact('data'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\estadia  $estadia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, estadia $estadia)
    {   

       return $estadia->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\estadia  $estadia
     * @return \Illuminate\Http\Response
     */
    public function destroy(estadia $estadia)
    {
        //
    }
}
