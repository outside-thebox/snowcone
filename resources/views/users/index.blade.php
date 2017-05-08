@extends('layouts.app')

@section('scripts')

    <script>

        function desactivar(id,username)
        {
            $("#pregunta-1").modal(function(){show:true});

            $("#contenido-pregunta-1").html("");
            $("#contenido-pregunta-1").append("<h3>¿Desactivar usuario <strong>"+username+"</strong>?</h2>");
            $("#pregunta-1").modal(function(){show:true});
            $("#id_seleccionado").val(id);
        }

        function activar(id,username)
        {
            $("#pregunta-2").modal(function(){show:true});

            $("#contenido-pregunta-2").html("");
            $("#contenido-pregunta-2").append("<h3>¿Activar usuario <strong>"+username+"</strong>?</h2>");
            $("#pregunta-2").modal(function(){show:true});
            $("#id_seleccionado").val(id);
        }

        $(document).ready(function(){


            cargando("sk-folding-cube",'');

            HoldOn.close();

            /*$("input:text[name=telefono]").mask("00000000000000000000");


            $("#eliminar-1").click(function(){
                var id = $("#id_seleccionado").val();
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
                        location.href = "{{ Route('master',4) }}";

                    }
                });
            });

            $("#eliminar-2").click(function(){
                var id = $("#id_seleccionado").val();
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
                        location.href = "{{ Route('master',4) }}";
                    }
                });
            });*/

        });

    </script>


@endsection


@section('content')

    <h1>Usuarios
        <a href="{!! route('users.create')!!}"><button class="btn btn-success pull-right" >Agregar</button></a>
    </h1>

    @include('components.message-confirmation')


    <table class="table responsive table-bordered table-hover table-striped" >
        <thead>
        <tr>
            <th>Usuario</th>
        </tr>
        </thead>
        <tbody id="table">
        <tr>
        <th><i class='glyphicon glyphicon-remove' ></th>
        </tr>
        </tbody>
    </table>

    @include('components.modal',['accion' => 'Desactivar','id' => 1])

    @include('components.modal',['accion' => 'Activar','id' => 2])



@endsection

