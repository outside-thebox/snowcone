@if(Session::has('alert'))
    <p class="alert alert-success" id="message-confirmation">
        {{ Session::get('alert') }}
    </p>
@endif