@extends('layouts.app')

@section('scripts')

    <script>

        vm = new Vue({
            el: '#main',
            data:{
                sucursal : {
                    nombre: '',
                    direccion: ''
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
                desactivar: function(id,name)
                {
                    $("#pregunta-1").modal(function(){show:true});

                    $("#contenido-pregunta-1").html("");
                    $("#contenido-pregunta-1").append("<h3>¿Desactivar sucursal <strong>"+name+"</strong>?</h2>");
                    $("#pregunta-1").modal(function(){show:true});
                    $("input:hidden[name=id_seleccionado]").val(id);
                },
                activar: function(id,name)
                {
                    $("#pregunta-2").modal(function(){show:true});

                    $("#contenido-pregunta-2").html("");
                    $("#contenido-pregunta-2").append("<h3>¿Activar sucursal <strong>"+name+"</strong>?</h2>");
                    $("#pregunta-2").modal(function(){show:true});
                    $("input:hidden[name=id_seleccionado]").val(id);
                },
                buscar: function(url){
                    $("#message-confirmation").addClass("hidden");
                    if(url == undefined)
                        var url = "{{route('sucursales.buscar')}}" + "?" + "page=1&nombre="+this.sucursal.nombre+"&direccion="+this.sucursal.direccion;

                    var sucursal = this.sucursal;
                    sucursal._token = this.token;

                    cargando('sk-circle','Buscando');
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: "json",
                        assync: true,
                        data: sucursal,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            vm.pagina_actual = 'Página '+ data.current_page + ' de '+ data.last_page + '. Cantidad de registros: ' + data.total;
                            vm.lista = data.data;
                            vm.first = "{{route('sucursales.buscar')}}" + "?page=1";
                            vm.next = data.next_page_url;
                            if(data.next_page_url == null)
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

                            vm.prev = data.prev_page_url
                            vm.last = "{{route('sucursales.buscar')}}" + "?page="+data.last_page;
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

            vm.buscar();

            $("#eliminar-1").click(function(){
                var id = $("input:hidden[name=id_seleccionado]").val();
                var urlDelete = "{{route('sucursal.desactivar')}}";
                var token = $("input:hidden[name=_token]").val();
                cargando("sk-folding-cube",'Guardando...');
                $.ajax({
                    type: "Post",
                    url : urlDelete,
                    data: "id="+id+"&_token="+token,
                    success: function(respuesta)
                    {
                        HoldOn.close();
                        $("#pregunta-1").modal("hide");
                        $("#contenido-modal-1").html("Se ha desactivado el usuario");
                        $("#confirmacion-1").modal(function(){show:true});
                        location.href = "{{ Route('master',2) }}";

                    }
                });
            });

            $("#eliminar-2").click(function(){
                var id = $("input:hidden[name=id_seleccionado]").val();
                var urlActivate = "{{route('sucursal.activar')}}";
                var token = $("input:hidden[name=_token]").val();
                cargando("sk-folding-cube",'Guardando...');
                $.ajax({
                    type: "Post",
                    url : urlActivate,
                    data: "id="+id+"&_token="+token,
                    success: function(respuesta)
                    {
                        HoldOn.close();
                        $("#pregunta-2").modal("hide");
                        $("#contenido-modal-2").html("Se ha activado el usuario");
                        $("#confirmacion-2").modal(function(){show:true});
                        location.href = "{{ Route('master',2) }}";
                    }
                });
            });

        });
    </script>


@endsection


@section('content')

    <h1>Sucursales
        <a href="{!! route('sucursales.create')!!}"><button class="btn btn-success pull-right" >Agregar</button></a>
    </h1>
    <div class="form-inline" style="margin-bottom: 10px">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
        <input type="hidden" name="id_seleccionado" value="" v-model="id_seleccionado">

        {{ method_field('PUT') }}

        {{ Form::text('nombre',null,['class' => 'form-control','placeholder' => 'Nombre','v-model' => 'sucursal.nombre','autofocus']) }}

        {{ Form::text('direccion',null,['class' => 'form-control','placeholder' => 'Direccion','v-model' => 'sucursal.direccion','autofocus']) }}

        {{ Form::button('Buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus']) }}

    </div>
    @include('components.message-confirmation')

    <div v-show="lista.length > 0">
        @include('components.buttons_paginate')
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="table">
            <tr v-for="registro in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                <td>@{{ registro.nombre }}</td>
                <td>@{{ registro.direccion }}</td>
                <td>@{{ registro.telefono }}</td>
                <td>@{{ registro.email }}</td>
                <td v-show="registro.deleted_at">
                    Inactivo
                </td>
                <td v-show="!registro.deleted_at">
                    Activo
                </td>
                <td>
                    <a data-toggle="tooltip" data-placement="top" title='Editar' href="{{route('sucursales.index')}}/@{{ registro.id }}/edit"><i class='glyphicon glyphicon-edit' ></i></a>
                    <a data-toggle="tooltip" data-placement="top" v-show="!registro.deleted_at" title='Desactivar' style="cursor: pointer" @click='desactivar(registro.id,registro.nombre)' ><i class='glyphicon glyphicon-trash' ></i></a>
                    <a data-toggle="tooltip" data-placement="top" v-show="registro.deleted_at" title='Activar' style="cursor: pointer" @click='activar(registro.id,registro.nombre)' ><i class='glyphicon glyphicon-thumbs-up' ></i></a>
                </td>
            </tr>
            </tbody>
        </table>
        <label id="pagina_actual" class="pull-right" >@{{ pagina_actual }}</label>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

    @include('components.modal',['accion' => 'Desactivar','id' => 1])

    @include('components.modal',['accion' => 'Activar','id' => 2])



@endsection

