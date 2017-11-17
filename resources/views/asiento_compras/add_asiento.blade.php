@extends('layouts.app')

@section('scripts')
    <script>
        vm = new Vue({
            el: '#main',
            data:{
                form : {
                    proveedor_id:'',
                    sucursal_conexion:'',
                    sucursal_id:'',
                    nro_factura:''
                },
                proveedores: [],
                sucursales: [],
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
                cargarSucursales: function()
                {
                    var url = "{{ Route('sucursales.all') }}";
                    $.ajax({
                        url: url,
                        method: 'get',
                        dataType: 'json',
                        success: function (data) {
                            $.each(data,function(k,v){
                                vm.sucursales.push({'id':v.id,'nombre':v.nombre,'ip': v.ip,'conexion': v.conexion});
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

                guardarAsientocompra: function(){

                    var token = $("input:hidden[name=_token]").val();
                    var datos = $('#frmaddasietocompra').serialize();

                    cargando('sk-circle','Actualizando');
                    $.ajax({
                        url: "{{route('asientocompras.store')}}",
                        method: 'POST',
                        data: datos+"&_token="+token,
                        success: function (data) {
                            HoldOn.close();
                            location.href = "{{ Route('master',8) }}";
                        },
                        error: function () { vm.busqueda = false;
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
                buscar: function(url){

                    $("#message-confirmation").addClass("hidden");
                    if((this.form.proveedor_id)&&(this.form.sucursal))
                    {
                        this.form.sucursal_conexion = vm.sucursales[this.form.sucursal].conexion;
                        this.form.sucursal_id = vm.sucursales[this.form.sucursal].id;
                        var url = "{{route('articulos.buscarxstockall')}}" + "?" + "proveedor_id=" + this.form.proveedor_id + "&conexion=" + this.form.sucursal_conexion;
                    }
                    else
                    {
                        $("#contenido-modal-1").html("Complete los parametros de busqueda");
                        $("#confirmacion-1").modal(function(){show:true});
                    }

                    var form = this.form;
                    form._token = this.token;

                    cargando('sk-circle','Buscando');
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: "json",
                        assync: true,
                        data: form,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data)
                        {

                            vm.lista = data;
                            $('#btntodo').show();
                            HoldOn.close();
                            vm.busqueda = false;
                        },
                        error: function (respuesta) {
                            vm.lista = [];
                            HoldOn.close();
                        }
                    });
                }
            }
        });

        $(document).ready(function(){

            $(".numeros").mask("000000");
            $('[data-toggle="tooltip"]').tooltip();
            vm.cargarSucursales();
            vm.cargarProveedores();
        });
    </script>

@endsection
@section('content')

    <h1>Agregar Asiento de Compras</h1>
    <div class="row">
        <div class="form-inline col-md-6" style="margin-bottom: 10px">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
            <input type="hidden" name="id_seleccionado" value="" v-model="id_seleccionado">

            {{ method_field('PUT') }}

            <div class="form-group ">
                <label for="proveedor_id" class="control-label">Proveedor</label>
                <select class="form-control" name="form.proveedor_id" v-model="form.proveedor_id" required="required">
                    <option v-for="proveedor in proveedores" value="@{{ proveedor.id }}" >@{{ proveedor.descripcion }}</option>
                </select>
            </div>
            {{ Form::label('sucursal','Sucursal') }}
            <select class="form-control" name="sucursal" v-model="form.sucursal" >
                <option selected value="" >Seleccione</option>
                <option v-for="(index, sucursal) in sucursales" value="@{{index }}" >@{{ sucursal.nombre }}</option>
            </select>

            {{ Form::button('Buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus' ]) }}
        </div>
    </div>
    @include('components.message-confirmation')

    <div v-show="lista.length > 0">

        <form name="frmaddasietocompra" method="post" id="frmaddasietocompra" >
            <div class="row" style="margin-bottom: 20px">
                <div class="form-inline col-md-12">
                    <label for="nro_factura" class="control-label">Numero de Factura</label>
                    <input class="form-control numeros" type="text" v-model="form.nro_factura" name="nro_factura" value="" >
                    {!! Form::button("Guardar Todo", ['type' => 'submit', 'class' => 'btn btn-primary pull-right','@click.prevent'=>'guardarAsientocompra()','v-show' => "form.nro_factura != ''" ]) !!}
                </div>
                <input type="hidden" name="proveedor_id" v-model="form.proveedor_id">
                <input type="hidden" name="sucursal_id" v-model="form.sucursal_id">
            </div>
            <table class="table responsive table-bordered table-hover table-striped"  >
                <thead>
                <tr>
                    <th>Cod</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                </tr>
                </thead>
                <tbody id="table">
                <tr v-for="(index, registro)  in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                    <input type="hidden" name="row[@{{ index }}][articulo_id]" value="@{{ registro.articulo_id }}" >
                    <td>@{{ registro.cod }}</td>
                    <td>@{{ registro.descripcion }}</td>
                    <td>
                        <input type="number" maxlength="5" size="5" id="cantidad" name="row[@{{ index }}][cantidad]" />
                    </td>
                </tr>
                </tbody>
            </table>

        </form>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

    @include('components.modal',['accion' => 'Eliminar','id' => 1])
@endsection