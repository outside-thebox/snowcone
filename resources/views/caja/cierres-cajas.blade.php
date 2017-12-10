@extends('layouts.app')

@section('scripts')

    <script>

        vm = new Vue({
            el: '#main',
            data:{
                pagina_actual: 0,
                sucursales: [],
                first: '',
                prev: '',
                next: '',
                last: '',
                lista: [],
                busqueda: true,
                token: '',
                sucursal: '',
                fecha: ''

            },
            watch:{
                lista:function(){
                    $('[data-toggle="tooltip"]').tooltip();
                }
            },
            methods:{
                cargarSucursales: function()
                {
                    var url = "{{ Route('sucursales.all') }}";

                    $.ajax({
                        url: url,
                        method: 'get',
                        dataType: 'json',
                        success: function (data) {
                            $.each(data,function(k,v){
                                vm.sucursales.push({'id':v.id,'nombre':v.nombre,'ip': v.ip,'conexion': v.conexion});
                            });
                        }
                    });
                },

                buscar: function(url){

                    if(url == undefined)
                        var url = "{{route('caja.all')}}" + "?" + "page=1&conexion="+vm.sucursal+"&fecha="+vm.fecha;

                    cargando('sk-circle','Buscando');
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: "json",
                        assync: true,
                        data: "_token="+this.token,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
//                            console.log(data);
                            vm.pagina_actual = 'Página '+ data.current_page + ' de '+ data.last_page + '. Cantidad de registros: ' + data.total;
                            vm.lista = data.data;
                            vm.first = "{{route('caja.all')}}" + "?page=1&conexion="+vm.sucursal+"&fecha="+vm.fecha;
                            console.log(vm.sucursal);
                            vm.next = data.next_page_url+"&conexion="+vm.sucursal+"&fecha="+vm.fecha;
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

                            $.each(vm.lista, function(index,value) {

                                value.precio_total = 0;
                                $.each(value.presupuesto, function(index,presupuesto) {
                                    if(presupuesto.estado_id == 2)
                                        value.precio_total = parseFloat(value.precio_total) + parseFloat(presupuesto.precio_total);
//                                    console.log(value);
                                });
                            });


                            vm.prev = data.prev_page_url+"&conexion="+vm.sucursal+"&fecha="+vm.fecha;
                            vm.last = "{{route('caja.all')}}" + "?page="+data.last_page+"&conexion="+vm.sucursal+"&fecha="+vm.fecha;
                            HoldOn.close();
                            vm.busqueda = false;
                        },
                        error: function (respuesta) {
                        }
                    });
//                    HoldOn.close();
                }
            }
        });

        $(document).ready(function(){
            vm.cargarSucursales();

        });

    </script>


@endsection

@section('content')

    <h1>Listado de cierre de cajas</h1>

    <div class="form-inline" style="margin-bottom: 10px">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">

        {{ method_field('PUT') }}

        <select class="form-control" name="sucursal" v-model="sucursal" >
            <option selected value="" >Sucursales</option>
            <option v-for=" sucursal in sucursales" value="@{{sucursal.conexion }}" >@{{ sucursal.nombre }}</option>
        </select>

        {{ Form::date('fecha',null,['class' => 'form-control ','placeholder' => 'Fecha','v-model' => 'fecha','autofocus']) }}

        {{ Form::button('buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus' ]) }}

    </div>

    <div v-show="lista.length > 0">
        @include('components.buttons_paginate')
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
            <tr>
                <th>Nro de cierre</th>
                <th>Usuario</th>
                <th>Momento de cierre</th>
                <th>Total</th>
                <th>Imprimir</th>
            </tr>
            </thead>
            <tbody id="table">
            <tr v-for="registro in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                <td>@{{ registro.id }}</td>
                <td>@{{ registro.user.nombre }} @{{ registro.user.apellido }}</td>
                <td>@{{ registro.created_at }}</td>
                <td>$@{{ registro.precio_total }}</td>
                <td><a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Imprimir' href="{{ Route('caja.index')}}/exportarPDF/@{{ registro.id }}/@{{ registro.sucursal_id }}"><i class='glyphicon glyphicon-print' ></i></a>
                </td>
            </tr>
            </tbody>
        </table>
        <label id="pagina_actual" class="pull-right" >@{{ pagina_actual }}</label>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>
@endsection