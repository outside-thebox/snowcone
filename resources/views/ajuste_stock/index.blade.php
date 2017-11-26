@extends('layouts.app')

@section('scripts')

    <script>
        vm = new Vue({
            el: '#main',
            data:{
                ajuste_stock: {
                    sucursal_id: '',
                    fecha:''
                },
                sucursales: [],
                pagina_actual: 0,
                first: '',
                prev: '',
                next: '',
                last: '',
                lista: [],
                lista_detalle: [],
                busqueda: true,
                token: ''

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
                detalle: function(id)
                {
                    var url = "{{route('ajuste_stock.buscar')}}";

                    $.ajax({
                        url: url,
                        method: 'GET',
                        data: "id="+id,
                        success: function (data) {
                            console.log(data);
                            vm.lista_detalle = data;
                            HoldOn.close();
                        },
                        error: function (respuesta) {
                            HoldOn.close();
                        }
                    });

                    $("#myModalDetalle").modal();
                },
                buscar: function(url){
                    $("#message-confirmation").addClass("hidden");
                    console.log(vm.ajuste_stock);
                    if(url == undefined)
                        var url = "{{route('ajuste_stock.buscar')}}" + "?" + "page=1&sucursal_id="+vm.ajuste_stock.sucursal_id+"&fecha="+this.ajuste_stock.fecha;

                    var ajuste_stock = this.ajuste_stock;
                    ajuste_stock._token = this.token;

                    cargando('sk-circle','Buscando');
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: "json",
                        assync: true,
                        data: ajuste_stock,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            vm.pagina_actual = 'Página '+ data.current_page + ' de '+ data.last_page + '. Cantidad de registros: ' + data.total;
                            vm.lista = data.data;
                            vm.first = "{{route('ajuste_stock.buscar')}}" + "?page=1";
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
                            vm.last = "{{route('ajuste_stock.buscar')}}" + "?page="+data.last_page;
                            HoldOn.close();
                            vm.busqueda = false;
                        },
                        error: function (respuesta) {
                            HoldOn.close();
                        }
                    });
                }
            }
        });

        $(document).ready(function(){

            $("input:text[name=telefono]").mask("00000000000000000000");
            $('[data-toggle="tooltip"]').tooltip();
            vm.cargarSucursales();
            vm.buscar();
        });

    </script>


@endsection

@section('content')
{{--    <pre>@{{ $data | json }}</pre>--}}

    <h1>Ajuste de stock
        @if(in_array(Auth::user()->tipo_usuario_id, array(1,2,3)))
            <a href="{!! route('ajustestock.create')!!}"><button class="btn btn-success pull-right">Agregar</button></a>
        @endif
    </h1>

    <div class="form-inline" style="margin-bottom: 10px">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">

        {{ method_field('PUT') }}

        <select class="form-control" name="sucursal" v-model="ajuste_stock.sucursal_id" >
            <option selected value="" >Sucursales</option>
            <option v-for=" sucursal in sucursales" value="@{{sucursal.id }}" >@{{ sucursal.nombre }}</option>
        </select>

        {{ Form::date('fecha',null,['class' => 'form-control ','placeholder' => 'Fecha','v-model' => 'ajuste_stock.fecha','autofocus']) }}

        {{ Form::button('buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus' ]) }}

    </div>

    @include('components.message-confirmation')

    <div v-show="lista.length > 0">
        @include('components.buttons_paginate')
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Sucursal</th>
                <th>Cod</th>
                <th>Artículo</th>
                <th>Precio de compra</th>
                <th>Precio sugerido</th>
                <th>Stock</th>
                <th>Usuario</th>
            </tr>
            </thead>
            <tbody id="table">
            <tr v-for="registro in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                <td>@{{ registro.created_at }}</td>
                <td>@{{ registro.sucursal.nombre }}</td>
                <td>@{{ registro.cod }}</td>
                <td>@{{ registro.descripcion }}</td>
                <td>$@{{ registro.precio_compra_anterior }} -> $@{{ registro.precio_compra_nuevo }}</td>
                <td>$@{{ registro.precio_sugerido_anterior }} -> $@{{ registro.precio_sugerido_nuevo }}</td>
                <td>@{{ registro.stock_anterior }} -> @{{ registro.stock_nuevo }}</td>
                <td>@{{ registro.user.nombre }} @{{ registro.user.apellido }}</td>
            </tr>
            </tbody>
        </table>
        <label id="pagina_actual" class="pull-right" >@{{ pagina_actual }}</label>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

    <!-- Modal -->
    <div class="modal fade" id="myModalDetalle" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Asiento de compra detalle</h4>
                </div>
                <div class="modal-body">
                    <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
                        <thead>
                        <tr>
                            <th>Cod</th>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>Precio</th>

                        </tr>
                        </thead>
                        <tbody id="table">
                        <tr v-for="registro in lista_detalle" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                            <td>@{{ registro.cod }}</td>
                            <td>@{{ registro.descripcion }}</td>
                            <td>@{{ registro.cantidad }}</td>
                            <td>$ @{{ registro.precio }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>
    @include('components.modal',['accion' => 'Eliminar','id' => 1])

@endsection