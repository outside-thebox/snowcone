@extends('layouts.app')

@section('scripts')

    <style>

        .remarcar{
            background-color: red !important;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

    </style>

    @include('functions.eliminarPresupuesto')


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
                lista_presupuestos:[],
                presupuestosxarticulos:[],
                precio_total: '',
                boton_cobrar: false
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
                find:function()
                {
                    cargando('sk-circle','Buscando');
                    vm.presupuesto_seleccionado="";
                    vm.boton_cobrar = false;
                    vm.caja.vuelto = '';
                    vm.caja.supago = '';
                    vm.precio_total = '';
                    vm.presupuestosxarticulos = [];
                    var nro_presupuesto = vm.caja.cod;

                    $.ajax({
                        url: "{{ Route('presupuesto.buscar') }}",
                        data: '_token='+this.token+"&id="+nro_presupuesto,
                        method: 'POST',
                        dataType: "json",
                        success: function (data) {
                            vm.lista_presupuestos = data;
                            if(vm.lista_presupuestos.length > 0)
                            {
                                if(vm.lista_presupuestos.length == 1)
                                {
                                    vm.presupuestosxarticulos = vm.lista_presupuestos[0].presupuestoxarticulo;
                                    vm.precio_total = vm.lista_presupuestos[0].precio_total;
                                    vm.presupuesto_seleccionado = vm.lista_presupuestos[0];
                                }
                            }
                            else
                            {
                                vm.presupuestosxarticulos = [];
                                vm.precio_total = "";
                            }
                        },
                        error: function(respuesta)
                        {
                            $("#confirmacion-1").modal(function(){show:true});

                        }

                    });
                    HoldOn.close();
                },
                pagar:function () {
                    cargando('sk-circle','Buscando');
                    //vm.caja.supago = '';
                    if(parseFloat(vm.caja.supago) >= parseFloat(vm.presupuesto_seleccionado.precio_total.toString().replace(',','.')) ){
                        console.log(vm.caja.supago,vm.presupuesto_seleccionado.precio_total);
                        vm.caja.vuelto = (vm.caja.supago - parseFloat(vm.presupuesto_seleccionado.precio_total.toString().replace(',','.')));
                        vm.caja.vuelto = vm.caja.vuelto.toString().replace('.',',');
//                        vm.lista_presupuestos[vm.presupuesto_seleccionado.key].estado.cod = '1';
//                        vm.lista_presupuestos[vm.presupuesto_seleccionado.key].estado.descripcion = 'Cobrado';
                        console.log(vm.presupuesto_seleccionado);
                        if(vm.presupuesto_seleccionado.estado_id == 1)
                            vm.boton_cobrar = true;
                        else
                            vm.boton_cobrar = false;
                    }
                    else {
                        var mensaje = "";
                        mensaje += "<li>Su Pago es insuficiente</li><br>";
                        $("#contenido-modal-1").html(mensaje);
                        $("#confirmacion-1").modal(function(){show:true});
                    }
                    HoldOn.close();
                },
                traerPresupuestos: function()
                {
//                    vm.presupuesto_seleccionado="";
//                    vm.boton_cobrar = false;
//                    vm.caja.vuelto = '';
//                    vm.caja.supago = '';
//                    vm.presupuestosxarticulos = [];

                    $.ajax({
                        url: "{{ Route('presupuesto.buscar') }}",
                        data: '_token='+this.token,
                        method: 'POST',
                        dataType: "json",
                        success: function (data) {
                            vm.lista_presupuestos = data;
                        },
                        error: function(respuesta)
                        {
                            $("#confirmacion-1").modal(function(){show:true});

                        }

                    });
                },
                cobrar: function(){

                    vm.boton_cobrar = false;
                    cargando('sk-circle','Actualizando');
                    var lista_presupuesto = this.presupuesto_seleccionado;
                    lista_presupuesto._token = this.token;
                    lista_presupuesto.estado_id = 2;
                    $.ajax({
                        url: "{{ Route('presupuesto.updateEstado') }}",
                        method: 'POST',
                        data: "id="+vm.presupuesto_seleccionado.id+"&estado_id="+2+"&_token="+this.token,
                        dataType: "json",
                        success: function (data) {
                             location.href = "{{ Route('master',5) }}";

                        },
                        error: function(respuesta)
                        {
                            $("#contenido-modal-1").html("No hay stock suficiente para el artículo " + respuesta.responseJSON.descripcion);
                            $("#confirmacion-1").modal(function(){show:true});
                            vm.boton_cobrar = true;
                        }

                    });
                    HoldOn.close();

                },
                cerrarCaja: function()
                {


                    $("#pregunta-2").modal(function(){show:true});

                    $("#contenido-pregunta-2").html("");
                    $("#contenido-pregunta-2").append("<h3>¿Confirma que desea cerrar la caja?</h3>");
                    $("#pregunta-2").modal(function(){show:true});



                },
                imprimirPresupuesto: function(id)
                {
//                    console.log(id);
                    var win = window.open("{{ Route('presupuesto.index') }}/exportarPDF/"+id, '_blank');
                    win.print();

                },
                cancelarPresupuesto: function(id,cliente)
                {
                    $("#pregunta-1").modal(function(){show:true});

                    $("#contenido-pregunta-1").html("");
                    $("#contenido-pregunta-1").append("<h3>¿Confirma que desea cancelar el presupuesto para <strong>"+cliente+"</strong>?</h2>");
                    $("#pregunta-1").modal(function(){show:true});
                    $("input:hidden[name=id_seleccionado]").val(id);
                },
                anularPresupuesto: function(id,cliente)
                {
                    $("#pregunta-3").modal(function(){show:true});

                    $("#contenido-pregunta-3").html("");
                    $("#contenido-pregunta-3").append("<h3>¿Confirma que desea anular el presupuesto para <strong>"+cliente+"</strong>?</h2>");
                    $("#pregunta-3").modal(function(){show:true});
                    $("input:hidden[name=id_seleccionado]").val(id);
                }
            }
        });

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();


            $(".numeros").mask("9999999");

            vm.traerPresupuestos();

            $("#eliminar-2").click(function(){
                cargando('sk-circle','Actualizando');
                $.ajax({
                    url: "{{ Route('caja.cerrarCaja') }}",
                    method: 'POST',
                    data: "_token="+$("input:hidden[name=_token]").val(),
                    dataType: "json",
                    success: function (data) {
                        location.href = "{{ Route('master',5) }}";
                    },
                    error: function()
                    {
                        $("#contenido-modal-1").html("Se ha producido un error, por favor contacte con el administrador");
                        $("#confirmacion-1").modal(function(){show:true});

                    }

                });
                HoldOn.close();
            });
            $("#eliminar-1").click(function(){
                cancelarPresupuesto(7);
            });

            $("#eliminar-3").click(function(){
                anularPresupuesto(7);
            });

        });
    </script>
@endsection
@section('content')
    <h1>Caja
        <a @click="cerrarCaja()"><button class="btn btn-primary pull-right" style="margin-left: 10px">Cerrar Caja</button></a>
        <a href="{!! route('articulosxstock.addBoleta')!!}" ><button style="margin-left: 10px" class="btn btn-success pull-right" >Agregar boleta</button></a>
        <a href="{!! route('caja.history')!!}"><button class="btn btn-success pull-right">Listado de cierre de cajas</button></a>
    </h1>

    @include('components.message-confirmation')

    <div class="form-inline" style="margin-bottom: 10px">
        <div class="col-md-6">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
            <input type="hidden" name="id_seleccionado" value="" v-model="id_seleccionado">

            {{ method_field('PUT') }}

            {!! Form::label('cod','Presupuesto Nro',['class' => 'campos_resaltados']) !!}
            {!! Form::text('cod',null,['class' => 'form-control numeros','v-model' => 'caja.cod','autofocus','v-on:keyup.enter'=>"find"]) !!}


            <div v-show="lista_presupuestos.length > 0">
                <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
                    <thead>
                    <tr>
                        <th>Nro</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th width="10%">#</th>
                    </tr>
                    </thead>
                    <tbody id="table">
                        <tr v-for="registro in lista_presupuestos">
                            <td>@{{ registro.id }}</td>
                            <td>@{{ registro.cliente }}</td>
                            <td>$@{{ registro.precio_total }}</td>
                            <td>@{{ registro.created_at }}</td>
                            <td>
                                <span class="label label-primary" v-if="registro.estado_id == 1">@{{ registro.estado.descripcion }}</span>
                                <span class="label label-success" v-if="registro.estado_id == 2">@{{ registro.estado.descripcion }}</span>
                                <span class="label label-danger" v-if="registro.estado_id == 3">@{{ registro.estado.descripcion }}</span>
                                <span class="label label-info" v-if="registro.estado_id == 4">@{{ registro.estado.descripcion }}</span>
                            </td>
                            {{--<td>--}}
                                {{--<a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Imprimir' @click="imprimirPresupuesto(registro.id)" ><i class='glyphicon glyphicon-print' ></i></a>--}}
                            {{--</td>--}}
                            <td>
                                <a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Imprimir' href="{{ Route('presupuesto.index') }}/exportarPDF/@{{ registro.id }}"><i class='glyphicon glyphicon-print' ></i></a>
                                <a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Cancelar' v-show="registro.estado_id == 1" @click="cancelarPresupuesto(registro.id,registro.cliente)"><i class='glyphicon glyphicon-trash' ></i></a>
                                <a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Anular' v-show="registro.estado_id == 2" @click="anularPresupuesto(registro.id,registro.cliente)"><i class='glyphicon glyphicon-minus-sign' ></i></a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <h2 v-show="lista_presupuestos.length == 0">No se encontraron resultados</h2>
        </div>
        <div class="col-md-6">
            <label class="campos_resaltados">Cliente: <span>@{{ presupuesto_seleccionado.cliente }}</span></label><br>
            <label class="campos_resaltados">Total a cobrar: <span v-if="precio_total"> $@{{ precio_total }}</span></label><br>
            <div class="col-md-12" style="margin-bottom: 20px">
                <div class="col-md-6">
                    {!! Form::label('cant','Su pago') !!}
                    <div class="input-group">
                        <div class="input-group-addon">$</div>
                        {!! Form::text('cant',null,['class' => 'form-control numeros','v-model' => 'caja.supago','autofocus','v-on:keyup.enter'=>"pagar", 'required']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    {!! Form::label('cant','Vuelto') !!}
                    <div class="input-group">
                        <div class="input-group-addon">$</div>
                        {!! Form::text('cant',null,['class' => 'form-control remarcar','v-model' => 'caja.vuelto','autofocus','disabled']) !!}
                    </div>
                </div>
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
                        <tr v-for="row in presupuestosxarticulos">
                            <td>@{{ row.articulo.descripcion }}</td>
                            <td>@{{ row.cantidad }}</td>
                            <td>$@{{ row.precio_unitario }}</td>
                            <td>$@{{ row.subtotal }}</td>
                        </tr>
                    </tbody>
                    <tr v-show="precio_total" style="font-weight: bold; color: black">
                        <td colspan="3" style="text-align: right">Total:</td>
                        <td >$@{{ precio_total }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <a @click="cobrar()" data-toggle="tooltip" data-placement="top" title='Pagar' class="btn btn-primary pull-right" v-show="boton_cobrar">Cobrar</a>
    @include('components.modal',['id' => 1,'accion' => 'Confirmar'])
    @include('components.modal',['id' => 2,'accion' => 'Confirmar'])
    @include('components.modal',['id' => 3,'accion' => 'Confirmar'])

    {{--<pre> @{{ $data | json }}</pre>--}}

@endsection