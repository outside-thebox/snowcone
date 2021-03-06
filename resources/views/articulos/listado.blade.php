<style>
    .page-break {
        page-break-after: always;
    }

    .letra{
        font-size: 14px;
    }

    .center{
        text-align: center;
    }

    .table{
        border: solid black;
        border-width: 0 0 1px 0;
    }

</style>

<table width="100%">
    <tr>
        <td style="text-align: center; font-size: 20px; font-weight: bold">Helados</td>
    </tr>
</table>
<table width="100%" class="letra center" style="margin-top: 20px;">
    @foreach($proveedores as $proveedor)
        <tr class="table">
            <td colspan="2" align="left" class="table" style="font-weight: bold">{{$proveedor->descripcion or ''}}</td>
        </tr>
        @foreach($proveedor->articulos as $articulo)
            <tr>
                <td align="left">{{$articulo->cod or ''}}</td>
                <td align="left">{{$articulo->descripcion or ''}}</td>
            </tr>
        @endforeach
    @endforeach
</table>

