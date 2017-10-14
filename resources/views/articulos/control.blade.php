@extends('layouts.app')


@section('content')

    <h1>Histórico de {{ $articulo->descripcion }}</h1>

    <table class="table responsive table-bordered table-hover table-striped" style="margin-top: 10px" >
        <thead>
            <tr>
                <th style="text-align: center">Boleta</th>
                <th style="text-align: center">Usuario</th>
                <th style="text-align: center">Fecha y hora</th>
                <th style="text-align: center">Total ingresado</th>
            </tr>
        </thead>
        @foreach($boletas as $boleta)
            <tr>
                <td style="text-align: center">
                    <a data-toggle="tooltip" target="_blank" data-placement="top" style="cursor: pointer" title='Imprimir' href="{{ Route('boleta.exportarPDF')}}?proveedor_id={{ $boleta->proveedor_id }}&nro_factura={{ $boleta->nro_factura }}"><i class='glyphicon glyphicon-print' ></i></a>
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
    </table>

@endsection