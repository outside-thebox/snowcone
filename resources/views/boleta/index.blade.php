@extends('layouts.app')

@section('scripts')

    <script>

        vm = new Vue({
            el: '#main',
            data:{
                boleta : {

                },
                pagina_actual: 0,
                first: '',
                prev: '',
                next: '',
                last: '',
                lista: [],
                busqueda: true,
                token: ''

            },
            watch:{
                lista:function(){
                    $('[data-toggle="tooltip"]').tooltip();
                }
            },
            methods:{
                buscar: function(url){

                    $("#message-confirmation").addClass("hidden");
                    if(url == undefined)
                        var url = "{{route('boleta.buscarAgrupadoBoleta')}}" + "?" + "page=1";

                    var boleta = this.boleta;
                    boleta._token = this.token;
                    cargando('sk-circle','Buscando');
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: "json",
                        assync: true,
                        data: boleta,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            vm.pagina_actual = 'Página '+ data.current_page + ' de '+ data.last_page + '. Cantidad de registros: ' + data.total;
                            vm.lista = data.data;
                            vm.first = "{{route('boleta.buscarAgrupadoBoleta')}}" + "?page=1";
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
                            vm.last = "{{route('boleta.buscarAgrupadoBoleta')}}" + "?page="+data.last_page;
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

            vm.buscar();


        });

    </script>


@endsection

@section('content')

    <h1>Listado Boletas
        <a href="{!! route('articulosxstock.addBoleta')!!}"><button class="btn btn-success pull-right">Agregar boleta</button></a>
    </h1>

    @include('components.message-confirmation')

    <div v-show="lista.length > 0">
        @include('components.buttons_paginate')
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
            <tr>
                <th>Nro Boleta</th>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Acciones</th>

            </tr>
            </thead>
            <tbody id="table">
            <tr v-for="registro in lista" class="@{{ registro.deleted_at ? 'inactivo' : '' }}">
                <td>@{{ registro.nro_factura }}</td>
                <td>@{{ registro.proveedor.descripcion }}</td>
                <td>@{{ registro.created_at }}</td>
                <!--<td><a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Imprimir' href="{{ Route('boleta.index') }}/exportarPDF/@{{ registro.nro_factura }}"><i class='glyphicon glyphicon-print' ></i></a></td>-->
                <td><a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Imprimir' href="{{ Route('boleta.exportarPDF')}}?proveedor_id=@{{ registro.proveedor.id }}&nro_factura=@{{ registro.nro_factura }}"><i class='glyphicon glyphicon-print' ></i></a>
                    </td>
            </tr>
            </tbody>
        </table>
        <label id="pagina_actual" class="pull-right" >@{{ pagina_actual }}</label>
    </div>
    <h2 v-show="busqueda == false && lista.length == 0">No se encontraron resultados</h2>

@endsection