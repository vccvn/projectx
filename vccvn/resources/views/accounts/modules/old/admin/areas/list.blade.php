@extends($_layout.'admin')
@section('title', 'Thông tin Area')
@section('header_title', 'Area')

@section('content')

<div class="row">
    <div class="col-md-8">
        

        <div class="ms-panel">
            {{-- <div class="ms-panel-header">
                <h6>Danh dách</h6>
            </div> --}}
            <div class="ms-panel-body">
                @include($_template.'filter.simple',[
                    'searchable' => [
                        'name' => 'Tên'
                    ],
                    'sortable' => [
                        'id' => 'ID',
                        'name' => 'Tên',
                        'updated_at' => 'Thời gian Cập nhật'
                    ],
                    
                ])
                    
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered thead-primary smarttable" data-title="Area">
                        
                    </table>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>Thùng rác</h6>
            </div>
            <div class="ms-panel-body">
                <div class="table-responsive">
                    <table id="trash-table" class="table table-bordered thead-primary smarttable" data-title="Khu vực">
                        
                    </table>
                </div>
                
                <ul class="trash-areas">
                    {{-- @if(count($trashedAreas))
                        @foreach ($trashedAreas as $item)
                            <li id="trash-item-{{$item->id}}">
                                {{$item->name}} 
                                <a class="btn-restore-item" href="#" data-id="{{$item->id}}"><i class="fa fa-history ms-text-success"></i></a>
                            </li>

                        @endforeach
                    @endif --}}
                </ul>
            </div>
    </div>
</div>

@endsection


@section('js')


<script>
    window.smarttableInit = function(){
        App.smarttable.add("list", {
            el: '#data-table',
            filterForm: '.filter-form',
            urls: {!! json_encode([
                'data' => route('admin.areas.list.data'),
                'trash' => route('admin.areas.move-to-trash'),
            ]) !!},
            item: {
                id: 'id'
            },
            checklist: "id",
            tools: ["trash"],
            handle: {
                onTrash: function(ids){
                    App.smarttable.reload("trash");
                }
            },
            pagination: {
                per_page: 10,
                size: 10
            },

            columns: [
                {
                    title: "ID",
                    className: "text-center",
                    sortby: "id",
                    scope: "row",
                    content: "{$id}"
                },
                {
                    title: "Tên khu vực",
                    className: "",
                    sortby: "name",
                    content: '{$name}'
                },
                {
                    title: "Thòi gian cập nhật",
                    className: "",
                    sortby: "updated_at",
                    content: '{$time}'
                },
                {
                    title: "#",
                    className: "text-center",
                    content: '<a href="{{route("admin.areas.update")}}/{$id}" data-name="{$name}"><i class="fas fa-pencil-alt text-secondary"></i></a>' + 
                            '<a class="btn-trash-item" href="#" data-id="{$id}" data-name="{$name}"><i class="far fa-trash-alt ms-text-danger"></i></a>'
                }

            ]
        });


        App.smarttable.add("trash", {
            el: '#trash-table',
            // filterForm: '.filter-form',
            urls: {!! json_encode([
                'data' => route('admin.areas.trash.data'),
                'restore' => route('admin.areas.restore'),
            ]) !!},
            item: {
                id: 'id'
            },
            handle: {
                onRestore: function(ids){
                    App.smarttable.reload("list");
                }
            },
            pagination: {
                per_page: 20,
                size: 10
            },
            columns: [
                {
                    title: "Tên",
                    className: "",
                    sortby: "name",
                    content: '{$name}'
                },
                {
                    title: "#",
                    className: "text-center",
                    content: '<a class="btn-restore-item" href="#" data-id="{$id}" data-name="{$name}"><i class="fa fa-history ms-text-success"></i></a>'
                }

            ]
        })
    }
</script>
<script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>


@endsection