@php
$profile = getUser();
$addArgs = [];
$routeArgs = [];
$table = null;
if($t = request()->route('table')){
    $routeArgs['table'] = $t;
    $table = $t;
}
$addArgs['open_date'] = ($od = request()->open_date)?$od:date('Y-m-d');
@endphp
@extends($_layout.'admin')
@section('title', 'Chốt sổ')
{{-- @section('header_title', 'Kết quả xổ số') --}}
@section('show_sidebar', 1)
@section('content')



    <div class="ms-panel">
        
        <div class="ms-panel-body">
            @include($_current.'tool',[
                'sortable' => [
                    'table_name' => 'Khu vực',
                    'baclup_at' => 'Thời gian backup',
                    'open_date' => 'Ngày mở thưởng'
                ],
                
            ])
            <div class="table-responsive">
                <table id="lockdown-backup" class="table table-bordered thead-primary smarttable text-sm-center">
                    
                </table>
            </div>
            
        </div>
    </div>
@endsection



@section('js')
<script>
    window.smarttableInit = function(){
        App.smarttable.add("list", {
            el: '#lockdown-backup',
            filterForm: '.tool-form',
            urls: {!! json_encode([
                'data' => route('admin.lockdown.backup.list.data', $routeArgs),
                'trash' => route('admin.lockdown.backup.move-to-trash'),
            ]) !!},
            item: {
                id: 'id'
            },
            // checklist: "id",
            // tools: ["trash"],
            handle: {
                onTrash: function(ids){
                    // App.smarttable.reload("trash");
                }
            },
            pagination: {
                per_page: 10,
                size: 5
            },

            columns: [
                {
                    title: "Bảng",
                    className: "",
                    sortby: "table_name",
                    content: '<a href="{{route('admin.lockdown.backup.list')}}/{$table_name}">{$table_name}</a>'
                },
                {
                    title: "Thời gian backup",
                    className: "",
                    sortby: "backup_at",
                    content: '{$backup_at}'
                },
                {
                    title: "Tải vè",
                    className: "text-center",
                    content: '<a href="#" data-id="{$id}" class="btn-download mr-2" data-format="json"><i class="fa fa-file-code text-warning mr-0"></i> JSON</a>' + 
                             '<a href="#" data-id="{$id}" class="btn-download" data-format="xlsx"><i class="fa fa-file-excel text-success mr-0"></i> Excel</a>'
                }

            ]
        });

    }
</script>
<script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>

    {{-- <script src="{{asset('assets/app/js/app.table.js')}}"></script>  --}}
    <script>
        $(function(){
            var $table = App.smarttable.get("list");
            var downloadUrl = "{{route('admin.lockdown.backup.download.url')}}";
            $(document).on("click", '.btn-download', function(e){
                e.preventDefault();
                App.api.post(downloadUrl, {
                    id: $(this).data('id'),
                    format: $(this).data("format")
                })
                .then(res => {
                    if(res.status){
                        top.location.href = res.data.url;
                    }else{
                        App.Swal.warning(res.message);
                    }
                }).catch(err => {
                    App.Swal.error("Lỗi không xác định!");
                    console.log(err)
                })
            });
            var backupUrls = {
                users: "{{route('admin.lockdown.backup.users')}}",
                bettings: "{{route('admin.lockdown.backup.bettings')}}",
                lottos: "{{route('admin.lockdown.backup.lottos')}}"
            }
            $(document).on("click", '.btn-backup', function(e){
                e.preventDefault();
                var table = $(this).data('table');
                if(typeof backupUrls[table] != "undefined"){
                    showLoading();
                    App.api.post(backupUrls[table], {
                        key: App.str.rand(),
                        format: $(this).data("format")
                    })
                    .then(res => {
                        if(res.status){
                            $table.reload();
                        }else{
                            App.Swal.warning(res.message);
                        }
                    }).catch(err => {
                        App.Swal.error("Lỗi không xác định!");
                        console.log(err)
                    })
                }
                
            })
        })
    </script>
@endsection