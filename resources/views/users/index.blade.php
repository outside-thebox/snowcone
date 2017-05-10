@extends('layouts.app')

@section('scripts')

<<<<<<< HEAD


=======
>>>>>>> e52a4323afbe6d72c0b93368b69650dfb618b2af
    <script>

        vm = new Vue({
            el: '#main',
            data:{
                user : {
                    nombre: '',
                    apellido: '',
                    dni: ''
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
                desactivar: function(id,username)
                {
                    $("#pregunta-1").modal(function(){show:true});

                    $("#contenido-pregunta-1").html("");
                    $("#contenido-pregunta-1").append("<h3>¿Desactivar usuario <strong>"+username+"</strong>?</h2>");
                    $("#pregunta-1").modal(function(){show:true});
                    $("input:hidden[name=id_seleccionado]").val(id);
                },
                activar: function(id,username)
                {
                    $("#pregunta-2").modal(function(){show:true});

                    $("#contenido-pregunta-2").html("");
                    $("#contenido-pregunta-2").append("<h3>¿Activar usuario <strong>"+username+"</strong>?</h2>");
                    $("#pregunta-2").modal(function(){show:true});
                    $("input:hidden[name=id_seleccionado]").val(id);
                },
                reset: function(id,username)
                {
                    $("#pregunta-3").modal(function(){show:true});

                    $("#contenido-pregunta-3").html("");
                    $("#contenido-pregunta-3").append("<h3>¿Reiniciar contraseña de usuario <strong>"+username+"</strong>?</h2>");
                    $("#pregunta-3").modal(function(){show:true});
                    $("input:hidden[name=id_seleccionado]").val(id);

                },
                buscar: function(url){
                    $("#message-confirmation").addClass("hidden");
                    if(url == undefined)
                        var url = "{{route('users.buscar')}}" + "?" + "page=1&nombre="+this.user.nombre+"&apellido="+this.user.apellido+"&dni="+this.user.dni;

                    var user = this.user;
                    user._token = this.token;

                    cargando('sk-circle','Buscando');
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: "json",
                        assync: true,
                        data: user,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            vm.pagina_actual = 'Página '+ data.current_page + ' de '+ data.last_page + '. Cantidad de registros: ' + data.total;
                            vm.lista = data.data;
                            vm.first = "{{route('users.buscar')}}" + "?page=1";
                            vm.next = data.next_page_url;
<<<<<<< HEAD
                            if(data.next_page_url == null)
=======
                            if(data.total <= "{{ env('APP_CANT_PAGINATE',10) }}")
>>>>>>> e52a4323afbe6d72c0b93368b69650dfb618b2af
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
                            vm.last = "{{route('users.buscar')}}" + "?page="+data.last_page;
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
<<<<<<< HEAD

=======
            $('[data-toggle="tooltip"]').tooltip();
>>>>>>> e52a4323afbe6d72c0b93368b69650dfb618b2af

            $("#eliminar-1").click(function(){
                var id = $("input:hidden[name=id_seleccionado]").val();
                var urlDelete = "{{route('users.desactivar')}}";
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
                        location.href = "{{ Route('master',1) }}";

                    }
                });
            });

            $("#eliminar-2").click(function(){
                var id = $("input:hidden[name=id_seleccionado]").val();
                var urlActivate = "{{route('users.activar')}}";
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
                        location.href = "{{ Route('master',1) }}";
                    }
                });
            });

            $("#eliminar-3").click(function(){
                var id = $("input:hidden[name=id_seleccionado]").val();
                var urlActivate = "{{route('users.reset_password')}}";
                var token = $("input:hidden[name=_token]").val();
                cargando("sk-folding-cube",'Guardando...');
                $.ajax({
                    type: "Post",
                    url : urlActivate,
                    data: "id="+id+"&_token="+token,
                    success: function(respuesta)
                    {
                        HoldOn.close();
                        $("#pregunta-3").modal("hide");
                        $("#contenido-modal-3").html("Se ha reiniciado la contraseña del usuario");
                        $("#confirmacion-3").modal(function(){show:true});
                        location.href = "{{ Route('master',1) }}";
                    }
                });
            });

        });

    </script>


@endsection


@section('content')

    <h1 >Usuarios
        <a href="{!! route('users.create')!!}"><button class="btn btn-success pull-right">Agregar</button></a>
    </h1>

    <div class="form-inline" style="margin-bottom: 10px">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
        <input type="hidden" name="id_seleccionado" value="" v-model="id_seleccionado">

        {{ method_field('PUT') }}

        {{ Form::text('nombre',null,['class' => 'form-control','placeholder' => 'Nombre','v-model' => 'user.nombre','autofocus']) }}

        {{ Form::text('apellido',null,['class' => 'form-control','placeholder' => 'Apellido','v-model' => 'user.apellido','autofocus']) }}

        {{ Form::text('usuario',null,['class' => 'form-control','placeholder' => 'Usuario','v-model' => 'user.dni','autofocus']) }}

<<<<<<< HEAD
        {{ Form::button('buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus']) }}
=======
        {{ Form::button('buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus' ]) }}
>>>>>>> e52a4323afbe6d72c0b93368b69650dfb618b2af

    </div>

    @include('components.message-confirmation')

    <div v-show="lista.length > 0">
        {{ Form::button('Primera',['id' => 'first','class' => 'btn btn-warning',''=>'', '@click.prevent'=>'buscar(first)']) }}
        {{ Form::button('Anterior',['id' => 'prev','class' => 'btn btn-warning', '@click.prevent'=>'buscar(prev)']) }}
        {{ Form::button('Última',['id' => 'last','class' => 'btn btn-warning pull-right','style' => 'margin-left: 5px', '@click.prevent'=>'buscar(last)']) }}
        {{ Form::button('Siguiente',['id' => 'next','class' => 'btn btn-warning pull-right', '@click.prevent'=>'buscar(next)']) }}
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="table">
            <tr v-for="registro in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                <td>@{{ registro.nombre }}</td>
                <td>@{{ registro.apellido }}</td>
                <td>@{{ registro.dni }}</td>
                <td v-show="registro.deleted_at">
                    Inactivo
                </td>
                <td v-show="!registro.deleted_at">
                    Activo
                </td>
                <td>
<<<<<<< HEAD
                    <a title='Editar' href="{{route('users.index')}}/@{{ registro.id }}/edit"><i class='glyphicon glyphicon-edit' ></i></a>
                    <a v-show="!registro.deleted_at" title='Desactivar' style="cursor: pointer" @click='desactivar(registro.id,registro.dni)' ><i class='glyphicon glyphicon-trash' ></i></a>
                    <a v-show="registro.deleted_at" title='Activar' style="cursor: pointer" @click='activar(registro.id,registro.dni)' ><i class='glyphicon glyphicon-thumbs-up' ></i></a>
                    <a title='Reiniciar contraseña' style="cursor: pointer" @click='reset(registro.id,registro.dni)' ><i class='glyphicon glyphicon-refresh' ></i></a>
=======
                    <a data-toggle="tooltip" data-placement="top"  title='Editar' href="{{route('users.index')}}/@{{ registro.id }}/edit"><i class='glyphicon glyphicon-edit' ></i></a>

                    <a data-toggle="tooltip" data-placement="top"  v-show="!registro.deleted_at" title='Desactivar' style="cursor: pointer" @click='desactivar(registro.id,registro.dni)' ><i class='glyphicon glyphicon-trash' ></i></a>
                    <a data-toggle="tooltip" data-placement="top"   v-show="registro.deleted_at" title='Activar' style="cursor: pointer" @click='activar(registro.id,registro.dni)' ><i class='glyphicon glyphicon-thumbs-up' ></i></a>
                    <a data-toggle="tooltip" data-placement="top"   title='Reiniciar contraseña' style="cursor: pointer" @click='reset(registro.id,registro.dni)' ><i class='glyphicon glyphicon-refresh' ></i></a>
>>>>>>> e52a4323afbe6d72c0b93368b69650dfb618b2af
                </td>
            </tr>
            </tbody>
        </table>
        <label id="pagina_actual" class="pull-right" >@{{ pagina_actual }}</label>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

    @include('components.modal',['accion' => 'Desactivar','id' => 1])

    @include('components.modal',['accion' => 'Activar','id' => 2])

    @include('components.modal',['accion' => 'Reiniciar contraseña','id' => 3])



@endsection

