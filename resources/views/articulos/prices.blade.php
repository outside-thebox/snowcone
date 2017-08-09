@extends('layouts.app')

@section('scripts')

    <script>

        vm = new Vue({
            el: '#main',
            data:{
                articulo : {
                    cod: '',
                    descripcion: ''
                },
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
                updateStock: function(id)
                {
                    var precio_compra = $("input:text[name=precio_compra_"+id+"]").val();
                    var precio_sugerido = $("input:text[name=precio_sugerido_"+id+"]").val();
                    var token = $("input:hidden[name=_token]").val();

                    cargando('sk-falding-circle"','Actualizando');
                    $.ajax({
                        url: "{{route('articulosxstock.updatePrices')}}",
                        method: 'POST',
                        data: "id="+id+"&precio_compra="+precio_compra+"&precio_sugerido="+precio_sugerido+"&_token="+token,
                        success: function (data) {
                            HoldOn.close();
                            $("#contenido-modal-1").html("El registro fue actualizado correctamente");
                            $("#confirmacion-1").modal(function(){show:true});
                        },
                        error: function (respuesta) {
                            HoldOn.close();
                            $("#contenido-modal-1").html("Se ha producido un error, por favor contacte con el administrador");
                            $("#confirmacion-1").modal(function(){show:true});
                        }
                    });

                },
                buscar: function(url){
                    $("#message-confirmation").addClass("hidden");
                    if(url == undefined)
                        var url = "{{route('articulos.buscarxstock')}}" + "?" + "page=1&descripcion="+this.articulo.descripcion+"&cod="+this.articulo.cod;

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
                            vm.last = "{{route('articulos.buscarxstock')}}" + "?page="+data.last_page;
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
            $('[data-toggle="tooltip"]').tooltip();

            vm.buscar();

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

        {{ Form::button('buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus' ]) }}

    </div>

    @include('components.message-confirmation')

    <div v-show="lista.length > 0">
        @include('components.buttons_paginate')
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
            <tr v-for="registro in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                <td>@{{ registro.cod }}</td>
                <td>@{{ registro.descripcion }}</td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-usd"></span>
                            </span>
                        <input type="text" name="precio_compra_@{{ registro.id }}" value="@{{ registro.precio_compra }}" class="form-control" />
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-usd"></span>
                            </span>
                        <input type="text" name="precio_sugerido_@{{ registro.id }}" value="@{{ registro.precio_sugerido }}" class="form-control" />
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
                    <a data-toggle="tooltip" data-placement="top" style="cursor: pointer" title='Actualizar' @click="updateStock(registro.id)"><i class='glyphicon glyphicon-ok' ></i></a>
                </td>
            </tr>
            </tbody>
        </table>
        <label id="pagina_actual" class="pull-right" >@{{ pagina_actual }}</label>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

    @include('components.modal',['accion' => 'Eliminar','id' => 1])

@endsection