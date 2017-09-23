@if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <l1>{{$error}}</l1>
            @endforeach
        </ul>
    </div>
@endif