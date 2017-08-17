@extends('layouts.app')

@section('scripts')

    <script>

        vm = new Vue({
            el: '#main',
            data:{
                presupuesto: {
                    cod: '',
                    cliente: '',
                    cant: 1
                },
                pagina_actual: 0,
                first: '',
                prev: '',
                next: '',
                last: '',
                lista: [],
                busqueda: true,
                id_seleccionado: 0,
                token: '',
                lista_presupuesto:[],
                articulo_seleccionado: null,
                lista_ingresados: [],
                error: false,
                error2: false,
                precio_total: 0,
                presupuestos: []

            },
            watch:{
                lista:function(){
                    $('[data-toggle="tooltip"]').tooltip();
                }
            },
            methods:{
                buscar: function(url){
                    if(url == undefined)
                        var url = "{{route('articulos.buscarxstock')}}" + "?" + "page=1&cod="+this.presupuesto.cod;

                    var presupuesto = this.presupuesto;
                    presupuesto._token = this.token;
//                    console.log(presupuesto);

                    cargando('sk-circle','Buscando');
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: "json",
                        assync: true,
                        data: presupuesto+"&ingresados="+vm.lista_ingresados,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            if(data.total == 1)
                            {
                                $("#message-confirmation").addClass("hidden");
                                vm.articulo_seleccionado = data.data[0];
                            }

                            vm.pagina_actual = 'Página '+ data.current_page + ' de '+ data.last_page + '. Cantidad de registros: ' + data.total;
                            vm.lista = data.data;
                            vm.first = "{{route('articulos.buscarxstock')}}" + "?page=1";
                            vm.next = data.next_page_url;
                            if(data.total <= "{{ env('APP_CANT_PAGINATE',10) }}")
                            {
                                $("#next").addClass("hidden");
                                $("#first").addClass("hidden");
                                $("#prev").addClass("hidden");
                                $("#last").addClass("hidden");
                            }
                            else
                            {
                                $("#next").removeClass("hidden");
                                $("#first").removeClass("hidden");
                                $("#prev").removeClass("hidden");
                                $("#last").removeClass("hidden");
                            }

                            vm.prev = data.prev_page_url;
                            vm.last = "{{route('articulos.buscar')}}" + "?page="+data.last_page;
                            HoldOn.close();
                            vm.busqueda = false;
                        },
                        error: function (respuesta) {
                            HoldOn.close();
                        }
                    });
                },
                add: function () {
//                    console.log("hola");
                    vm.error = false;
                    if(vm.articulo_seleccionado.stock < vm.presupuesto.cant)
                    {
//                        $("#contenido-modal-1").html("No hay suficiente stock. Por favor, ingresa una cantidad menor");
//                        $("#confirmacion-1").modal(function(){show:true});
                        document.getElementById("cant").focus();
                        vm.error = true;
                    }
                    else if(vm.presupuesto.cant == 0)
                    {
                        document.getElementById("cant").focus();
                        vm.error2 = true;
                    }

                    else if(vm.articulo_seleccionado != null)
                    {
                        var item = {};

                        vm.lista_ingresados.push(vm.articulo_seleccionado.cod);

                        item.id = vm.articulo_seleccionado.id;
                        item.articulo_id = vm.articulo_seleccionado.articulo_id;
                        item.cod = vm.articulo_seleccionado.cod;
                        item.nombre = vm.articulo_seleccionado.descripcion;
                        item.cantidad = vm.presupuesto.cant;
                        item.precio_unitario = vm.articulo_seleccionado.precio_compra;
                        item.subtotal = (parseFloat(vm.articulo_seleccionado.precio_compra) * parseFloat(vm.presupuesto.cant)).toFixed(2);
                        vm.lista_presupuesto.push(item);
                        vm.precio_total = ((parseFloat(vm.precio_total))+(parseFloat(item.subtotal)));

                        vm.presupuesto.cod = '';
                        vm.presupuesto.cant = 1;
                        $("#cant").val(1);

                        vm.buscar();

                        vm.articulo_seleccionado = null;
//                        vm.presupuesto.cod.focus();
                        document.getElementById("cod").focus();
                    }
                },
                eliminar: function(item)
                {
                    vm.lista_ingresados.$remove(item.cod);
                    vm.lista_presupuesto.$remove(item);
                    vm.precio_total = ((parseFloat(vm.precio_total))-(parseFloat(item.subtotal)));
                    vm.buscar();

                },
                traerPresupuestos: function()
                {
                    $.ajax({
                        url: "{{ Route('presupuesto.buscar') }}",
                        data: '_token='+this.token,
                        method: 'POST',
                        dataType: "json",
                        success: function (data) {
                            vm.presupuestos = data;
                        },
                        error: function(respuesta)
                        {
                            $("#confirmacion-1").modal(function(){show:true});

                        }

                    });
                },
                imprimir: function()
                {

                    var lista_presupuesto = this.lista_presupuesto;
                    lista_presupuesto._token = this.token;
                    cargando('sk-circle','Imprimiendo');
                    $.ajax({
                        url: "{{ Route('presupuesto.store') }}",
                        method: 'POST',
                        data: "cliente="+vm.presupuesto.cliente+"&precio_total="+vm.precio_total+"&_token="+this.token+"&lista="+JSON.stringify(lista_presupuesto),
                        dataType: "json",
                        success: function (data) {
//                            console.log(data.id);
                            var win = window.open("{{ Route('presupuesto.index') }}/exportarPDF/"+data.id, '_blank');
                            win.print();
                            location.href = "{{ Route('master',4) }}";

                        },
                        error: function(respuesta)
                        {
                            $("#contenido-modal-1").html("No hay stock suficiente para el artículo " + respuesta.responseJSON.descripcion);
                            $("#confirmacion-1").modal(function(){show:true});

                        }

                    });

                }
            }
        });

        $(document).ready(function(){

            $('[data-toggle="tooltip"]').tooltip();

            $("input:text[name=cod]").mask("9999");
            $("input:text[name=cant]").mask("999");

            vm.buscar();

            vm.traerPresupuestos();



        });

    </script>


@endsection



@section('content')

    <h1>Presupuesto</h1>

    @include('components.message-confirmation')

    <div class="row">
        <div class="col-md-6">
            {!! Form::label('cliente','Cliente',['class' => 'campos_resaltados']) !!}
            {!! Form::text('cliente',null,['class' => 'form-control','v-model' => 'presupuesto.cliente','autofocus']) !!}
        </div>
    </div>
    <div class="form-inline" style="margin-bottom: 10px; margin-top: 10px">
        <div class="col-md-6">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
            <input type="hidden" name="id_seleccionado" value="" v-model="id_seleccionado">

            {{ method_field('PUT') }}

            {!! Form::label('cod','Articulo: ',['class' => 'campos_resaltados']) !!}
            {!! Form::text('cod',null,['class' => 'form-control','v-model' => 'presupuesto.cod','autofocus','@keyup' => 'buscar()','id' => 'cod']) !!}

            {!! Form::label('cant','Cantidad',['class' => 'campos_resaltados']) !!}
            {!! Form::text('cant',null,['class' => 'form-control','v-model' => 'presupuesto.cant','autofocus','v-on:keyup.enter'=>"add",'id' => 'cant']) !!}

            <label class="error" v-show="error">No hay suficiente stock, por favor, ingresa una cantidad menor</label>
            <label class="error" v-show="error2">La cantidad debe ser mayor a cero</label>

            <div v-show="lista.length > 0" style="margin-top: 10px">
                @include('components.buttons_paginate')
                <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
                    <thead>
                    <tr>
                        <th>Cod</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Sugerido</th>
                        <th>Stock</th>
                    </tr>
                    </thead>
                    <tbody id="table">
                    <tr v-for="registro in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                        <td>@{{ registro.cod }}</td>
                        <td>@{{ registro.descripcion }}</td>
                        <td>$@{{ registro.precio_compra }}</td>
                        <td>$@{{ registro.precio_sugerido }}</td>
                        <td>@{{ registro.stock }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>
        </div>
        <div class="col-md-6">
            <label class="campos_resaltados">Presupuesto para: @{{ presupuesto.cliente }}</label>
            <div>
                <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
                    <thead>
                    <tr>
                        <th>Cod</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Unitario</th>
                        <th>Subtotal</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody id="table">
                    <tr v-for="registro in lista_presupuesto">
                        <td>@{{ registro.cod }}</td>
                        <td>@{{ registro.nombre }}</td>
                        <td>@{{ registro.cantidad }}</td>
                        <td>$@{{ registro.precio_unitario }}</td>
                        <td>$@{{ registro.subtotal }}</td>
                        <td>
                            <a data-toggle="tooltip" data-placement="top"  title='Eliminar' style="cursor: pointer" @click='eliminar(registro)' ><i class='glyphicon glyphicon-remove' ></i></a>
                        </td>
                    </tr>
                    <tr v-show="precio_total" style="font-weight: bold; color: black">
                        <td colspan="4" style="text-align: right">Total:</td>
                        <td >$@{{ precio_total }}</td>
                        <td>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <a href="#" data-toggle="tooltip" data-placement="top"  title='Para poder imprimir, ingresa el nombre del cliente y al menos un registro a la venta' class="btn btn-primary pull-right" :disabled="lista_presupuesto.length == 0 || presupuesto.cliente == ''" v-show="lista_presupuesto.length == 0 || presupuesto.cliente == ''">Imprimir</a>
            <a @click="imprimir()" data-toggle="tooltip" data-placement="top"  title='' class="btn btn-primary pull-right" v-show="lista_presupuesto.length > 0 && presupuesto.cliente != ''">Imprimir</a>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
            <tr>
                <th colspan="6" style="text-align: center">Últimos presupuestos</th>
            </tr>
            <tr>
                <th>Cliente</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody id="table">
            <tr v-for="presupuesto in presupuestos">
                <td>@{{ presupuesto.cliente }}</td>
                <td>$@{{ presupuesto.precio_total }}</td>
                <td>@{{ presupuesto.created_at }}</td>
                <td>
                    <span class="label label-danger" v-if="presupuesto.estado_id == 1">@{{ presupuesto.estado.descripcion }}</span>
                    <span class="label label-success" v-if="presupuesto.estado_id == 2">@{{ presupuesto.estado.descripcion }}</span>
                </td>
                <td>
                    <a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Imprimir' href="{{ Route('presupuesto.index') }}/exportarPDF/@{{ presupuesto.id }}"><i class='glyphicon glyphicon-print' ></i></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    {{--<pre>@{{ $data | json }}</pre>--}}

    @include('components.modal',['accion' => 'Eliminar','id' => 1])

@endsection