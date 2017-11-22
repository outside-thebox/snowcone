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

</style>

<table width="100%" class="letra table">
    <tr>
        <td >Nro Asiento de Compra: {{ $id }}</td>
    </tr>
</table>
<table width="100%" class="letra center" style="margin-top: 20px;">
    <tr class="table">
        <td>Cod</td>
        <th>Descripcion</th>
        <th>Cantidad</th>
        <th>PrecioUnitario</th>
        <th>Subtotal</th>
    </tr>
    @foreach($asientosdetalle as $registro)
        <tr class="table">
            <td>{{ $registro->cod }}</td>
            <td>{{ $registro->descripcion }}</td>
            <td>{{ $registro->cantidad }}</td>
            <td>$ {{ $registro->precio }}</td>
            <td>$ {{ $registro->precio * $registro->cantidad }}</td>

        </tr>
    @endforeach
</table>

