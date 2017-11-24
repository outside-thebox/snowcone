@extends('layouts.app')

@section('scripts')
    <script>
        vm = new Vue({
            el: '#main',
            data:{
                articulo : {
                    proveedor_id:'',
                    nro_factura:''
                },
                proveedores: [],
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

                totalstock: function(id) {

                var addstock = $("input:text[name=addstock"+id+"]").val();
                var stock = $("input:text[name=stock"+id+"]").val();
                var total = parseFloat(addstock) +  parseFloat(stock);
                console.log(addstock+stock);
                vm.addstock.push({'id':id,'cantidad':addstock});
                $("#stocktotal"+id).val(total);

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
                updateStock: function()
                {
                    var token = $("input:hidden[name=_token]").val();
                    var datos = $('#frmaddstock').serialize();

                    cargando('sk-circle','Actualizando');


                    $.ajax({
                        url: "{{route('articulosxstock.datosinput')}}",
                        method: 'POST',
                        data: datos+"&_token="+token,
                        success: function (data) {

                            HoldOn.close();
                            $("#contenido-modal-1").html("El registro fue actualizado correctamente");
                            $("#confirmacion-1").modal(function(){show:true});
                            vm.articulo.nro_factura = '';
                            return vm.buscar();

                        },
                        error: function (respuesta) {
                            HoldOn.close();
                            $("#contenido-modal-1").html("Se ha producido un error, por favor contacte con el administrador");
                            $("#confirmacion-1").modal(function(){show:true});
                        }
                    });
                },
                buscar: function(url){
                    $("#message-confirmation").addClass("hidden");
                    if(url == undefined)
                        var url = "{{route('articulos.buscarxstockall')}}" + "?" + "proveedor_id="+this.articulo.proveedor_id;
                    else
                        var url = url + "?" + "proveedor_id="+this.articulo.proveedor_id;

                    var articulo = this.articulo;
                    articulo._token = this.token;

                    cargando('sk-circle','Buscando');
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: "json",
                        assync: true,
                        data: articulo,
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
                            HoldOn.close();
                        }
                    });
                }
            }
        });

        $(document).ready(function(){

            $(".numeros").mask("000000");
            $('[data-toggle="tooltip"]').tooltip();

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

    <h1>Agregar Boletas</h1>
    <div class="row">
        <div class="form-inline col-md-6" style="margin-bottom: 10px">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
            <input type="hidden" name="id_seleccionado" value="" v-model="id_seleccionado">

            {{ method_field('PUT') }}

            <div class="form-group ">
                <label for="proveedor_id" class="control-label">Proveedor</label>
                <select class="form-control" name="articulo.proveedor_id" v-model="articulo.proveedor_id" required="required">
                    <option v-for="proveedor in proveedores" value="@{{ proveedor.id }}" >@{{ proveedor.descripcion }}</option>
                </select>
            </div>
            {{ Form::button('Buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus' ]) }}
        </div>
    </div>
    @include('components.message-confirmation')

    <div v-show="lista.length > 0">

        <form name="frmaddstock" method="post" id="frmaddstock" >
            <div class="row" style="margin-bottom: 20px">
                <div class="form-inline col-md-12">
                    <label for="nro_factura" class="control-label">Numero de Factura</label>
                    <input class="form-control numeros" type="text" v-model="articulo.nro_factura" name="articulo.nro_factura" value="" >
                    {!! Form::button("Actualizar Todo", ['type' => 'submit', 'class' => 'btn btn-primary pull-right','@click.prevent'=>'updateStock()','v-show' => "articulo.nro_factura != ''" ]) !!}
                </div>
            </div>
            <table class="table responsive table-bordered table-hover table-striped"  >
                <thead>
                <tr>
                    <th>Cod</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Nuevo Stock</th>
                </tr>
                </thead>
                <tbody id="table">
                <tr v-for="(index, registro)  in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                    <input type="hidden" name="row[@{{ index }}][id]"           value="@{{ registro.articulo_id }}" >
                    <input type="hidden" name="row[@{{ index }}][proveedor_id]" value="@{{ articulo.proveedor_id }}" >
                    <input type="hidden" name="row[@{{ index }}][nro_factura]"  value="@{{ articulo.nro_factura }}" >
                    <td>@{{ registro.cod }}</td>
                    <td>@{{ registro.descripcion }}</td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="fa fa-usd"></span>
                                </span>
                            <input type="text" size="5" name="row[@{{ index }}][precio_compra]" id="precio_compra" value="@{{ registro.precio_compra }}" class="form-control" />
                        </div>
                    </td>
                    <td>
                        <input type="text" maxlength="5" size="5" name="stock@{{ registro.id }}" value="@{{ registro.stock }}" disabled />
                        <input type="hidden" name="row[@{{ index }}][stock]" value="@{{ registro.stock }}" />
                    </td>
                    <td>
                        <input type="number" class="form-control"  maxlength="5" size="5"  id="addstock" name="row[@{{ index }}][addstock]"/>
                    </td>
                </tr>
                </tbody>
            </table>

        </form>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

    @include('components.modal',['accion' => 'Eliminar','id' => 1])

@endsection