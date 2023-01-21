<template>
    <div>
        <div class="card sombra">
            <div class="card-body p-4">
                <div class="row">
                    

                    <div class="col-4">
                        <div class="border-left border-10 border-primary  px-3 mb-3 p-3 som " :class="tab==1?'active':''"  @click="tabulador(1)">
                            <button type="button" class="btn btn-default float-right" @click="openModal('newCar')">
                                <span class="fa fa-plus"></span>
                                <span class="fa fa-car"> </span>
                            </button>
                            <h5 class="card-title fs-4 fw-semibold">Vehículos</h5>
                            
                            <h6 class="card-subtitle fw-normal text-disabled mb-1"> 1.232.150 Registrados</h6>
                            
                        </div>
                    </div>

                    <div class="col-4 ">
                        <div class="border-left border-10 border-success  px-3 mb-3 p-3 som " :class="tab==2?'active':''"  @click="tabulador(2)">
                            <h5 class="card-title fs-4 fw-semibold">Estadías</h5>
                            <h6 class="card-subtitle fw-normal text-disabled mb-1"> 1.232.150 Registradas</h6>
                        </div>
                    </div>


                    <div class="col-4" v-if="tab==2">
                        <div class="input-group input-group-lg">
                        <input type="text" class="form-control" placeholder="Estadía No. Placa" v-model="searchPlaca" @keypress.enter="estadiaInformacion()">
                        </div>
                    <hr>
                    <div class="col-sm-10 pr-0">
                                <div class="input-group mb-3">
                                    
                                    <select class="form-control " v-model="mes" >
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Mayo</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Nombiembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                    <input type="number" class="form-control " v-model="anio">
                                    <div class="input-group-prepend">
                                        <button type="button" class=" btn btn-default " @click="listInforme()">Informe</button>
                                    </div> 

                                </div> 
                            </div>

                    </div>

                </div>


                <div class="row" v-if="tab==1">
                    <table class="resposive table align-middle table-hover  mb-0" id="dtV">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Conductor</th>
                                <th>Tipo</th>
                                <th>Placa</th>
                                <th>Actualizado</th>
                                <th>Realizó</th>
                                <th>Es Activo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="fila in listVehiculos" :key="fila.id" >
                                <td v-text="fila.id"></td>
                                <td v-text="fila.conductor"></td>
                                <td v-text="fila.tipo.nombre"></td>
                                <td v-text="fila.placa"></td>
                                <td v-text="fila.updated_at"></td>
                                <td v-text="fila.user.name"></td>
                                <td >{{ fila.esActivo ==1?'si':'Desactivado' }}</td>
                                <td>
                                    <span class="btn btn-info" @click="openModal('editCar', fila)">
                                        Editar 
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row" v-if="tab==2">
                    <table class="resposive table align-middle table-hover mb-0" id="dtE">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Conductor</th>
                                <th>Placa</th>
                                <th>Ingreso</th>
                                <th>Egreso</th>
                                <th>Valor $</th>
                                <th>Obs</th>
                                <th>Actualizado</th>
                                <th>Realizó</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="fila in listVehiculosEstadias" :key="fila.id" >
                                <td v-text="fila.vehiculo.tipo.nombre"></td>
                                <td v-text="fila.vehiculo.conductor"></td>
                                <td v-text="fila.vehiculo.placa"></td>
                                <td v-text="fila.ingreso"></td>
                                <td v-text="fila.egreso"></td>
                                <td v-text="fila.valorEstadia"></td>
                                <td v-text="fila.observacion"></td>
                                <td v-text="fila.updated_at"></td>
                                <td v-text="fila.user.name"></td>
                                <td>
                                    <span class="btn btn-success" @click="openModal('editParking', fila)">
                                        Operar 
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                
            </div>
        </div>

        <div class="modal fade" :id="idModl" >
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <form v-on:submit.prevent="enviarForm()">
                    <div class="modal-header">
                    <h5 class="modal-title" > {{tituloModl}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div  v-if="alert!=null">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong> {{alert.titulo }} </strong> {{alert.msj }}
                                <button type="button" class="close"  @click="alert=null">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-sm-3">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span for="Nombres" class="input-group-text">Placa</span>
                                    </div> 
                                    <input type="text" v-model="dataForm.placa" maxlength="190" :disabled="blkhead==true" required class="form-control valid">
                                </div> 
                            </div>

                            <div class="col-sm-3 pr-0">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span for="Nombres" class="input-group-text">Tipo</span>
                                    </div> 
                                    <select class="form-control " v-model="dataForm.tipocliente_id" required   :disabled="blkhead==true" >
                                        <option v-for="el in cmbTipoVe" :key="el.id" :value="el.id" v-text="el.nombre" ></option>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span for="Nombres" class="input-group-text">Conductor</span>
                                    </div> 
                                    <input type="text" v-model="dataForm.conductor" maxlength="190" :disabled="blkhead==true"  class="form-control valid">
                                </div> 
                            </div>

                              
                            <div class="col-sm-2">
                                <span v-if="blkhead==true"> {{dataForm.esActivo==1 ? 'Activo':'Desactivado'}} </span>
                                <div v-else class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input"   :checked="dataForm.esActivo==1"  v-model="dataForm.esActivo">
                                    <label class="custom-control-label" for="customSwitches1" @click="dataForm.esActivo==1?dataForm.esActivo=0:dataForm.esActivo=1">Estado</label>
                                </div>
                            </div>

                        </div>


                        <div class="card border-primary p-2 " v-if="opForm=='parking'" >
                            <h3>
                                <span class="fa fa-product-hunt"></span> {{paking}} {{opForm}}
                            </h3>

                            <div class="row">
                                <div class="col-sm-4 pr-0">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span for="Nombres" class="input-group-text">Entrada</span>
                                        </div> 
                                        <input type="datetime-local" v-model="dataForm.ingreso" maxlength="190"    class="form-control">
                                    </div> 
                                </div>
                                <div class="col-sm-4 pr-0" v-if="way!='registroyParqueo'" >
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span for="Nombres" class="input-group-text">Salida</span>
                                        </div> 
                                        <input type="datetime-local" v-model="dataForm.egreso" maxlength="190"   class="form-control">
                                    </div> 
                                </div>

                                <div class="col-sm-4" v-if="way!='registroyParqueo'" >
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span for="Nombres" class="input-group-text">Valor $</span>
                                        </div> 
                                        <input type="text" v-model="dataForm.valorEstadia" maxlength="190"   class="form-control">
                                    </div> 
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span for="Nombres" class="input-group-text">Obs</span>
                                        </div> 
                                        <input type="text" v-model="dataForm.observacion" maxlength="190"   class="form-control">
                                    </div> 
                                </div>
                            </div>    
                        </div>    

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button  class="btn btn-primary">{{btnModl}}</button>
                    </div>
                </form>
            </div>
        </div>
        </div>

    </div>
    
</template>

<script>
    export default {
        mounted() {
            this.loadTipoVehiculos()
            this.tabulador(2)
        },
        data(){
            return{
                    listVehiculos:[],
                    listVehiculosEstadias:[]
                    ,cmbTipoVe:[]
                    ,tituloModl:''
                    ,idModl:'registroVe'
                    ,btnModl:''
                    ,dataForm:{}
                    ,opForm:0
                    ,way:''
                    ,tab:2
                    ,searchPlaca:''
                    ,alert:null
                    ,paking:''
                    ,blkhead:false
                    ,dt:null
                    ,anio:2023
                    ,mes:1
                }
        },
        methods:{
                tabulador(no){
                    if(no==1){
                        this.loadListVehiculos()
                    }else{
                        this.loadListVehiculosEstadias()
                    }
                    this.searchPlaca = null
                    this.tab = no
                },
                mitablaV(){
                    if (this.dt) {
                        this.dt.destroy();
                    }
                    this.$nextTick(()=>{
                    this.dt = $("#dtV").DataTable();
                    })
                },
                openModal(op, fila){
                    this.way = ''
                    this.way = op
                    this.opForm = ''
                    this.paking = null
                    this.blkhead = false
                    this.alert =null
                    if(op=='newCar'){
                        this.tituloModl="Nuevo Vehículo"
                        this.btnModl = 'Guardar'
                        this.dataForm = {esActivo:1}
                    }else if(op=='editCar') {
                        this.tituloModl="Actualizar Vehículo"
                        this.btnModl = 'Actualizar'

                        this.dataForm = {
                            id: fila.id,
                            conductor: fila.conductor,
                            tipocliente_id: fila.tipo.id,
                            placa: fila.placa,
                            esActivo: fila.esActivo
                        }
                    }else if(op=='editParking'){
                        this.blkhead = true
                        this.paking = 'Editar'
                        this.opForm = 'parking'
                        this.dataForm = {
                            id: fila.id,
                            esActivo: fila.esActivo,
                            ingreso: fila.ingreso,
                            egreso: fila.egreso,
                            observacion: fila.observacion,
                            conductor: fila.vehiculo.conductor,
                            tipocliente_id: fila.vehiculo.tipo.id,
                            placa: fila.vehiculo.placa,
                            valorEstadia:fila.valorEstadia
                        }
                        this.btnModl = 'Actualizar Estadía'
                        this.tituloModl="Editar Estadía"
                    }

                    $("#"+this.idModl).modal("show")
                },
                loadListVehiculos(){
                    let url = '/api/vehiculos';
                    axios.get(url).then(res => {
                       this.listVehiculos = res.data
                    }).catch(er => {
                        tocatch(er );
                    });
                },
                loadTipoVehiculos(){
                    let url = '/api/tipoCliente';
                    axios.get(url).then(res => {
                       this.cmbTipoVe = res.data
                    }).catch(er => {
                        tocatch(er );
                    });
                },
                loadListVehiculosEstadias(){
                    let url = '/api/vehiculos/estadias';
                    axios.get(url).then(res => {
                       this.listVehiculosEstadias = res.data
                       this.searchPlaca = null
                    }).catch(er => {
                        tocatch(er );
                    });
                },
                listInforme(){
                    if(!this.anio || !this.mes)return
                    let url = `/api/vehiculoResidentes/${this.anio}/${this.mes}`;
                    axios.get(url).then(res => {
                       var ve = window.open("about:blank", "response", "resizable=yes");
                            ve.document.write(res.data);

                    }).catch(er => {
                        tocatch(er );
                    });

                    


                },
                enviarForm(){
                    if(this.way =='newCar')
                        this.nuevoVehiculo()

                    if(this.way =='editCar')
                        this.actualizarVehiculo()

                    if(this.way =='registroyParqueo')
                        this.nuevoVehiculoEstadia()

                    if(this.way =='entradaParqueo')
                        this.entradaParqueo()

                    if(this.way =='salidaParqueo' || this.way=='editParking')
                        this.salidaParqueo()
                        
                },
                nuevoVehiculo(){
                    let url = '/api/vehiculo';
                    axios.post(url, this.dataForm).then(res => {
                       this.loadListVehiculos()
                       this.dataForm ={}
                       toastr.success('Guardado correctamente');
                       $("#"+this.idModl).modal("hide")
                    }).catch(er => {
                        tocatch(er );
                    });
                },
                actualizarVehiculo(){
                    let url = '/api/vehiculo/'+this.dataForm.id;
                    axios.put(url, this.dataForm).then(res => {
                       this.loadListVehiculos()
                       this.dataForm ={}
                       toastr.success('Actualizado correctamente');
                       $("#"+this.idModl).modal("hide")
                    }).catch(er => {
                        tocatch(er );
                    });
                },
                nuevoVehiculoEstadia(){
                    let url = '/api/new/vehiculo/estadia';
                    axios.post(url, this.dataForm).then(res => {
                       this.loadListVehiculosEstadias()
                       this.dataForm ={}
                       toastr.success('Realizado correctamente');
                       $("#"+this.idModl).modal("hide")
                    }).catch(er => {
                        tocatch(er );
                    });
                },
                entradaParqueo(){
                    let url = '/api/vehiculo/estadia/ingreso'
                    let data = {
                        vehiculo_id: this.dataForm.vehiculo_id,
                        ingreso:  this.dataForm.ingreso,
                        observacion: this.dataForm.observacion 
                    }

                    axios.post(url, data).then(res => {
                       this.loadListVehiculosEstadias()
                       this.dataForm ={}
                       toastr.success('Guardado correctamente');
                       $("#"+this.idModl).modal("hide")
                    }).catch(er => {
                        tocatch(er );
                    });

                },
                salidaParqueo(){
                    let id = this.dataForm.id
                    let data = {
                        ingreso:  this.dataForm.ingreso,
                        egreso:  this.dataForm.egreso,
                        observacion: this.dataForm.observacion,
                        valorEstadia:null,
                        finalizado: 0
                    }

                    if(!isValidDate(data.ingreso)){
                        toastr.error('Fecha invalida', 'Ingreso'); return
                    }
                    var ini =  new Date(data.ingreso);
                    var fin =  0
                    var minuts = 0

                    if(data.egreso!=null){
                        if(!isValidDate(data.egreso) ){
                            toastr.error('Fecha invalida', 'Egreso');  return
                        }
                        fin =  new Date(data.egreso);
                        minuts = parseInt (this.diff_minutes(ini, fin))

                        if(Date.parse(data.egreso) < Date.parse(data.ingreso)){
                            toastr.error('La fecha salida debe ser mayor a la entrada', 'Egreso');  return
                        }
                    }

                    if (this.dataForm.tipocliente_id ==1 && data.egreso !=null) {
                        data.valorEstadia = 0
                        data.finalizado =1 
                    }else if(this.dataForm.tipocliente_id == 2 &&  data.egreso !=null) {
                        data.valorEstadia = parseFloat(((minuts*.05).toFixed(2)))
                        data.finalizado = 2
                    }else if(this.dataForm.tipocliente_id == 3 &&  data.egreso !=null) {
                        data.valorEstadia = parseFloat(((minuts*.5).toFixed(2)))
                        data.finalizado = 1
                    }else{
                        data.valorEstadia =null
                        data.finalizado = 0
                    }

                    let url =`/api/vehiculo/estadia/egreso/${id}`
                    axios.post(url, data).then(res => {
                       this.loadListVehiculosEstadias()
                       this.dataForm ={}
                       toastr.success('Guardado correctamente');
                       $("#"+this.idModl).modal("hide")
                    }).catch(er => {
                        tocatch(er );
                    });

                },
                estadiaInformacion(){
                    this.alert =null
                    this.dataForm  = {}
                    let placa =  this.searchPlaca
                    if(placa =='' || placa.length == 0){
                        return
                    }
                    let url =`/api/vehiculo/estadia/${placa}`
                    axios.get(url).then(res => {
                        if(res.data.std == 'NotFond'){
                            this.tituloModl = res.data.msj
                            this.btnModl  = 'Registar y dar ingreso a parqueo'
                            this.alert    = { titulo:'Debe registrarlo primero',  msj:'¿Seguro que la placa es correcta?' }
                            this.dataForm = { placa:placa, tipocliente_id:3, esActivo:1, ingreso:this.getDateTime() }
                            this.paking = 'Entrada'
                            this.opForm = 'parking'
                            this.way = 'registroyParqueo'
                            this.blkhead = false
                            toastr.error('Vehículo no registrado');
                        }else if(res.data.std == 'GetOut'){
                            this.way = 'salidaParqueo'
                            this.btnModl  = 'Guardar Salida'
                            this.paking = 'Salida'
                            this.opForm = 'parking'
                            this.blkhead = true
                            this.tituloModl = res.data.msj
                            let data = res.data.datos
                            let  fin =  new Date(data.ingreso);
                            let ini = new Date(this.getDateTime())
                            let minuts = parseInt (this.diff_minutes(ini, fin))
                            

                            this.dataForm =  { 
                                id:data.id,
                                placa:placa, 
                                conductor:data.vehiculo.conductor, 
                                tipocliente_id: parseInt(data.vehiculo.tipo.id), 
                                esActivo:data.vehiculo.esActivo,
                                egreso:this.getDateTime(),
                                ingreso:data.ingreso,
                                observacion:data.observacion
                                }
                                if(this.dataForm.tipocliente_id==2)
                                this.dataForm.valorEstadia = minuts*0.05
                                if(this.dataForm.tipocliente_id==3)
                                this.dataForm.valorEstadia = minuts*.5

                        }else{
                            this.way = 'entradaParqueo'
                            this.btnModl  = 'Guardar Ingreso'
                            this.paking = 'Entrada'
                            this.opForm = 'parking'
                            this.blkhead = true
                            this.tituloModl = res.data.msj
                            let car = res.data.datos

                            this.dataForm =  { 
                                vehiculo_id: car.id,
                                placa:car.placa, 
                                conductor:car.conductor, 
                                tipocliente_id: parseInt(car.tipocliente_id), 
                                esActivo:car.esActivo,
                                ingreso:this.getDateTime(),
                                }
                        }

                       $("#"+this.idModl).modal("show")
                    }).catch(er => {
                        tocatch(er );
                    });
                },
                getDateTime(){
                    let now = new Date()
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    return now.toISOString().slice(0,16);
                },
                diff_minutes(dt2, dt1) 
                {
                    var diff =(dt2.getTime() - dt1.getTime()) / 1000;
                    diff /= 60;
                    return Math.abs(Math.round(diff));
                }
        }
    }
</script>
<style scoped>
.sombra{
    box-shadow: 0 3px 6px rgba(0,0,0,.16),0 3px 6px rgba(0,0,0,.23)!important;
}

.border-10{
 border-width: 5px !important;
}

.som:hover {
    cursor: pointer;
    box-shadow: 0 3.5px 7px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22) !important;
}

.active{
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23) !important;
    transition: all 0.3s cubic-bezier(.25,.8,.25,1) !important;
}

</style>