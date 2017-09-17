<script>

    function cancelarPresupuesto(redireccion)
    {
        var id = $("input:hidden[name=id_seleccionado]").val();
        var urlDelete = "{{route('presupuesto.cancelar')}}";
        var token = $("input:hidden[name=_token]").val();
        cargando("sk-folding-cube",'Cancelando presupuesto...');
        $.ajax({
            type: "Post",
            url : urlDelete,
            data: "id="+id+"&_token="+token,
            success: function(respuesta)
            {
                HoldOn.close();
                $("#pregunta-1").modal("hide");
                $("#contenido-modal-1").html("Se ha cancelado el presupuesto");
                $("#confirmacion-1").modal(function(){show:true});
                if(redireccion == 6)
                    location.href = "{{ Route('master',6) }}";
                else
                    location.href = "{{ Route('master',7) }}";

            }
        });
    }

    function anularPresupuesto(redireccion)
    {
        var id = $("input:hidden[name=id_seleccionado]").val();
        var urlDelete = "{{route('presupuesto.anular')}}";
        var token = $("input:hidden[name=_token]").val();
        cargando("sk-folding-cube",'Anulando presupuesto...');
        $.ajax({
            type: "Post",
            url : urlDelete,
            data: "id="+id+"&_token="+token,
            success: function(respuesta)
            {
                HoldOn.close();
                $("#pregunta-1").modal("hide");
                $("#contenido-modal-1").html("Se ha anulado el presupuesto");
                $("#confirmacion-1").modal(function(){show:true});
                if(redireccion == 6)
                    location.href = "{{ Route('master',6) }}";
                else
                    location.href = "{{ Route('master',7) }}";

            }
        });
    }

</script>