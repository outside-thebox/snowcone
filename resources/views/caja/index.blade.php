@extends('layouts.app')

@section('scripts')



    <script>
        vm = new Vue({
            el: '#main',
            data:{
                caja: {
                    cod: '',
                    supago: '',
                    vuelto:''
                },
                errors: [],
                pagina_actual: 0,
                first: '',
                prev: '',
                next: '',
                last: '',
                lista: [],
                busqueda: true,
                id_seleccionado: 0,
                token: '',
                presupuesto_seleccionado:"",
                lista_presupuestos:[{"nro_presupuesto":"13","cliente":"Lucas Matias Sisi","total":"650","fecha":"",
                    "estado":{"cod":"0","descripcion":"No Cobrado"},
                    "articulos":[
                        {"id":"1","cod":"1","descripcion":"180 Jordy CourtGoodwinhaven, NC 86083","cantidad":"5","precio_sugerido":"35"},
                        {"id":"30","cod":"30","descripcion":"38279 Spencer Corners","cantidad":"3","precio_sugerido":"95"},
                        {"id":"20","cod":"40","descripcion":"180 Jordy CourtGoodwinhaven, NC 86083","cantidad":"4","precio_sugerido":"70"},
                    ]},
                    {"nro_presupuesto":"1351","cliente":"Lucas","total":"650","fecha":"",
                        "estado":{"cod":"0","descripcion":"No Cobrado"},
                        "articulos":[
                            {"id":"1","cod":"1","descripcion":"180 Jordy CourtGoodwinhaven, NC 86083","cantidad":"5","precio_sugerido":"35"},
                            {"id":"30","cod":"30","descripcion":"38279 Spencer Corners","cantidad":"3","precio_sugerido":"95"},
                            {"id":"20","cod":"40","descripcion":"180 Jordy CourtGoodwinhaven, NC 86083","cantidad":"4","precio_sugerido":"70"},
                        ]},
                    {"nro_presupuesto":"1310","cliente":"Carlos","total":"650","fecha":"",
                        "estado":{"cod":"1","descripcion":"Cobrado"},
                        "articulos":[
                            {"id":"1","cod":"1","descripcion":"180 Jordy CourtGoodwinhaven, NC 86083","cantidad":"5","precio_sugerido":"35"},
                            {"id":"30","cod":"30","descripcion":"38279 Spencer Corners","cantidad":"3","precio_sugerido":"95"},
                            {"id":"20","cod":"40","descripcion":"180 Jordy CourtGoodwinhaven, NC 86083","cantidad":"4","precio_sugerido":"70"},
                        ]},
                    {"nro_presupuesto":"1300","cliente":"Juan","total":"650","fecha":"",
                        "estado":{"cod":"1","descripcion":"Cobrado"},
                        "articulos":[
                            {"id":"1","cod":"1","descripcion":"180 Jordy CourtGoodwinhaven, NC 86083","cantidad":"5","precio_sugerido":"35"},
                            {"id":"30","cod":"30","descripcion":"38279 Spencer Corners","cantidad":"3","precio_sugerido":"95"},
                            {"id":"20","cod":"40","descripcion":"180 Jordy CourtGoodwinhaven, NC 86083","cantidad":"4","precio_sugerido":"70"},
                        ]},
                    {"nro_presupuesto":"1388","cliente":"Pedro","total":"650","fecha":"",
                        "estado":{"cod":"1","descripcion":"Cobrado"},
                        "articulos":[
                            {"id":"1","cod":"1","descripcion":"180 Jordy CourtGoodwinhaven, NC 86083","cantidad":"5","precio_sugerido":"35"},
                            {"id":"30","cod":"30","descripcion":"38279 Spencer Corners","cantidad":"3","precio_sugerido":"95"},
                            {"id":"20","cod":"40","descripcion":"180 Jordy CourtGoodwinhaven, NC 86083","cantidad":"4","precio_sugerido":"70"},
                        ]},
                ],
            },
            watch:{
                lista:function(){
                    $('[data-toggle="tooltip"]').tooltip();
                }
            },
            computed:{
                computedClass: function () {
                    console.log();
                    return 'label label-success';
                }
            },
            methods:{
                add: function(){
                    cargando('sk-circle','Buscando');
                    vm.presupuesto_seleccionado="";
                    var nro_presupuesto = vm.caja.cod;

                    for (var key in vm.lista_presupuestos) {
                        if (nro_presupuesto == vm.lista_presupuestos[key].nro_presupuesto) {
                            if(vm.lista_presupuestos[key].estado.cod == '0') {
                                var presupuesto = {};
                                presupuesto.key = key;
                                presupuesto.nombre = vm.lista_presupuestos[key].cliente;
                                presupuesto.total = vm.lista_presupuestos[key].total;
                                presupuesto.articulos = [];
                                for (var key2 in vm.lista_presupuestos[key].articulos) {
                                    var articulo = {};
                                    articulo.descripcion = vm.lista_presupuestos[key].articulos[key2].descripcion;
                                    articulo.cantidad = vm.lista_presupuestos[key].articulos[key2].cantidad;
                                    articulo.precio_unitario = vm.lista_presupuestos[key].articulos[key2].precio_sugerido;
                                    articulo.subtotal = vm.lista_presupuestos[key].articulos[key2].precio_sugerido * vm.lista_presupuestos[key].articulos[key2].cantidad;
                                    presupuesto.articulos.push(articulo);
                                }
                                vm.presupuesto_seleccionado = presupuesto;
                                vm.supago = '';
                            }
                        }
                    }

                    HoldOn.close();
                    vm.caja.cod = '';
                },
                pagar:function () {
                    cargando('sk-circle','Buscando');
                    //console.log(vm.presupuesto_seleccionado.total);
                    //vm.caja.supago = '';
                    if(parseFloat(vm.caja.supago) >= parseFloat(vm.presupuesto_seleccionado.total) ){
                        vm.caja.vuelto = vm.caja.supago - vm.presupuesto_seleccionado.total
                        console.log(vm.lista_presupuestos[vm.presupuesto_seleccionado.key]);
                        vm.lista_presupuestos[vm.presupuesto_seleccionado.key].estado.cod = '1';
                        vm.lista_presupuestos[vm.presupuesto_seleccionado.key].estado.descripcion = 'Cobrado';
                    }
                    else {
                        var mensaje = "";
                        mensaje += "<li>Su Pago es insuficiente</li><br>";
                        $("#contenido-modal-1").html(mensaje);
                        $("#confirmacion-1").modal(function(){show:true});
                    }
                    HoldOn.close();
                },
                get_color:function(codigo_estado){
                    if(codigo_estado.cod === '1')
                        return 'label-success';
                    else
                        return 'label-danger';
                },
            }
        });

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
@section('content')
    <h1>Caja</h1>

    <div class="form-inline" style="margin-bottom: 10px">
        <div class="col-md-6">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
            <input type="hidden" name="id_seleccionado" value="" v-model="id_seleccionado">

            {{ method_field('PUT') }}

            {!! Form::label('cod','Presupuesto Nro',['class' => 'campos_resaltados']) !!}
            {!! Form::text('cod',null,['class' => 'form-control','v-model' => 'caja.cod','autofocus','v-on:keyup.enter'=>"add"]) !!}


            <div v-show="lista_presupuestos.length > 0">
                <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
                    <thead>
                    <tr>
                        <th>Nro presupuesto</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody id="table">
                        <tr v-for="registro in lista_presupuestos">
                            <td>@{{ registro.nro_presupuesto }}</td>
                            <td>@{{ registro.cliente }}</td>
                            <td>$@{{ registro.total }}</td>
                            <td>@{{ registro.fecha }}</td>
                            <td>
                                <h5>
                                    <span  style="font-size: 90%;" class="label" :class="get_color(registro.estado)" >@{{ registro.estado.descripcion }}</span>
                                </h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>
        </div>
        <div class="col-md-6">
            <label class="campos_resaltados">Cliente: <span>@{{ presupuesto_seleccionado.nombre }}</span></label><br>
            <label class="campos_resaltados">Total a cobrar: <span v-if="presupuesto_seleccionado.total"> $@{{ presupuesto_seleccionado.total }}</span></label><br>
            {!! Form::label('cant','Su pago') !!}
            <div class="input-group">
                <div class="input-group-addon">$</div>
                {!! Form::text('cant',null,['class' => 'form-control','v-model' => 'caja.supago','autofocus','v-on:keyup.enter'=>"pagar", 'required']) !!}
            </div>
            {!! Form::label('cant','Vuelto') !!}
            <div class="input-group">
                <div class="input-group-addon">$</div>
                {!! Form::text('cant',null,['class' => 'form-control','v-model' => 'caja.vuelto','autofocus','disabled']) !!}
            </div>
            <div>
                <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
                    <thead>
                    <tr>
                        <th>Articulos</th>
                        <th>Cantidad</th>
                        <th>Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody id="table">
                    <tr v-for="row in presupuesto_seleccionado.articulos">
                        <td>@{{ row.descripcion }}</td>
                        <td>@{{ row.cantidad }}</td>
                        <td>$@{{ row.precio_unitario }}</td>
                        <td>$@{{ row.subtotal }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('components.modal',['id' => 1,'accion' => 'Guardar'])

@endsection