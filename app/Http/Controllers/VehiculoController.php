<?php

namespace App\Http\Controllers;

use App\Vehiculo;
use App\Tipocliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $res =    Vehiculo::where(['esActivo'=>1])
                ->with('user:id,name')
                ->with('tipo:id,nombre')
                ->orderBy('id','desc')
                ->get();

       return  response()->json($res);
    }

    /**
     * Listar arreglo tipos de vehiculos
     * 
     * @return []
     */
    public function tipos()
    {
       return Tipocliente::all();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createVehiculoEstadia(Request $request)
    {   
        $request->validate([
            'tipocliente_id' => 'required|numeric',
            'ingreso' => 'required|date',
            'placa' => [
                'required','string', 
                Rule::unique('Vehiculos')->ignore($request->placa),
            ],
        ]);

        $vehiculo = Vehiculo::create($request->all());
        $vehiculo->estadia()->create($request->all());
        return  response()->json($vehiculo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
            'tipocliente_id' => 'required|numeric',
            'placa' => [
                'required','string', 
                Rule::unique('Vehiculos')->ignore($request->placa),
            ],
        ]);

        return Vehiculo::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function show(Vehiculo $vehiculo)
    {
        //
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {   
        $request->validate([
            'tipocliente_id' => 'required|numeric',
            'placa' => [
                'required','string', 
                Rule::unique('Vehiculos')->ignore($request->placa),
            ],
        ]);
        return $vehiculo->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehiculo $vehiculo)
    {
        //
    }
}
