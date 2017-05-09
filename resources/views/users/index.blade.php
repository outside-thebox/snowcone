@extends('layouts.app')

@section('scripts')

    <script>

        function filtrar() {
            var params = "";

//            if($('input:text[name=nro_cuenta]').val() != "")
//                params += "&like[nro_cuenta]="+ $('input:text[name=nro_cuenta]').val();
//            if($('input:text[name=nombre_cuenta]').val() != "")
//                params += "&like[nombre_cuenta]="+ $('input:text[name=nombre_cuenta]').val();
//            if($('input:text[name=dominio]').val() != "")
//                params += "&like[dominio]="+ $('input:text[name=dominio]').val();

            return params;
        }

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
                token: ''

            },
            methods:{
                buscar: function(url){
//                    var filtro = filtrar();
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
//                            console.log(data.next_page_url);
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

    </script>


@endsection


@section('content')

    <h1 >Usuarios
        <a href="{!! route('users.create')!!}"><button class="btn btn-success pull-right" >Agregar</button></a>
    </h1>

    <div class="form-inline" style="margin-bottom: 10px">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">

        {{ method_field('PUT') }}

        {{ Form::text('nombre',null,['class' => 'form-control','placeholder' => 'Nombre','v-model' => 'user.nombre']) }}

        {{ Form::text('apellido',null,['class' => 'form-control','placeholder' => 'Apellido','v-model' => 'user.apellido']) }}

        {{ Form::text('usuario',null,['class' => 'form-control','placeholder' => 'Usuario','v-model' => 'user.dni']) }}

        {{ Form::button('buscar',['class' => 'btn btn-success', '@click.prevent'=>'buscar()']) }}

    </div>

    @include('components.message-confirmation')

    <div v-show="lista.length > 0">
        {{ Form::button('Primera',['id' => 'first','class' => 'btn btn-success',''=>'', '@click.prevent'=>'buscar(first)']) }}
        {{ Form::button('Anterior',['id' => 'prev','class' => 'btn btn-success', '@click.prevent'=>'buscar(prev)']) }}
        {{ Form::button('Última',['id' => 'last','class' => 'btn btn-success pull-right','style' => 'margin-left: 5px', '@click.prevent'=>'buscar(last)']) }}
        {{ Form::button('Siguiente',['id' => 'next','class' => 'btn btn-success pull-right', '@click.prevent'=>'buscar(next)']) }}
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="table">
            <tr v-for="registro in lista">
                <td>@{{ registro.nombre }}</td>
                <td>@{{ registro.apellido }}</td>
                <td>@{{ registro.dni }}</td>
                <td><a title='Editar' href="{{route('users.index')}}/@{{ registro.id }}/edit"><i class='glyphicon glyphicon-edit' ></i></a></td>
            </tr>
            </tbody>
        </table>
        <label id="pagina_actual" class="pull-right" >@{{ pagina_actual }}</label>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

    {{--<pre> @{{ $data | json }} </pre>--}}



    @include('components.modal',['accion' => 'Desactivar','id' => 1])

    @include('components.modal',['accion' => 'Activar','id' => 2])



@endsection

