
@php
$profile = getUser();
@endphp
@extends($_layout.'admin')
@section('title', 'Danh sách user')
@section('header_title', 'Người dùng')

@section('content')



    <div class="ms-panel">
        <div class="ms-panel-body">
            @include($_template.'filter.default',[
                'searchable' => [
                    'name' => 'Tên',
                    'email' => 'Tên',
                    
                ],
                'sortable' => [
                    'name' => 'Tên',
                    'id' => 'ID',
                    'balance' => 'Số dư',
                    'updated_at' => 'Thời gian Cập nhật'
                ],
                
            ])
            <div class="table-responsive">
                <table id="user-data-table" class="table table-bordered thead-primary user-table smarttable data-table" data-title="Người dùng">
                </table>
            </div>
        </div>
    </div>
@endsection


@section('js')


<script>
    window.smarttableInit = function(){
        App.smarttable.add("users", {
            el: '#user-data-table',
            filterForm: '.filter-form',
            urls: {!! json_encode([
                'trash' => route('admin.users.move-to-trash'),
                'restore' => route('admin.users.restore'),
                'deactive' => route('admin.users.deactive'),
                'data' => route('admin.users.ajax-list'),
            ]) !!},
            item: {
                id: 'id'
            },
            tools:["deactive", 'trash'],
            checklist: "id",
            pagination: {
                per_page: 10,
                size: 10
            },
            columns: [
                {
                    title: "Tên",
                    className: "",
                    sortby: "name",
                    content: '<span class="d-sm-none">Tên: </span><a href="{{route('admin.users.detail')}}/{$id}">{$name}</a><div class="d-sm-none max-150">Email: {$email}<br>Số dư: {$balance}<br>Trạng thái: {$status_text}</div>'
                },
                {
                    title: "Email",
                    className: "hide-xs",
                    
                    sortby: "email",
                    content: '<div style="width:150px; overflow:hidden">{$email}</div>'
                },
                {
                    title: "Nhánh",
                    className: "hide-sm text-center",
                    content: '{$branch.name}'
                },
                {
                    title: "Loại user",
                    className: "hide-sm text-center",
                    sortby: "type",
                    content: '{$type_text}'
                },
                {
                    title: "Số dư",
                    className: "hide-sm ",
                    sortby: "balance",
                    content: '{$balance}'
                },
                {
                    title: "Trạng thái",
                    className: "hide-sm text-center",
                    sortby: "status",

                    content: '{$status_text}'
                },
                {
                    title: "#",
                    className: "text-center",
                    content: '<a href="{{route("admin.users.update")}}/{$id}" data-name="{$name}"><i class="fas fa-pencil-alt text-secondary"></i></a>' + 
                            '<a class="btn-deactive-item status-{$status}" href="#" data-id="{$id}" data-name="{$name}"><i class="fa fa-ban ms-text-warning"></i></a>' +
                            '<a class="btn-trash-item" href="#" data-id="{$id}" data-name="{$name}"><i class="far fa-trash-alt ms-text-danger"></i></a>'
                }

            ],
            numberFormat: ['balance', 'point_out', 'point_in', 'user_count']
        })
    }
</script>
<script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>


@endsection