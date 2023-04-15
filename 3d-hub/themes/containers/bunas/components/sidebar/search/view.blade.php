<div class="sidebar-item search">
    <div class="title">
        <h4>{{$data->title}}</h4>
    </div>
    <div class="sidebar-info">
        <form method="GET" action="{{route('client.search')}}">
            <input type="text" class="form-control" name="s">
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>