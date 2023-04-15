
@php
$profile = getUser();
@endphp
@extends($_layout.'admin')
@section('title', 'Danh sách Ngân hàng')
@section('header_title', 'Ngân hàng')

@section('content')



                    <div class="ms-panel">
                        <div class="ms-panel-body">
                            @include($_template.'filter.default',[
                                'searchable' => [
                                    'name' => 'Tên',
                                    'area' => 'Khu vực',
                                    'branch' => 'Chi nhánh',
                                    
                                ],
                                'sortable' => [
                                    'name' => 'Tên',
                                    'area' => 'Khu vực',
                                    'branch' => 'Chi nhánh',
                                    'updated_at' => 'Thời gian Cập nhật'
                                ],
                                
                            ])
                            <div class="table-responsive">
                                <table id="bank-data-table" class="table table-bordered thead-primary bank-table smarttable data-table" data-title="Người dùng">
                                </table>
                            </div>
                        </div>
                    </div>
@endsection


@section('js')

<script>
    window.smarttableInit = function(){
        App.smarttable.add("list", {
            title: "Ngân hàng",
            el: '#bank-data-table',
            filterForm: '.filter-form',
            urls: {!! json_encode([
                'trash' => route('admin.banks.move-to-trash'),
                'restore' => route('admin.banks.restore'),
                'data' => route('admin.banks.list-data'),
                
            ]) !!},
            
            item: {
                id: 'id'
            },
            checklist: "id",
            tools: [
                "trash"
            ],
            // handle: {
            //     onTrash: function(ids){
            //         // App.smarttable.reload("trash");
            //     }
            // },
            pagination: {
                per_page: 10,
                size: 10
            },
            columns: [
                {
                    title: "ID",
                    className: "text-center",
                    scope: "row",
                    orderby: 'id',
                    content: "{$id}"
                },
                {
                    title: "Tên ngân hàng",
                    className: "",
                    orderby: 'name',
                    content: '<span class="d-sm-none"><strong>Tên</strong>: </span>{$name}<div class="d-sm-none"><strong>Khu vực</strong>: {$area}<br><strong>Chi nhánh</strong>: {$branch}</div>'
                },
                {
                    title: "Khu vực",
                    className: "hide-xs",
                    orderby: 'area',
                    content: '{$area}'
                },
                {
                    title: "Chi nhánh",
                    className: "hide-sm",
                    orderby: 'branch',
                    content: '{$branch}'
                },
                {
                    title: "#",
                    className: "text-center",
                    content: '<a href="{{route("admin.banks.update")}}/{$id}" data-name="{$name}"><i class="fas fa-pencil-alt text-secondary"></i></a>' + 
                            '<a class="btn-trash-item" href="#" data-id="{$id}" data-name="{$name}"><i class="far fa-trash-alt ms-text-danger"></i></a>'
                },

                
            ]
        });

    }
</script>
<script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>

    
@endsection