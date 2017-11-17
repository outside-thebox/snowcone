@extends('layouts.app')

@section('scripts')

<script>
    vm = new Vue({
        el: '#main',
        data:{
            asiento_compra : {
                cod: '',
                descripcion: ''
            },
            pagina_actual: 0,
            first: '',
            prev: '',
            next: '',
            last: '',
            lista: [],
            lista_detalle: [],
            busqueda: true,
            id_seleccionado: 0,
            token: ''

        },
        watch:{
            lista:function(){
                $('[data-toggle="tooltip"]').tooltip();
            }
        },
        methods:{
            detalle: function(id)
            {
                var url = "{{route('asientocompradetalles.buscar')}}";

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
                if(url == undefined)
                    var url = "{{route('asientocompras.buscar')}}" + "?" + "page=1";

                var asiento_compra = this.asiento_compra;
                asiento_compra._token = this.token;

                cargando('sk-circle','Buscando');
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: "json",
                    assync: true,
                    data: asiento_compra,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        vm.pagina_actual = 'Página '+ data.current_page + ' de '+ data.last_page + '. Cantidad de registros: ' + data.total;
                        vm.lista = data.data;
                        vm.first = "{{route('asientocompras.buscar')}}" + "?page=1";
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
                        vm.last = "{{route('asientocompras.buscar')}}" + "?page="+data.last_page;
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

        vm.buscar();
    });

</script>


@endsection

@section('content')

    <h1>Asiento de Compras
        @if(in_array(Auth::user()->tipo_usuario_id, array(1,2,3)))
            <a href="{!! route('asientocompras.create')!!}"><button class="btn btn-success pull-right">Agregar</button></a>
        @endif
    </h1>

    <div class="form-inline" style="margin-bottom: 10px">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
        <input type="hidden" name="id_seleccionado" value="" v-model="id_seleccionado">

        {{ method_field('PUT') }}

        <!--{{ Form::text('cod',null,['class' => 'form-control','placeholder' => 'Cod','v-model' => 'articulo.cod','autofocus']) }}

        {{ Form::text('descripcion',null,['class' => 'form-control','placeholder' => 'Descripcion','v-model' => 'articulo.descripcion','autofocus']) }}

        {{ Form::button('buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus' ]) }}-->

    </div>

    @include('components.message-confirmation')

    <div v-show="lista.length > 0">
        @include('components.buttons_paginate')
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
            <tr>
                <th>Nro asiento</th>
                <th>Proveedor</th>
                <th>Sucursal</th>
                <th>Nro factura</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="table">
            <tr v-for="registro in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                <td>@{{ registro.id }}</td>
                <td>@{{ registro.proveedor.descripcion }}</td>
                <td>@{{ registro.sucursal.nombre }}</td>
                <td>@{{ registro.nro_factura }}</td>
                <td>
                    <a data-toggle="tooltip" data-placement="top"  title='ver' style="cursor: pointer" @click='detalle(registro.id)' ><i class='glyphicon glyphicon-search' ></i></a>
                </td>
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

                        </tr>
                        </thead>
                        <tbody id="table">
                        <tr v-for="registro in lista_detalle" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                            <td>@{{ registro.articulo.cod }}</td>
                            <td>@{{ registro.articulo.descripcion }}</td>
                            <td>@{{ registro.cantidad }}</td>
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