@extends('layouts.app')

@section('scripts')

    <script>

        vm = new Vue({
            el: '#main',
            data:{
                user : {
                    id: '',
                    nombre: '',
                    apellido: '',
                    dni: '',
                    password: '',
                    password_confirmation: '',
                    telefono: '',
                    tipo_usuario_id: ''
                },
                tipos_usuarios: [],
                titulo: "{!! $titulo !!}",
                errors: [],
                token: ''

            },
            methods:{
                createUser: function(){
                    cargando("sk-folding-cube",'Guardando...');
                    var user = this.user;
                    user._token = this.token;
                    vm.errors = [];
                    $.ajax({
                        url: "{{ Route('users.store') }}",
                        method: 'POST',
                        data: user,
                        dataType: 'json',
                        success: function (data) {
                            location.href = "{{ Route('master',1) }}";
                        },
                        error: function (jqXHR) {
                            var mensaje = "";
                            $.each(JSON.parse(jqXHR.responseText),function(code,obj){
                                mensaje += "<li>"+obj[0]+"</li><br>";
                            });
                            $("#contenido-modal-1").html(mensaje);
                            $("#confirmacion-1").modal(function(){show:true});
                            HoldOn.close();
                        }
                    });

                },
                cargarTiposUsuarios: function()
                {
                    if(vm.user.tipo_usuario_id == 1)
                        var url = "{{ Route('tipos_usuarios.getTiposUsuariosWithAdmin') }}";
                    else
                        var url = "{{ Route('tipos_usuarios.getTiposUsuariosWithoutAdmin') }}";

                    $.ajax({
                        url: url,
                        method: 'get',
                        dataType: 'json',
                        success: function (data) {
                            $.each(data,function(k,v){
                                vm.tipos_usuarios.push({'id':v.id,'descripcion':v.descripcion});
                            });
                        }
                    });
                },
                cargarDatos: function () {

                    cargando("sk-circle",'Cargando...');
                    $.ajax({
                        url: "{{ Route('users.getDataUser') }}",
                        method: 'get',
                        dataType: 'json',
                        data: "user_id={!! $user_id !!}",
                        success: function (data) {
                            vm.user.id = data.id;
                            vm.user.nombre = data.nombre;
                            vm.user.apellido = data.apellido;
                            vm.user.dni = data.dni;
                            vm.user.telefono = data.telefono;
                            vm.user.tipo_usuario_id = data.tipo_usuario_id;
                            vm.cargarTiposUsuarios();
                            HoldOn.close();
                        }
                    });
                },


            }
        });

        @if($user_id)
            vm.cargarDatos();
        @else
            vm.cargarTiposUsuarios();
        @endif


        $(document).ready(function(){

            $("input:text[name=dni]").mask("00000000");
        });
    </script>

@endsection
@section('content')

    <h1>@{{ titulo }} un usuario</h1>

    <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
    <input type="hidden" name="id" value="" v-model="user.id">

    <div class="col-md-6">
        {!! Field::text('nombre',null,['v-model' => 'user.nombre', 'autofocus', 'required']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('apellido',null,['v-model' => 'user.apellido', 'required']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('dni',null,['v-model' => 'user.dni', 'required','placeholder']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('telefono',null,['v-model' => 'user.telefono']) !!}
    </div>
    <div class="col-md-12 form-group">
        <div class="form-group">
            <label for="tipo_usuario_id" class="control-label">Tipo de usuario</label>

            <select class="form-control" name="tipo_usuario_id" v-model="user.tipo_usuario_id" required="required">
                <option v-for="tipo_usuario in tipos_usuarios" value="@{{ tipo_usuario.id }}" >@{{ tipo_usuario.descripcion }}</option>
            </select>
        </div>
    </div>
    @if(!isset($user_id))
        <div class="col-md-6">
            <label for="password" class="control-label">Password</label>
            {{ Form::password('password',['class' => 'form-control','required','autofocus','v-model' => 'user.password']) }}
        </div>
        <div class="col-md-6">
            <label for="password-confirmation" class="control-label">Repetir Password</label>
            {{ Form::password('password_confirmation',['class' => 'form-control','required','v-model' => 'user.password_confirmation']) }}
        </div>
    @endif

    <div class="col-md-12">
        {!! Form::button("Guardar", ['type' => 'submit', 'class' => 'btn btn-primary pull-right', '@click' => 'createUser()']) !!}
        <a href="{!! route('users.index') !!}" class="btn btn-success pull-right" style="margin-right: 10px">Cancelar</a>
    </div>


    @include('components.modal',['id' => 1,'accion' => 'Guardar'])

    <pre> @{{ $data | json }} </pre>

@endsection


