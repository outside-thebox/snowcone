@extends('layouts.app')

@section('scripts')
    <script>
        function calcularTotal()
        {
            vm.form.total = 0;
            for (var key in vm.precios) {
                if(vm.precios[key])
                {
                    vm.form.total += parseFloat(vm.precios[key]) * parseInt(vm.cantidades[key]);
                }
            }

        }

        vm = new Vue({
            el: '#main',
            data:{
                form : {
                    proveedor_id:'',
                    sucursal_conexion:'',
                    sucursal_id:'',
                    nro_factura:'',
                    total:0
                },
                proveedores: [],
                sucursales: [],
                lista: [],
                precios: [],
                cantidades: [],
                precio_total: 0,
                busqueda: true,
                id_seleccionado: 0,
                token: ''

            },
            watch:{
                lista:function(){
                    $('[data-toggle="tooltip"]').tooltip();
                },
                precios:function()
                {
                    calcularTotal();
                },
                cantidades:function()
                {
                    calcularTotal();
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
                limpiar: function()
                {
                    vm.lista = [];
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

                    cargando('sk-circle','Intentando acceder al servidor...');
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
                            $("#contenido-modal-1").html("<strong>La respuesta tardó demasiado tiempo, puede que el servidor esté apagado o no haya conexión a internet</strong>");
                            $("#confirmacion-1").modal(function(){show:true});
                        }
                    });
                }
            }
        });

        function calcularPrecioTotal()
        {
//            $('.calcular_precio_total').each(function(index,item){
//                var name = "row["+index+"][precio]";
//                var selector = "input:text[name="+name+"]";
//                console.log(selector);
//                console.log($(selector).val());
//            });
        }

        $(document).ready(function(){

            $(".numeros").mask("000000");
            $('[data-toggle="tooltip"]').tooltip();
            vm.cargarSucursales();
            vm.cargarProveedores();

            $("form").keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });




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
                <select class="form-control" name="form.proveedor_id" v-model="form.proveedor_id" required="required" v-on:change="limpiar">
                    <option v-for="proveedor in proveedores" value="@{{ proveedor.id }}" >@{{ proveedor.descripcion }}</option>
                </select>
            </div>
            {{ Form::label('sucursal','Sucursal') }}
            <select class="form-control" name="sucursal" v-model="form.sucursal" v-on:change="limpiar">
                <option selected value="" >Seleccione</option>
                <option v-for="(index, sucursal) in sucursales" value="@{{index }}" >@{{ sucursal.nombre }}</option>
            </select>

            {{ Form::button('Buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus' ]) }}
        </div>
    </div>
    @include('components.message-confirmation')

    {{--<pre>--}}
    {{--@{{ $data | json }}--}}
    {{--</pre>--}}
    <div v-show="lista.length > 0">

        <form name="frmaddasietocompra" method="post" id="frmaddasietocompra">
            <div class="row" style="margin-bottom: 20px">
                <div class="form-inline col-md-12">
                    <label for="nro_factura" class="control-label">Numero de Factura</label>
                    <input class="form-control numeros" type="text" v-model="form.nro_factura" name="nro_factura" id="nro_factura" value="" >
                    <label for="nro_factura" class="control-label">Total Factura</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-usd"></span>
                        </span>
                        <input class="form-control numeros" type="text" v-model="form.total" name="total" value="" readonly>
                    </div>
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
                    <th>Precio unitario</th>
                </tr>
                </thead>
                <tbody id="table">
                <tr v-for="(index, registro)  in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                    <input type="hidden" name="row[@{{ index }}][articulo_id]" value="@{{ registro.articulo_id }}" >
                    <td>@{{ registro.cod }}</td>
                    <input type="hidden" name="row[@{{ index }}][cod]" value="@{{ registro.cod }}" >
                    <td>@{{ registro.descripcion }}</td>
                    <input type="hidden" name="row[@{{ index }}][descripcion]" value="@{{ registro.descripcion }}" >
                    <td>
                        <input type="number" class="form-control" max = "5" maxlength="5" size="5" value="0" id="cantidad" name="row[@{{ index }}][cantidad]" v-model="cantidades[index]" />
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="fa fa-usd"></span>
                            </span>
                            <input type="number" class="calcular_precio_total form-control" maxlength="5" size="5" id="precio" v-model="precios[index]" name="row[@{{ index }}][precio]" />
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>

        </form>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

    @include('components.modal',['accion' => 'Eliminar','id' => 1])
@endsection