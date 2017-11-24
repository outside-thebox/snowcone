@extends('layouts.app')

@section('scripts')

    <script>

        vm = new Vue({
            el: '#main',
            data:{
                articulo : {
                    cod: '',
                    descripcion: '',
                    proveedor_id:''
                },
                sucursales:[],
                conexion: '',
                proveedores: [],
                pagina_actual: 0,
                first: '',
                prev: '',
                next: '',
                last: '',
                lista: [],
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
                cargarProveedores: function()
                {
                    var url = "{{ Route('proveedores.all') }}";

                    $.ajax({
                        url: url,
                        method: 'get',
                        dataType: 'json',
                        success: function (data) {
                            $.each(data,function(k,v){
                                vm.proveedores.push({'id':v.id,'descripcion':v.descripcion});
                            });
                        }
                    });
                },
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
                updateStock: function(index)
                {
                    var token = $("input:hidden[name=_token]").val(),
                        precio_compra= $("input:text[name='row[" + index + "][precio_compra]']").val(),
                        precio_sugerido= $("input:text[name='row[" + index + "][precio_sugerido]']").val(),
                        id= $("input:hidden[name='row[" + index + "][id]']").val();

                    cargando('sk-circle','Actualizando');
                    $.ajax({
                        url: "{{route('articulosxstock.updatePrices')}}",
                        method: 'POST',
                        data: "id="+id+"&precio_compra="+precio_compra+"&precio_sugerido="+precio_sugerido+"&_token="+token,
                        success: function (data) {
                            HoldOn.close();
                            $("#contenido-modal-1").html("El registro fue actualizado correctamente");
                            $("#confirmacion-1").modal(function(){show:true});
                            return vm.buscar();
                        },
                        error: function (respuesta) {
                            HoldOn.close();
                            $("#contenido-modal-1").html("Se ha producido un error, por favor contacte con el administrador");
                            $("#confirmacion-1").modal(function(){show:true});
                        }
                    });

                },
                updatetodoStock: function()
                {

                    var token = $("input:hidden[name=_token]").val();
                    var datos = $('#frmupprices').serialize();

                    cargando('sk-circle','Actualizando');

                    $.ajax({
                        url: "{{route('articulosxstock.updatetodoPrices')}}",
                        method: 'POST',
                        data: datos+"&_token="+token,
                        success: function (data) {
                            HoldOn.close();
                            $("#contenido-modal-1").html("El registro fue actualizado correctamente");
                            $("#confirmacion-1").modal(function(){show:true});
                            return vm.buscar();
                        },
                        error: function (respuesta) {
                            var mensaje = respuesta.responseJSON.descripcion;
                            $("#contenido-modal-1").html(mensaje);
                            $("#confirmacion-1").modal(function(){show:true});
                            HoldOn.close();
                        }
                    });

                },
                buscar: function(url){
                    $("#message-confirmation").addClass("hidden");

                    if((this.articulo.descripcion.length > 0) || (this.articulo.cod > 0) || (this.articulo.proveedor_id ) )
                        var url = "{{route('articulos.buscarxstockPrices')}}" + "?"+"descripcion="+this.articulo.descripcion+"&cod="+this.articulo.cod+"&proveedor_id="+this.articulo.proveedor_id+"&conexion="+this.conexion;
                    else
                    {
                        $("#contenido-modal-1").html("Complete los parametros de busqueda");
                        $("#confirmacion-1").modal(function(){show:true});

                    }

                    var articulo = this.articulo;
                    articulo._token = this.token;
                    cargando('sk-circle','Buscando');
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: "json",
                        assync: true,
                        data: articulo,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            vm.lista = data;
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

            $(".numeros").mask("000000");
            $(".precios").mask("99999999,99");
            $('[data-toggle="tooltip"]').tooltip();
            vm.cargarProveedores();
            vm.cargarSucursales();

        });

    </script>


@endsection

@section('content')

    <h1>Stock de articulos
        <a href="{!! route('boleta.index')!!}"><button class="btn btn-success pull-right" style="margin-left: 10px">Listado Boletas</button></a>
        <a href="{!! route('articulosxstock.addBoleta')!!}" ><button class="btn btn-success pull-right" >Agregar boleta</button></a>
    </h1>

    <div class="form-inline" style="margin-bottom: 10px">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
        <input type="hidden" name="id_seleccionado" value="" v-model="id_seleccionado">

        {{ method_field('PUT') }}

        {{ Form::text('cod',null,['class' => 'form-control','placeholder' => 'Cod','v-model' => 'articulo.cod','autofocus']) }}

        {{ Form::text('descripcion',null,['class' => 'form-control','placeholder' => 'Descripcion','v-model' => 'articulo.descripcion','autofocus']) }}
        <div class="form-group ">
            <select class="form-control" place name="articulo.proveedor_id" v-model="articulo.proveedor_id" required="required">
                <option value="" selected disabled>Seleccione proveedor</option>
                <option v-for="proveedor in proveedores" value="@{{ proveedor.id }}" >@{{ proveedor.descripcion }}</option>
            </select>
        </div>
{{--        @if($_SERVER['SERVER_ADDR'] == env("IP_SERVER_INTERNET","174.138.57.62"))--}}
        @if(env('APP_SERVER', false))
            <select class="form-control" name="conexion" v-model="conexion" >
                <option v-for="sucursal in sucursales" value="@{{ sucursal.conexion }}" >@{{ sucursal.nombre }}</option>
            </select>
        @endif
        {{ Form::button('buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus' ]) }}

    </div>

    @include('components.message-confirmation')


    <div v-show="lista.length > 0">
        <form name="frmupprices" method="post" id="frmupprices" >
            {!! Form::button("Actualizar Todo", ['type' => 'submit', 'style' => 'margin-bottom: 10px' ,'class' => 'btn btn-primary pull-right','@click.prevent'=>'updatetodoStock()']) !!}
            <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
                <thead>
                <tr>
                    <th>Cod</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Sugerido</th>
                    <th>Stock</th>
                    <th>Proveedor</th>
                    <th>Unidad</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody id="table">

                <tr v-for="(index, registro)  in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                    <input type="hidden" name="row[@{{index}}][id]" value="@{{ registro.id }}" >
                    <td>@{{ registro.cod }}</td>
                    <td>@{{ registro.descripcion }}</td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="fa fa-usd"></span>
                                </span>
                            <input type="text"   name="row[@{{index}}][precio_compra]" value="@{{ registro.precio_compra }}" class="form-control precios" />
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="fa fa-usd"></span>
                                </span>
                            <input type="text"   name="row[@{{index}}][precio_sugerido]" value="@{{ registro.precio_sugerido }}" class="form-control precios" />
                        </div>
                    </td>
                    <td v-if="registro.stock != null">
                        @{{ registro.stock }}
                    </td>
                    <td v-else>
                        0
                    </td>
                    <td>@{{ registro.proveedor }}</td>
                    <td>@{{ registro.unidad_medida }}</td>
                    <td>
                        <a data-toggle="tooltip" data-placement="top" style="cursor: pointer" title='Actualizar' @click="updateStock(index)"><i class='glyphicon glyphicon-ok' ></i></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

    @include('components.modal',['accion' => 'Eliminar','id' => 1])

@endsection