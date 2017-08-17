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
        <td width="60%">SEÑOR/A: {{ $presupuesto->cliente }}</td>
        <td width="25%">{{ $presupuesto->created_at }}</td>
        <td width="15%">N° {{ $presupuesto->id }}</td>
    </tr>
</table>
<table width="100%" class="letra center" style="margin-top: 20px;">
    <tr class="table">
        <td width="45%" class="table">ARTICULO</td>
        <td width="25%" class="table">CANTIDAD</td>
        <td width="15%" class="table">UNITARIO</td>
        <td width="15%" class="table">SUBTOTAL</td>
    </tr>
    @foreach($presupuesto->presupuestoxarticulo as $presupuestoxarticulos)
        <tr class="table">
            <td width="45%" class="table">{{ $presupuestoxarticulos->articulo->descripcion }}</td>
            <td width="25%" class="table">{{ $presupuestoxarticulos->cantidad }}</td>
            <td width="15%" class="table">${{ $presupuestoxarticulos->precio_unitario }}</td>
            <td width="15%" class="table">${{ $presupuestoxarticulos->subtotal }}</td>
        </tr>
    @endforeach
</table>
<table width="100%" class="letra" style="margin-top: 60px;border: solid black;border-width: 1px 0 0 0;" >
    <tr>
        <td width="70%">VENDEDOR/A: {{ $presupuesto->user->nombre }} {{ $presupuesto->user->apellido }}</td>
        <td width="15%" class="center" style="border-right: none">TOTAL: </td>
        <td width="15%" class="center" style="border-left: none">${{ $presupuesto->precio_total }}</td>
    </tr>
</table>
