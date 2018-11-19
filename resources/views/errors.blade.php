@if (!$errors->isEmpty())
<div class="alert alert-danger" role="alert">
    <h3>Error</h3>
    <ul>
        @foreach ($errors->all() as $message)
            <li>{{$message}}</li>
        @endforeach
    </ul>
</div>
@endif      
