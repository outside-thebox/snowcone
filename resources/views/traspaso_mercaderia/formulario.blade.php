@extends('layouts.app')

@section('scripts')
<script>

    var vm = new Vue({
        el: '#main',
        data: {
            sucursales_salida: [],
            sucursales_entrada: [],
            sucursal_salida: '',
            sucursal_entrada: '',
            lista_salida: [],
            lista_entrada: []
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
                            vm.sucursales_salida.push({'id':v.id,'nombre':v.nombre,'ip': v.ip,'conexion': v.conexion});
                        });
                    }
                });
            },
            cargarSucursalesEntrada:function(){

                vm.sucursales_entrada = [];
                $.each(vm.sucursales_salida,function(k,v){
                    if(v.conexion != vm.sucursal_salida)
                        vm.sucursales_entrada.push(v);

                });
            },
            buscar_salida: function(url){


                vm.lista_entrada = [];
                vm.sucursal_entrada = '';
                vm.cargarSucursalesEntrada();

                var url = "{{route('articulos.buscarxstockPrices')}}" + "?"+"stock=true&conexion="+this.sucursal_salida;

                cargando('sk-circle','Buscando');
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: "json",
                    assync: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        vm.lista_salida = data;
                        HoldOn.close();
                    },
                    error: function (respuesta) {
                        HoldOn.close();
                    }
                });
            },
            buscar_entrada: function(url){
                var url = "{{route('articulos.buscarxstockPrices')}}" + "?"+"stock=true&conexion="+this.sucursal_entrada;

                cargando('sk-circle','Buscando');
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: "json",
                    assync: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        vm.lista_entrada = data;
                        HoldOn.close();
                    },
                    error: function (respuesta) {
                        HoldOn.close();
                    }
                });
            }

        }
    });

    $(document).ready(function(){

        vm.cargarSucursales();

    });




</script>





@endsection


@section('content')

    <h1>Traspaso de mercaderia</h1>

    {{--<pre>--}}
    {{--@{{ $data | json }}--}}
    {{--</pre>--}}
    <div class="col-md-12">
        <div class="col-md-6">
            {{ Form::label('sucursal_salida','¿Desde que sucursal?') }}
            <select class="form-control" name="conexion" v-model="sucursal_salida" v-on:change="buscar_salida" >
                <option v-for="sucursal in sucursales_salida" value="@{{ sucursal.conexion }}" >@{{ sucursal.nombre }}</option>
            </select>
            <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
                <thead>
                <tr>
                    <th>Cod</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody id="table_entrada">

                <tr v-for="(index, registro)  in lista_salida" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                    <td>@{{ registro.cod }}</td>
                    <td>@{{ registro.descripcion }}</td>
                    <td v-if="registro.stock != null">
                        @{{ registro.stock }}
                    </td>
                    <td v-else>
                        0
                    </td>
                    <td>
                        <a data-toggle="tooltip" data-placement="top" style="cursor: pointer" title='Actualizar' @click="updateStock(index)"><i class='glyphicon glyphicon-ok' ></i></a>
                    </td>
                </tr>
                </tbody>
            </table>


        </div>


        <div class="col-md-6">
            {{ Form::label('sucursal_entrada','¿Hacia que sucursal?') }}
            <select class="form-control" name="conexion" v-model="sucursal_entrada" v-on:change="buscar_entrada" >
                <option v-for="sucursal in sucursales_entrada" value="@{{ sucursal.conexion }}" >@{{ sucursal.nombre }}</option>
            </select>
            <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
                <thead>
                <tr>
                    <th>Cod</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody id="table_salida">

                <tr v-for="(index, registro)  in lista_entrada" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                    <td>@{{ registro.cod }}</td>
                    <td>@{{ registro.descripcion }}</td>
                    <td v-if="registro.stock != null">
                        @{{ registro.stock }}
                    </td>
                    <td v-else>
                        0
                    </td>
                    <td>
                        <a data-toggle="tooltip" data-placement="top" style="cursor: pointer" title='Actualizar' @click="updateStock(index)"><i class='glyphicon glyphicon-ok' ></i></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


@endsection