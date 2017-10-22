@extends('layouts.app')

@section('scripts')
    <script>
        vm = new Vue({
            el: '#main',
            data:{

                cantidad_ingresada: 0,
                cantidad_vendida: 0,
                stock_actual: "{{ $stock_actual }}"
            },
            watch:{
                lista:function(){
                    $('[data-toggle="tooltip"]').tooltip();
                }
            },
        });

        $(document).ready(function(){

            $('[data-toggle="tooltip"]').tooltip();

        });


    </script>
@endsection

@section('content')

    <h1>Histórico de {{ $articulo->descripcion }}</h1>

    <div class="row">
        <table class="table table-hover" style="margin-top: 10px;" >
             <tr>
                 <td style="text-align: center">Total ingresado: @{{ cantidad_ingresada }}</td>
                 <td style="text-align: center">Total vendido: @{{ cantidad_vendida }}</td>
                 <td style="text-align: center">Stock actual: @{{ stock_actual }}</td>
             </tr>
        </table>
    </div>

    <div class="col-md-6">
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
                <tr>
                    <th style="text-align: center" colspan="4">Cantidad ingresada</th>
                </tr>
                <tr>
                    <th style="text-align: center">Boleta</th>
                    <th style="text-align: center">Usuario</th>
                    <th style="text-align: center">Fecha y hora</th>
                    <th style="text-align: center">Total ingresado</th>
                </tr>
            </thead>
            <?php $cantidad_ingresada = 0 ?>
            @foreach($boletas as $boleta)
                <?php $cantidad_ingresada += $boleta->cantidad ?>
                <tr>
                    <td style="text-align: center">
                        <a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Imprimir' href="{{ Route('boleta.exportarPDF')}}?proveedor_id={{ $boleta->proveedor_id }}&nro_factura={{ $boleta->nro_factura }}"><i class='glyphicon glyphicon-print' ></i></a>
                        {{ $boleta->nro_factura }}
                    </td>
                    <td style="text-align: center">
                        {{ $boleta->user->nombre. " ".$boleta->user->apellido }}
                    </td>
                    <td style="text-align: center">
                        {{ $boleta->created_at }}
                    </td>
                    <td style="text-align: center">
                        {{ $boleta->cantidad}}
                    </td>
                </tr>
            @endforeach

            <input type="hidden" name="cantidad_ingresada" v-model="cantidad_ingresada" value="{{ $cantidad_ingresada }}">

        </table>
    </div>
    <div class="col-md-6">
        <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
            <thead>
            <tr>
                <th style="text-align: center" colspan="5">Cantidad vendida</th>
            </tr>
            <tr>
                <th style="text-align: center">Presupuesto</th>
                <th style="text-align: center">Cantidad</th>
                <th style="text-align: center">Fecha y hora</th>
                <th style="text-align: center">Usuario</th>
            </tr>
            </thead>

            <?php $cantidad_vendida = 0 ?>
            @foreach($presupuestos as $presupuesto)
                <?php $cantidad_vendida += $presupuesto->cantidad ?>
                <tr>
                    <td style="text-align: center">
                        <a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Imprimir' href="{{ Route('presupuesto.index') }}/exportarPDF/{{$presupuesto->id}}"><i class='glyphicon glyphicon-print' ></i></a>
                        {{ $presupuesto->id}}
                    </td>
                    <td style="text-align: center">
                        {{ $presupuesto->cantidad}}
                    </td>
                    <td style="text-align: center">
                        {{ $presupuesto->created_at }}
                    </td>
                    <td style="text-align: center">
                        {{ $presupuesto->presupuesto->user->nombre }} {{$presupuesto->presupuesto->user->apellido}}
                    </td>
                </tr>
            @endforeach
            <input type="hidden" name="cantidad_vendida" v-model="cantidad_vendida" value="{{ $cantidad_vendida }}">
        </table>

    </div>


@endsection