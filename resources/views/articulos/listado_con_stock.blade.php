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
        <td style="text-align: center; font-size: 20px; font-weight: bold">Helados Gaby</td>
    </tr>
</table>
<table width="100%" class="letra center" style="margin-top: 20px;">
    @foreach($proveedores as $proveedor)
        <?php $ban = false; ?>
        @if(count($proveedor->articulos) > 0)
            @foreach($proveedor->articulos as $articulo)
                @if($articulo->stockxarticulo->stock > 0)
                    <?php $ban = true; ?>
                @endif
            @endforeach

            @if($ban)
                <tr class="table">
                    <td align="left" class="table" style="font-weight: bold">{{$proveedor->descripcion or ''}}</td>
                    <td align="left" class="table" style="font-weight: bold">Precio</td>
                    <td align="left" class="table" style="font-weight: bold">Sugerido</td>
                </tr>
                @foreach($proveedor->articulos as $articulo)
                    @if($articulo->stockxarticulo->stock > 0)
                        <tr>
                            <td align="left">{{$articulo->descripcion or ''}}</td>
                            <td align="left">${{$articulo->stockxarticulo->precio_compra or ''}}</td>
                            <td align="left">${{$articulo->stockxarticulo->precio_sugerido or ''}}</td>
                        </tr>
                    @endif
                @endforeach
            @endif
        @endif
    @endforeach
</table>

