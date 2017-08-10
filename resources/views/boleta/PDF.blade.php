<style>
    .page-break {
        page-break-after: always;
    }

    .letra{
        font-size: 22px;
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
        <td >Nro Boleta: {{ $id }}</td>
{{--        <td >Proveedor: {{ $boleta[0]->proveedor->descripcion }}</td>--}}
    </tr>
</table>
<table width="100%" class="letra center" style="margin-top: 20px;">
    <tr class="table">
        <td width="45%" class="table">ARTICULO</td>
        <td width="25%" class="table">CANTIDAD</td>
        <td width="15%" class="table">UNITARIO</td>

    </tr>
    @foreach($boleta as $row)
        <tr class="table">
            <td width="60%" align="left" class="table">{{$row->articulo->descripcion or ''}}</td>
            <td width="20%" class="table">{{$row->cantidad}}</td>
            <td width="20%" class="table">${{$row->precio_compra}}</td>

        </tr>
    @endforeach
</table>

