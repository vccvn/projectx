@extends($_layout.'master')
@section('show_sidebar', 1)
@section('title', 'Thông báo')
@section('content')

    <div class="ms-panel">
        <div class="ms-panel-header">
            @include($_template.'filter.date',[
                'searchable' => [
                    'message' => 'Nội dung'
                ],
                'sortable' => [
                    'created_at' => 'Thời gian'
                ],
                
            ])
        
        </div>
        <div class="ms-panel-body">
            
            <div class="final-step">
                <div class="table-responsive">
                    <table id="audits" class="table table-bordered table-tribed thead-primary type-table smarttable" >
    
                    </table>
                </div>    
            </div>


        </div>
    </div>
@endsection


@section('js')
    <script>

    window.smarttableInit = function(){
        var $audits = App.smarttable.setup({
            el: '#audits',
            filterForm: '.filter-form',
            // filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'           => route('notifications.list.data')
            ]) !!},
            pagination: {
                per_page: 10,
                size: 5
            },
            items:{
                id: "{$id}",
                read: "{$read}"
            },
            columns: [
                {
                    title: "Nội dung thông báo",
                    className: "max-500",
                    sortby: 'message',
                    content: '<a class="notify-item" href="javascript:void(0)" data-id="{$id}" data-read="{$read}" data-type="{$type}" data-url="{$url}"><div class="test">{$message}</div></a>'
                },
                {
                    title: "Thời gian",
                    className: "hide-xs",
                    sortby: 'created_at',
                    content: '{$time_ago}'
                },
                {
                    title: "Trạng thái",
                    className: "hide-xs",
                    sortby: 'read',
                    content: '{$read_text}'
                },
                {
                    title: "Thao tác",
                    className: "",
                    // sortby: 'action',
                    content: '{$action}'
                }
            ],
            autoload: false,
            data: {!! json_encode($notifications) !!}
        });
        

    }
    </script>
    {{-- <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script> --}}
    

    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    
@endsection