<div class="col-md-12" style="margin-bottom:10px" data-id="{{ $i }}">
    <div class="">
        {{ Form::label($nombre,$nombre,array("style"=>"display:none")) }}
        {{ Form::file($nombre,$attributes = array())}}

        <label data-title="{{ isset($nombre_campo)? $nombre_campo:'Subir Archivo' }}" for="upload-demo" >
            <span data-title="..."></span>
        </label>
    </div>
    @if ($eliminar)
    <a href="#" data-i="{{ $i }}" class="eliminar_archivo">Eliminar</a>
    @endif

</div>
