@extends('layouts.app')


@section('content')

    <h1>Histórico de {{ $articulo->descripcion }}</h1>

    <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
        <thead>
            <tr>
                <th style="text-align: center">Ingreso</th>
                <th style="text-align: center">Egreso</th>
                <th style="text-align: center">Stock</th>
            </tr>
        </thead>

        <?php $stock = 0 ?>

        @foreach($historico as $accion)
            <tr>
                @if(isset($accion['nro_factura']))
                    <td style="text-align: center">
                        + {{ $accion['cantidad'] }}
                        <a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Imprimir' href="{{ Route('boleta.exportarPDF')}}?proveedor_id={{ $accion['proveedor_id'] }}&nro_factura={{ $accion['nro_factura'] }}"><i class='glyphicon glyphicon-print' ></i></a>
                    </td>
                    <td style="text-align: center"></td>
                    <?php $stock = $stock + $accion['cantidad'] ; ?>
                    <td style="text-align: center">
                        {{ $stock }}
                    </td>
                @else
                    <td style="text-align: center"></td>
                    <td style="text-align: center">
                        - {{ $accion['cantidad'] }}
                        <a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Imprimir' href="{{ Route('presupuesto.index') }}/exportarPDF/{{ $accion['presupuesto_id'] }}"><i class='glyphicon glyphicon-print' ></i></a>
                    </td>
                    <?php $stock = $stock - $accion['cantidad'] ; ?>
                    <td style="text-align: center">{{ $stock }}</td>
                @endif
            </tr>
        @endforeach
    </table>

@endsection