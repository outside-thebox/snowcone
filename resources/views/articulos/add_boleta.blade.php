@extends('layouts.app')

@section('scripts')

    <script>

        vm = new Vue({
            el: '#main',
            data:{
                articulo : {
                    proveedor_id:''
                },
                proveedores: [],
                pagina_actual: 0,
                first: '',
                prev: '',
                next: '',
                last: '',
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
                console.log(id);
                var addstock = $("input:text[name=addstock"+id+"]").val();
                var stock = $("input:text[name=stock"+id+"]").val();
                var total = parseFloat(addstock) +  parseFloat(stock);
                $("#stocktotal"+id).val(total);
                    //console.log($("#stocktotal"+id).val());
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
                updateStock: function(id)
                {
                    console.log($("input:text[name=stocktotal"+id+"]").val());
                    var precio_compra = $("input:text[name=precio_compra_"+id+"]").val();
                    var stocktotal = $("input:text[name=stocktotal"+id+"]").val();
                    var token = $("input:hidden[name=_token]").val();

                    cargando('sk-falding-circle"','Actualizando');
                    $.ajax({
                        url: "{{route('articulosxstock.updateBoleta')}}",
                        method: 'POST',
                        data: "id="+id+"&precio_compra="+precio_compra+"&stock="+stocktotal+"&_token="+token,
                        success: function (data) {
                            HoldOn.close();
                            $("#contenido-modal-1").html("El registro fue actualizado correctamente");
                            $("#confirmacion-1").modal(function(){show:true});

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
                        var url = "{{route('articulos.buscarxstock')}}" + "?" + "page=1&proveedor_id="+this.articulo.proveedor_id;

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
                        success: function (data) {
                            vm.pagina_actual = 'Página '+ data.current_page + ' de '+ data.last_page + '. Cantidad de registros: ' + data.total;
                            vm.lista = data.data;
                            $('#btntodo').show();
                            vm.first = "{{route('articulos.buscarxstock')}}" + "?page=1";
                            vm.next = data.next_page_url;
                            if(data.total <= "{{ env('APP_CANT_PAGINATE',10) }}")
                            {
                                $("#next").addClass("hidden");
                                $("#first").addClass("hidden");
                                $("#prev").addClass("hidden");
                                $("#last").addClass("hidden");
                            }
                            else
                            {
                                $("#next").removeClass("hidden");
                                $("#first").removeClass("hidden");
                                $("#prev").removeClass("hidden");
                                $("#last").removeClass("hidden");
                            }

                            vm.prev = data.prev_page_url;
                            vm.last = "{{route('articulos.buscarxstock')}}" + "?page="+data.last_page;
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
        });
    </script>

@endsection
@section('content')

    <h1>Stock de articulos por proveedor</h1>
    <div class="row">
        <div class="form-inline col-md-6" style="margin-bottom: 10px">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" v-model="token">
            <input type="hidden" name="id_seleccionado" value="" v-model="id_seleccionado">

            {{ method_field('PUT') }}

            <div class="form-group ">
                <label for="proveedor_id" class="control-label">Proveedor</label>
                <span class="label label-info">Required</span>
                <select class="form-control" name="articulo.proveedor_id" v-model="articulo.proveedor_id" required="required">
                    <option v-for="proveedor in proveedores" value="@{{ proveedor.id }}" >@{{ proveedor.descripcion }}</option>
                </select>
            </div>
            {{ Form::button('Buscar',['class' => 'btn btn-info', '@click.prevent'=>'buscar()','autofocus' ]) }}
        </div>

        <div id="btntodo" class="form-aling col-md-6" style="display: none;">
            <div class="text-right">
                {{ Form::button('Actualizar Todo',['class' => 'btn btn-success', '@click.prevent'=>'updateStock()','autofocus' ]) }}
            </div>
        </div>
    </div>

    @include('components.message-confirmation')

    <div v-show="lista.length > 0">
        @include('components.buttons_paginate')
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
            <tr>
                <th>Cod</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Accion</th>
            </tr>
            </thead>
            <tbody id="table">
            <tr v-for="registro in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                <td>@{{ registro.cod }}</td>
                <td>@{{ registro.descripcion }}</td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-usd"></span>
                            </span>
                        <input type="text" size="5" name="precio_compra_@{{ registro.id }}" value="@{{ registro.precio_compra }}" class="form-control" />
                    </div>
                </td>
                <td>
                   <div class="row">
                       <div class="col-xs-4 .col-md-4">
                           <input type="text" maxlength="5" size="5" name="stock@{{ registro.id }}" value="@{{ registro.stock }}" disabled />
                           <span>+</span>
                       </div>
                       <div class="col-xs-4 .col-md-4">
                           <input type="text" maxlength="5" size="5" name="addstock@{{ registro.id }}" value="" v-on:keyup.enter="totalstock(registro.id)"  />
                           <span>=</span>
                       </div>
                       <div class="col-xs-4 .col-md-4">
                           <input type="text" maxlength="5" size="5" id="stocktotal@{{ registro.id }}" name="stocktotal@{{ registro.id }}" value="@{{ stocktotal }}" disabled />
                       </div>
                   </div>
                </td>
               <td>
                   <a data-toggle="tooltip" data-placement="top" style="cursor: pointer" title='Actualizar' @click="updateStock(registro.id)"><i class='glyphicon glyphicon-refresh' ></i></a>
               </td>
            </tr>
            </tbody>
        </table>
        <label id="pagina_actual" class="pull-right" >@{{ pagina_actual }}</label>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

    @include('components.modal',['accion' => 'Eliminar','id' => 1])

@endsection