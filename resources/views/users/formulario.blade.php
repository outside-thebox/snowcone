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
                    $(".form-control").removeClass("marcarError");
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
                            vm.errors = [];
                            $.each(jqXHR.responseJSON,function(code,obj){
                                $("#"+code).addClass("marcarError");
                                vm.errors.push({ 'descripcion':  obj });
                                HoldOn.close();
                            });
                        }
                    });

                },
                cargarTiposUsuarios: function()
                {
                    $.ajax({
                        url: "{{ Route('tipos_usuarios.getTiposUsuariosWithoutAdmin') }}",
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
                            vm.user.telefono = data.web;
                            vm.user.tipo_usuario_id = data.tipo_usuario_id;
                            HoldOn.close();
                        }
                    });
                },


            }
        });

        vm.cargarTiposUsuarios();
        @if($user_id)
            vm.cargarDatos();
        @endif

            $(document).ready(function(){

            /*$("#frmUsers").on("submit", function(e){

                e.preventDefault();
                var formData = new FormData(document.getElementById("frmUsers"));
                var destino = "{{ Route('users.store') }}";
                cargando("sk-folding-cube",'Guardando...');
                $.ajax({
                    type: "Post",
                    url: destino,
                    data: formData,
                    assync: true,
                    dataType: "html",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(){
                        location.href = "{{ Route('master',4) }}";
                        HoldOn.close();
                    },
                    error: function(result) {
                        var mensaje = "";
                        $.each(JSON.parse(result.responseText),function(code,obj){
                            mensaje += "<li>"+obj[0]+"</li><br>";
                        });
                        $("#contenido-modal-").html(mensaje);
                        $("#confirmacion-").modal(function(){show:true});
                        HoldOn.close();
                    }


                });


            });*/
        });
    </script>

@endsection
@section('content')

    <h1>@{{ titulo }} un usuario</h1>

    <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
    <input type="hidden" name="id" value="" v-model="user.id">

    <div class="col-md-6">
        {!! Field::text('nombre',null,['v-model' => 'user.nombre']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('apellido',null,['v-model' => 'user.apellido']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('dni',null,['v-model' => 'user.dni']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('telefono',null,['v-model' => 'user.telefono']) !!}
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tipo_usuario_id" class="control-label">Tipo de usuario</label>

            <select class="form-control" name="tipo_usuario_id" v-model="user.tipo_usuario_id_id">
                <option v-for="tipo_usuario in tipos_usuarios" value="@{{ tipo_usuario.id }}" >@{{ tipo_usuario.descripcion }}</option>
            </select>
        </div>
    </div>

    <pre> @{{ $data | json }} </pre>

@endsection


