{{ Form::button('Primera',['id' => 'first','class' => 'btn btn-warning',''=>'', '@click.prevent'=>'buscar(first)']) }}
{{ Form::button('Anterior',['id' => 'prev','class' => 'btn btn-warning', '@click.prevent'=>'buscar(prev)']) }}
{{ Form::button('Última',['id' => 'last','class' => 'btn btn-warning pull-right','style' => 'margin-left: 5px', '@click.prevent'=>'buscar(last)']) }}
{{ Form::button('Siguiente',['id' => 'next','class' => 'btn btn-warning pull-right', '@click.prevent'=>'buscar(next)']) }}
