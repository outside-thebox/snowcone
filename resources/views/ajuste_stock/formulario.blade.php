@extends('layouts.app')

@section('scripts')
    <script>

        var vm = new Vue({
            el: '#main',
            data: {
                sucursales: [],
                sucursal: '',
                lista: [],
                articulos: [],
                stockxarticulos: [],
                precios_compra: [],
                precios_compra_anteriores: [],
                precios_sugeridos: [],
                precios_sugeridos_anteriores: [],
                stocks: [],
                stocks_anteriores: [],
                id_seleccionado: '',
                token: ''
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
                buscar: function(url){
                    var url = "{{route('articulos.buscarxstockPrices')}}" + "?"+"stock=true&conexion="+this.sucursal;

                    cargando('sk-circle','Intentando acceder al servidor...');
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: "json",
                        assync: true,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            vm.lista = data;
                            HoldOn.close();
                        },
                        error: function (respuesta) {
                            HoldOn.close();
                            $("#contenido-modal-1").html("<strong>La respuesta tardó demasiado tiempo, puede que el servidor esté apagado o no haya conexión a internet</strong>");
                            $("#confirmacion-1").modal(function(){show:true});
                        }
                    });
                },
                actualizar: function(element)
                {
                    vm.id_seleccionado = element;
                    var precio_compra = vm.precios_compra[element];
                    var precio_compra_anterior = vm.precios_compra_anteriores[element];
                    var precio_sugerido = vm.precios_sugeridos[element];
                    var precio_sugerido_anterior = vm.precios_sugeridos_anteriores[element];
                    var stock = vm.stocks[element];
                    var stock_anterior = vm.stocks_anteriores[element];

                    var mensaje = "<h3>¿Confirma que desea realizar el siguiente cambio?</h3><br>";

                    mensaje += "<table class='table responsive table-bordered table-hover table-striped'>";
                    mensaje += "<tr>";
                    mensaje += "<td colspan='2' style='text-align: center'><label>"+vm.articulos[element]+"</label></td>";
                    mensaje += "</tr>";
                    mensaje += "<tr>";
                    mensaje += "<td>Precio de compra anterior: <strong>$"+precio_compra_anterior+"</strong></td>";
                    mensaje += "<td>Precio de compra nuevo: <strong>$"+precio_compra+"</strong></td>";
                    mensaje += "</tr>";

                    mensaje += "<tr>";
                    mensaje += "<td>Precio sugerido anterior: <strong>$"+precio_sugerido_anterior+"</strong></td>";
                    mensaje += "<td>Precio sugerido nuevo: <strong>$"+precio_sugerido+"</strong></td>";
                    mensaje += "</tr>";
                    mensaje += "<tr>";
                    mensaje += "<td>Stock anterior: <strong>"+stock_anterior+"</strong></td>";
                    mensaje += "<td>Stock nuevo: <strong>"+stock+"</strong></td>";
                    mensaje += "</tr>";
                    mensaje += "</table>";

//                    console.log(precio_compra_anterior,precio_compra,precio_sugerido,stock);
                    $("#pregunta-1").modal(function(){show:true});

                    $("#contenido-pregunta-1").html("");
                    $("#contenido-pregunta-1").append(mensaje);
                    $("#pregunta-1").modal(function(){show:true});
                }


            }
        });

        $(document).ready(function(){

            $(".numeros").mask("9999999");

            vm.cargarSucursales();

            $("#eliminar-1").click(function(){

                var data = [];
                var element = vm.id_seleccionado;
                data.push({'stockxarticulos_id' : vm.stockxarticulos[element],
                    'precio_compra' : vm.precios_compra[element],
                    'precio_compra_anterior' : vm.precios_compra_anteriores[element],
                    'precio_sugerido' : vm.precios_sugeridos[element],
                    'precio_sugerido_anterior' : vm.precios_sugeridos_anteriores[element],
                    'stock' : vm.stocks[element],
                    'stock_anterior' : vm.stocks_anteriores[element],
                    'conexion' : vm.sucursal
                });
                var url = "{{route('articulosxstock.updateData')}}";

                cargando('sk-circle','Actualizando...');
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: "data="+JSON.stringify(data)+"&_token="+vm.token,
                    assync: true,
                    success: function (data) {
                        HoldOn.close();
                    },
                    error: function (respuesta) {
                        HoldOn.close();
                        $("#contenido-modal-1").html("<strong>La respuesta tardó demasiado tiempo, puede que el servidor esté apagado o no haya conexión a internet</strong>");
                        $("#confirmacion-1").modal(function(){show:true});
                    }
                });

            });
        });

    </script>


@endsection

@section('content')
    <h1>Ajuste de stock</h1>

    {{--<pre>--}}
    {{--@{{ $data | json }}--}}
    {{--</pre>--}}
    <input type="hidden" name="id_seleccionado" value="" v-model="id_seleccionado">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">

    <div class="col-md-6">
        {{ Form::label('sucursal','¿Qué sucursal?') }}
        <select class="form-control" name="conexion" v-model="sucursal" v-on:change="buscar" >
            <option v-for="sucursal in sucursales" value="@{{ sucursal.conexion }}" >@{{ sucursal.nombre }}</option>
        </select>
    </div>
    <div class="col-md-12">
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
            <tr>
                <th>Cod</th>
                <th>Descripción</th>
                <th>Precio de compra anterior</th>
                <th>Precio de compra nuevo</th>
                <th>Precio sugerido anterior</th>
                <th>Precio sugerido nuevo</th>
                <th>Stock anterior</th>
                <th>Stock nuevo</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="table_entrada">

            <tr v-for="(index, registro)  in lista">

                <td>
                    <input type="hidden" name="stockxarticulos[@{{ index }}]" v-model="stockxarticulos[index]" value="@{{ registro.id }}">
                    @{{ registro.cod }}
                </td>
                <td>
                    @{{ registro.descripcion }}
                    <input type="hidden" name="articulos[@{{ index }}]" v-model="articulos[index]" value="@{{ registro.descripcion }}">
                </td>
                <td>
                    $@{{ registro.precio_compra }}
                    <input type="hidden" name="precios_compra[@{{ index }}]" v-model="precios_compra_anteriores[index]" value="@{{ registro.precio_compra }}">
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-usd"></span>
                        </span>
                        <input class="form-control" maxlength="5" size="8" v-model="precios_compra[index]" name="row[@{{ index }}][precio]" value="@{{ registro.precio_compra }}" />
                    </div>
                </td>
                <td>
                    $@{{ registro.precio_sugerido }}
                    <input type="hidden" name="precios_sugeridos_anteriores[@{{ index }}]" v-model="precios_sugeridos_anteriores[index]" value="@{{ registro.precio_sugerido }}">
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-usd"></span>
                        </span>
                        <input class="form-control" maxlength="5" size="8" v-model="precios_sugeridos[index]" name="row[@{{ index }}][precio]" value="@{{ registro.precio_sugerido }}" />
                    </div>
                </td>
                <td v-if="registro.stock != null">
                    @{{ registro.stock }}
                    <input type="hidden" name="stocks_anteriores[@{{ index }}]" v-model="stocks_anteriores[index]" value="@{{ registro.stock }}">
                </td>
                <td v-else>
                    0
                    <input type="hidden" name="stocks_anteriores[@{{ index }}]" v-model="stocks_anteriores[index]" value="@{{ registro.stock }}">
                </td>
                <td v-if="registro.stock != null">
                    <input class="form-control numeros" maxlength="5" size="8" v-model="stocks[index]" name="row[@{{ index }}][precio]" value="@{{ registro.stock }}" />
                </td>
                <td v-else>
                    <input class="form-control numeros" maxlength="5" size="8" v-model="stocks[index]" name="row[@{{ index }}][precio]" value="0" />
                </td>
                <td>
                    <a data-toggle="tooltip" data-placement="top" style="cursor: pointer" title='Actualizar' @click="actualizar(index)" ><i class='glyphicon glyphicon-ok' ></i></a>
                </td>
            </tr>
            </tbody>
        </table>



    </div>
    @include('components.modal',['accion' => 'Confirmar','id' => 1])

@endsection