@extends('layouts.app')

@section('scripts')

    <script>

        vm = new Vue({
            el: '#main',
            data:{
                sucursal : {
                    id: '',
                    nombre: '',
                    direccion: '',
                    telefono: '',
                    email: ''
                },
                titulo: "{!! $titulo !!}",
                errors: []
            },
            methods:{
                createSucursal: function(){
                    cargando("sk-folding-cube",'Guardando...');
                    console.log(this.sucursal);
                    var sucursal = this.sucursal;
                    sucursal._token = this.token;
                    vm.errors = [];
                    $.ajax({
                        url: "{{ Route('sucursales.store') }}",
                        method: 'POST',
                        data: sucursal,
                        dataType: 'json',
                        success: function (data) {
                            location.href = "{{ Route('master',2) }}";
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
            }
        });
        $(document).ready(function(){
        });
    </script>

@endsection
@section('content')

    <h1>@{{ titulo }} sucursal</h1>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
    <input type="hidden" name="id" value="" v-model="sucursales.id">

    <div class="col-md-6">
        {!! Field::text('nombre',null,['v-model' => 'sucursal.nombre', 'autofocus', 'required']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('direccion',null,['v-model' => 'sucursal.direccion', 'required']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('telefono',null,['v-model' => 'sucursal.telefono', 'required']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('email','',['v-model' => 'sucursal.email']) !!}
    </div>

    <div class="col-md-12">
        {!! Form::button("Guardar", ['type' => 'submit', 'class' => 'btn btn-primary pull-right', '@click' => 'createSucursal()']) !!}
        <a href="{!! route('sucursales.index') !!}" class="btn btn-success pull-right" style="margin-right: 10px">Cancelar</a>
    </div>


    @include('components.modal',['id' => 1,'accion' => 'Guardar'])

    <pre> @{{ $data | json }} </pre>

@endsection


