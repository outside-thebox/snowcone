@extends('layouts.app')

@section('scripts')

    <script>

        $(document).ready(function(){

            cargando("sk-folding-cube",'Guardando...');

            HoldOn.close();

        });



    </script>

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Inicio</div>

                <div class="panel-body">
                    Bienvenido al sistema {{ config('app.name', 'Laravel') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
