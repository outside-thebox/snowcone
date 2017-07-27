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
                eliminar: function(id,descripcion)
                {
                    $("#pregunta-1").modal(function(){show:true});

                    $("#contenido-pregunta-1").html("");
                    $("#contenido-pregunta-1").append("<h3>¿Eliminar artículo <strong>"+descripcion+"</strong>?</h2>");
                    $("#pregunta-1").modal(function(){show:true});
                    $("input:hidden[name=id_seleccionado]").val(id);
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

    <h1>Stock de articulos</h1>

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
                <th>Unidad de medida</th>
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
                <td>@{{ registro.unidad_medida.descripcion }}</td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-usd"></span>
                            </span>
                        <input type="text" value="@{{ registro.precio_compra }}" class="form-control numeros" />
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-usd"></span>
                            </span>
                        <input type="text" value="@{{ registro.precio_sugerido }}" class="form-control numeros" />
                    </div>
                </td>
                <td v-if="registro.stock != null">
                    <input type="text" value="@{{ registro.stock }}" class="form-control numeros" />
                </td>
                <td v-else>
                    <input type="text" value="0" class="form-control numeros" />
                </td>
                <td>@{{ registro.proveedor.descripcion }}</td>
                <td>@{{ registro.unidad_medida.descripcion }}</td>
                <td>
                    <a data-toggle="tooltip" data-placement="top"  title='Actualizar' href="{{route('articulos.index')}}/@{{ registro.id }}/edit"><i class='glyphicon glyphicon-refresh' ></i></a>
                </td>
            </tr>
            </tbody>
        </table>
        <label id="pagina_actual" class="pull-right" >@{{ pagina_actual }}</label>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

    @include('components.modal',['accion' => 'Eliminar','id' => 1])

@endsection