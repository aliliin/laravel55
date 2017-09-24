<form action="{{route('statuses.store')}}" method="POST">
    {{csrf_field()}}
    <textarea class="form-control" rows="3" placeholder="聊聊新鲜事儿..." name="content"></textarea>
    <button type="submit" class="btn btn-success pull-right">发布</button>

    @include('shared._errors')
</form>