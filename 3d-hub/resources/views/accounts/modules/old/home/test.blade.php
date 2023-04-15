@extends($_layout.'master')
@section('title', "Trang chủ")
    
@section('content')
<div class="ms-panel">
    <div class="ms-panel-body">
        @include($_template.'filter.daterange',[
                'sortable' => [
                    'name' => 'Tên',
                    'type' => 'Loại',
                    'balance' => 'Số dư'
                ],
                
            ])
        <div class="table-responsive">
            <table class="table table-bordered thead-primary smarttable" id="test-table">

            </table>
        </div>

    </div>
</div>
@endsection

@section('js')

<script>
    window.smarttableInit = function(){
        App.smarttable.init({
            el: '#test-table',
            filterForm: '.filter-form',
            urls: {!! json_encode([
                'data' => route('test')
            ]) !!},
            item: {
                id: '{$id}'
            },
            checklist: "id",
            pagination: {
                per_page: 100,
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
                    title: "Tên",
                    className: "",
                    sortby: "name",
                    content: '<span class="d-sm-none">Tên: </span>{$name}<div class="d-sm-none">Email: {$email}<br>Số dư: {$balance}<br>Reang5 thái: {$status_text}</div>'
                },
                {
                    title: "Email",
                    className: "hide-xs",
                    
                    sortby: "email",
                    content: '{$email}'
                },
                {
                    title: "Loại user",
                    className: "hide-sm text-center",
                    sortby: "type",
                    content: '{$type_text}'
                },
                {
                    title: "Só lần cược",
                    className: "hide-md text-center",
                    sortby: "pkay_count",
                    content: '{$play_count}'
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
                    title: "Act",
                    className: "text-center",
                    content: '<a href="{{route("branchs.users.update")}}/{$id}" data-name="{$name}"><i class="fas fa-pencil-alt text-secondary"></i></a>' + 
                            '<a href="{{route("branchs.users.rates")}}/{$id}" title="Tỉ lệ ăn cược"><i class="fa fa-superscript text-secondary"></i></a>' +
                            '<a class="btn-deactive-item status-{$status}" href="#" data-id="{$id}" data-name="{$name}"><i class="fa fa-ban ms-text-warning"></i></a>' +
                            '<a class="btn-trash-item" href="#" data-id="{$id}" data-name="{$name}"><i class="far fa-trash-alt ms-text-danger"></i></a>'
                }

            ]
        })
    }
</script>
<script src="{{asset('assets/app/js/app.smarttable.js')}}"></script> 
@endsection