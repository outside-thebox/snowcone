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
                articulo_seleccionado: null

            },
            watch:{
                lista:function(){
                    $('[data-toggle="tooltip"]').tooltip();
                }
            },
            methods:{
                buscar: function(url){
                    $("#message-confirmation").addClass("hidden");
                    if(url == undefined)
                        var url = "{{route('articulos.buscar')}}" + "?" + "page=1&cod="+this.presupuesto.cod;

                    var presupuesto = this.presupuesto;
                    presupuesto._token = this.token;
//                    console.log(presupuesto);

                    cargando('sk-circle','Buscando');
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: "json",
                        assync: true,
                        data: presupuesto,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            if(data.total == 1)
                            {
                                vm.articulo_seleccionado = data.data[0];
                            }

                            console.log(vm.articulo_seleccionado);

                            vm.pagina_actual = 'Página '+ data.current_page + ' de '+ data.last_page + '. Cantidad de registros: ' + data.total;
                            vm.lista = data.data;
                            vm.first = "{{route('articulos.buscar')}}" + "?page=1";
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
                    var item = {};

                    if(vm.articulo_seleccionado != null)
                    {
                        item.cod = vm.articulo_seleccionado.cod;
                        item.nombre = vm.articulo_seleccionado.descripcion;
                        item.cantidad = vm.presupuesto.cant;
                        item.precio_unitario = vm.articulo_seleccionado.precio_sugerido;
                        item.subtotal = (parseFloat(vm.articulo_seleccionado.precio_sugerido) * parseFloat(vm.presupuesto.cant));
                        vm.lista_presupuesto.push(item);


                        vm.presupuesto.cod = '';
                        vm.presupuesto.cant = 1;

                        vm.buscar();
                        vm.articulo_seleccionado = null;
//                        console.log(vm.presupuesto.cod.focus());
//                        vm.presupuesto.cod.focus();
                        document.getElementById("cod").focus();
                    }
                },
                eliminar: function(item)
                {
                    vm.lista_presupuesto.$remove(item);

                }
            }
        });

        $(document).ready(function(){

            $('[data-toggle="tooltip"]').tooltip();

            $("input:text[name=cod]").mask("9999");
            $("input:text[name=cant]").mask("999");

            vm.buscar();



        });

    </script>


@endsection



@section('content')
    <h1>Presupuesto</h1>


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
            {!! Form::text('cant',null,['class' => 'form-control','v-model' => 'presupuesto.cant','autofocus','v-on:keyup.enter'=>"add"]) !!}
            <div v-show="lista.length > 0" style="margin-top: 10px">
                @include('components.buttons_paginate')
                <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
                    <thead>
                    <tr>
                        <th>Cod</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Sugerido</th>
                    </tr>
                    </thead>
                    <tbody id="table">
                    <tr v-for="registro in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                        <td>@{{ registro.cod }}</td>
                        <td>@{{ registro.descripcion }}</td>
                        <td>$@{{ registro.precio_compra }}</td>
                        <td>$@{{ registro.precio_sugerido }}</td>
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
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Unitario</th>
                        <th>Subtotal</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody id="table">
                    <tr v-for="registro in lista_presupuesto">
                        <td>@{{ registro.nombre }}</td>
                        <td>@{{ registro.cantidad }}</td>
                        <td>$@{{ registro.precio_unitario }}</td>
                        <td>$@{{ registro.subtotal }}</td>
                        <td>
                            <a data-toggle="tooltip" data-placement="top"  title='Eliminar' style="cursor: pointer" @click='eliminar(registro)' ><i class='glyphicon glyphicon-remove' ></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{--<pre>@{{ $data | json }}</pre>--}}

    @include('components.modal',['accion' => 'Eliminar','id' => 1])

@endsection