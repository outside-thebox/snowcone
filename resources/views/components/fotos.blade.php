@if(isset($bien))
    @if($bien->bien_fotos)
        @include('components.galeria',array("titulo"=>"Archivos cargados","fotos"=>$bien->bien_fotos))
    @endif
@endif