<style>
    .page-break {
        page-break-after: always;
    }

    .letra{
        font-size: 18px;
        font-weight: bold;
    }

    .center{
        text-align: center;
    }

    .table{
        border: solid black;
        border-width: 0 0 1px 0;
    }
    /*table {*/
        /*border-width: 1px 1px 0 0;*/
    /*}*/
    /*table td {*/
        /*border-width: 0 0 1px 1px;*/
    /*}*/

</style>
<table width="100%" class="letra table">
    <tr>
        <td width="60%">Sucursal: {{ $sucursal }}</td>
    </tr>
    <tr>
        <td width="25%">Proveedor: {{ $proveedor}}</td>
        <td width="15%">Fecha {{ $fecha }}</td>
    </tr>
</table>

<table width="100%" class="letra center" style="margin-top: 20px;">
    <tr>
        <th>Nro asiento</th>
        <th>Proveedor</th>
        <th>Sucursal</th>
        <th>Nro factura</th>
        <th>Total</th>

    </tr>
    @foreach($asientos as $asiento)
            <tr>
                <td>{{ $asiento->id }}</td>
                <td>{{ $asiento->proveedor->descripcion }}</td>
                <td>{{ $asiento->sucursal->nombre }}</td>
                <td>{{ $asiento->nro_factura }}</td>
                <td>$ {{ $asiento->total }}</td>
            </tr>
    @endforeach
</table>

