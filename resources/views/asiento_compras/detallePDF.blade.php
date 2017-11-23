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
    .textoaling{
        text-align: left;
    }
    .table{
        border: solid black;
        border-width: 0 0 1px 0;
    }
    .borde{
        outline: thin solid;
    }

</style>

<table class="textoaling">
    <tr>
        <td><strong>Asiento de Compra nro:</strong> {{ $id }}</td>
    </tr>
    <tr>
        <td><strong>Nro Factura:</strong> {{ $asiento->nro_factura }}</td>
    </tr>
    <tr>
        <td><strong>Proveedor:</strong> {{ $asiento->proveedor->descripcion }}</td>
    </tr>
</table>
<table width="100%" class="center" style="margin-top: 20px;">
    <tr class="letra borde table">
        <td>Cod</td>
        <th>Descripcion</th>
        <th>Cantidad</th>
        <th>PrecioUnitario</th>
        <th>Subtotal</th>
    </tr>
    @foreach($asientosdetalle as $registro)
        <tr>
            <td>{{ $registro->cod }}</td>
            <td class="textoaling">{{ $registro->descripcion }}</td>
            <td>{{ $registro->cantidad }}</td>
            <td>$ {{ $registro->precio }}</td>
            <td>$ {{ $registro->precio * $registro->cantidad }}</td>
        </tr>
    @endforeach

    <tr class="borde">
        <td></td>
        <td></td>
        <td></td>
        <td class="letra">Total</td>
        <td>$ {{ $asiento->total }}</td>
    </tr>

</table>


