@extends('layouts.app')

@section('scripts')
    <script>

        var vm = new Vue({
            el: '#main',
            data: {
                sucursales: [],
                sucursal: '',
                lista: []
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

                    cargando('sk-circle','Buscando');
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
                        }
                    });
                }


            }
        });

        $(document).ready(function(){

            $(".numeros").mask("9999999");

            vm.cargarSucursales();

        });

    </script>


@endsection

@section('content')
    <h1>Ajuste de stock</h1>

    {{--<pre>--}}
    {{--@{{ $data | json }}--}}
    {{--</pre>--}}
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
                <td>@{{ registro.cod }}</td>
                <td>@{{ registro.descripcion }}</td>
                <td>$@{{ registro.precio_compra }}</td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-usd"></span>
                        </span>
                        <input class="form-control" maxlength="5" size="8" v-model="precios_compra[index]" name="row[@{{ index }}][precio]" value="@{{ registro.precio_compra }}" />
                    </div>
                </td>
                <td>$@{{ registro.precio_sugerido }}</td>
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
                </td>
                <td v-else>
                    0
                </td>
                <td v-if="registro.stock != null">
                    <input class="form-control numeros" maxlength="5" size="8" v-model="stock[index]" name="row[@{{ index }}][precio]" value="@{{ registro.stock }}" />
                </td>
                <td v-else>
                    <input class="form-control numeros" maxlength="5" size="8" v-model="stock[index]" name="row[@{{ index }}][precio]" value="0" />
                </td>
                <td>
                    <a data-toggle="tooltip" data-placement="top" style="cursor: pointer" title='Actualizar' ><i class='glyphicon glyphicon-ok' ></i></a>
                </td>
            </tr>
            </tbody>
        </table>



    </div>

@endsection