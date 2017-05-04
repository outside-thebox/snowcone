@if( (Request::segment(2) != 'pdf') and ($fotos != null))
<div class="panel panel-info" >
    <div class="panel-heading" style="background-color: #009688">
        <h3 class="panel-title">{{ $titulo }}</h3>
    </div>
    <div class="panel-body" style="background-color: #EEEEEE">
        <div class="your-class">
            <div class="row">
                @foreach($fotos as $foto)
                    @if(is_object($foto))
                       <div class="col-md-2" style="cursor: zoom-in">
                           <a href="{{ Route('archivos.descargar')}}?q={{ $foto->foto }}" target="_blank" >
                               <img src="{{ Route('archivos.descargar')}}?q={{ $foto->foto }}" style="width: 150px; border-radius: 75px; border: 2px solid white;">
                           </a>
                       </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif