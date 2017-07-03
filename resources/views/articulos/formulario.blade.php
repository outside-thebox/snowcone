@extends('layouts.app')

@section('scripts')
<script>

    vm = new Vue({
        el: '#main',
        data:{
            articulo: {
                id: '',
                cod: '',
                descripcion: '',
                unidad_medida_id: '',
                precio_sugerido: '',
                precio_compra: '',
                fecha_ultima_compra: ''
            },
            unidades_medida: [],
            proveedores: [],
            titulo: "{!! $titulo !!}",
            errors: [],
            token: ''

        },
        methods:{
            cargarUnidadesMedida: function()
            {
                var url = "{{ Route('unidades_medida.all') }}";

                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function (data) {
                        $.each(data,function(k,v){
                            vm.unidades_medida.push({'id':v.id,'descripcion':v.descripcion});
                        });
                    }
                });
            },
            cargarProveedores: function()
            {
                var url = "{{ Route('proveedores.all') }}";

                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function (data) {
                        $.each(data,function(k,v){
                            vm.proveedores.push({'id':v.id,'descripcion':v.descripcion});
                        });
                    }
                });
            },
            save:function()
            {
                cargando("sk-folding-cube",'Guardando...');
                var articulo = this.articulo;
                articulo._token = this.token;
                vm.errors = [];
                $.ajax({
                    url: "{{ Route('articulos.store') }}",
                    method: 'POST',
                    data: articulo,
                    dataType: 'json',
                    success: function (data) {
                        location.href = "{{ Route('master',3) }}";
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
            cargarDatos: function()
            {
                cargando("sk-circle",'Cargando...');
                $.ajax({
                    url: "{{ Route('articulos.getDataArticulo') }}",
                    method: 'get',
                    dataType: 'json',
                    data: "articulo_id={!! $articulo_id !!}",
                    success: function (data) {
                        vm.articulo = data;
                        HoldOn.close();
                    }
                });
            }
        }
    });

    @if($articulo_id)
        vm.cargarDatos();
    @endif

    vm.cargarUnidadesMedida();
    vm.cargarProveedores();

    $(document).ready(function(){

        $("input:text[name=cod]").mask("0000");
    });

</script>
@endsection

@section('content')

    <h1>@{{ titulo }} un artículo</h1>

    <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
    <input type="hidden" name="id" value="" v-model="articulo.id">

    <div class="col-md-6">
        {!! Field::text('cod',null,['v-model' => 'articulo.cod', 'autofocus', 'required']) !!}
    </div>

    <div class="col-md-6">
        {!! Field::text('descripcion',null,['v-model' => 'articulo.descripcion', 'autofocus', 'required']) !!}
    </div>

    <div class="col-md-6">
        {!! Form::label('precio_sugerido','Precio sugerido') !!}
        <span class="label label-info">Required</span>

        <div class="input-group">
                <span class="input-group-addon">
                    <span class="fa fa-usd"></span>
                </span>
            {!! Form::text('precio_sugerido',null,['class' => 'form-control','v-model' => 'articulo.precio_sugerido']) !!}
        </div>
    </div>

    <div class="col-md-6">
        {!! Form::label('precio_compra','Precio de compra') !!}
        <span class="label label-info">Required</span>

        <div class="input-group">
                <span class="input-group-addon">
                    <span class="fa fa-usd"></span>
                </span>
            {!! Form::text('precio_compra',null,['class' => 'form-control','v-model' => 'articulo.precio_compra']) !!}
        </div>
    </div>

    <div class="col-md-6 form-group" style="margin-top: 10px">
        <div class="form-group">
            <label for="unidad_medida_id" class="control-label">Unidad de medida</label>
            <span class="label label-info">Required</span>
            <select class="form-control" name="unidad_medida_id" v-model="articulo.unidad_medida_id" required="required">
                <option v-for="unidad_medida in unidades_medida" value="@{{ unidad_medida.id }}" >@{{ unidad_medida.descripcion }}</option>
            </select>
        </div>
    </div>

    <div class="col-md-6 form-group" style="margin-top: 10px">
        <div class="form-group">
            <label for="proveedor_id" class="control-label">Proveedor</label>
            <span class="label label-info">Required</span>
            <select class="form-control" name="proveedor_id" v-model="articulo.proveedor_id" required="required">
                <option v-for="proveedor in proveedores" value="@{{ proveedor.id }}" >@{{ proveedor.descripcion }}</option>
            </select>
        </div>
    </div>

    <div class="col-md-12" style="margin-top: 10px">
        {!! Form::button("Guardar", ['type' => 'submit', 'class' => 'btn btn-primary pull-right', '@click' => 'save()']) !!}
        <a href="{!! route('articulos.index') !!}" class="btn btn-danger pull-right" style="margin-right: 10px">Cancelar</a>
    </div>


    @include('components.modal',['id' => 1,'accion' => 'Guardar'])

@endsection