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

    footer {
        position: fixed;
        bottom: -60px;
        height: 50px;
        text-align: right;
    }


</style>

<table width="100%" class="letra table">
    <tr>
        <td style="text-align: center" >{{ config('app.name', 'Laravel') }}</td>
    </tr>
    <tr>
        <td >Cierre de caja N°: {{ $caja->id }}</td>
    </tr>
    <tr>
        <td >Correspondiente a la heladeria: {{ $sucursal->nombre }}</td>
    </tr>
    <tr>
        <td>TOTAL EN PESOS: ${{ $caja->total }}</td>
    </tr>
    <tr>
        <td>TOTAL DE PRESUPUESTOS COBRADOS: {{ $caja->cantidad }}</td>
    </tr>
    <tr>
        <td>MOMENTO DEL CIERRE: {{ $caja->created_at }}</td>
    </tr>
</table>
<table width="100%" class="letra center" style="margin-top: 20px;">
    <tr class="table">
        <td width="45%" class="table">Nro presupuesto</td>
        <td width="25%" class="table">Nombre</td>
        <td width="15%" class="table">Total</td>

    </tr>
    @foreach($caja->presupuesto as $row)
        @if($row->estado_id == 2)
            <tr class="table">
                <td width="60%" align="center" class="table">{{$row->id or ''}}</td>
                <td width="20%" class="table">{{$row->cliente}}</td>
                <td width="20%" class="table">${{$row->precio_total}}</td>
            </tr>
        @endif
        @if($row->estado_id == 4)
            <tr class="table">
                <td width="60%" align="center" class="table">{{$row->id or ''}}</td>
                <td width="20%" class="table">{{$row->cliente}}</td>
                <td width="20%" class="table">${{$row->precio_total}}</td>
            </tr>
            <tr class="table">
                <td width="60%" align="center" class="table">{{$row->id or ''}} (Anulado)</td>
                <td width="20%" class="table">{{$row->cliente}}</td>
                <td width="20%" class="table">- ${{$row->precio_total}}</td>
            </tr>
        @endif
    @endforeach
</table>
<footer>Momento del cierre: {{$caja->created_at}}</footer>
