@php
$profile = getUser();

$addArgs = [];
$routeArgs = [];
if($area){
    $addArgs['area_id'] = $area->id;
    $routeArgs['area'] = $area->slug;
}
@endphp
@extends($_layout.'admin')
@section('title', 'Trình crawler')
{{-- @section('header_title', 'Danh sách cược') --}}
{{-- @section('show_sidebar', 1) --}}
@section('content')



    <div class="ms-panel">
        <div class="ms-panel-header">
            <h6>Trình crawler
            <a href="{{route('admin.crawlers.add')}}" class="btn btn-primary py-1 px-2">Thêm</a>
            </h6>
        </div>
        <div class="ms-panel-body">
            {{-- @include($_template.'filter.date',[
                'sortable' => [
                    'area_name' => 'Khu vực',
                    'url' => 'Đường dẫn',
                    'created_at' => 'Thời gian tạo'
                ]
                
            ]) --}}
            <div class="table-responsive">
                <table id="crawlers" class="table  table-striped smarttable " data-title="Crawler">
                    
                </table>
            </div>
            
        </div>
    </div>
@endsection



@section('js')


<script>
    window.smarttableInit = function(){
        App.smarttable.add("list", {
            el: '#crawlers',
            filterForm: '.filter-form',
            urls: {!! json_encode([
                'data' => route('admin.crawlers.list.data', $routeArgs),
                'trash' => route('admin.crawlers.move-to-trash'),
            ]) !!},
            item: {
                id: 'id'
            },
            checklist: "id",
            tools: [
                '<a class="btn btn-info btn-crawl-all px-2 py-1" href="#"><i class="fas fa-copy"></i></a>',
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
                    title: "Khu vực",
                    className: "hide-xs ",
                    sortby: "area_name",
                    content: '{$area_name}'
                },
                {
                    title: "Đường dẫn",
                    className: "hide-xs ",
                    sortby: "url",
                    content: '<div class="max-150 max-sm-250 max-md-300 max-lg-500 max-xl-600"><a href="{$url}" target="_blank">{$url}</a></div>'
                },
                {
                    title: "Lần crawl mới nhất",
                    className: "",
                    sortby: "crawled_at",
                    content: '{$crawled_time}'
                },
                {
                    title: "#",
                    className: "text-center",
                    content: '<a class="btn-crawl-item" href="#" data-id="{$id}"><i class="fas fa-copy text-success"></i></a>' + 
                            '<a href="{{route("admin.crawlers.update")}}/{$id}" data-name="{$area_name}"><i class="fas fa-pencil-alt text-secondary"></i></a>' + 
                            '<a class="btn-trash-item" href="#" data-id="{$id}" data-name="{$area_name}"><i class="far fa-trash-alt ms-text-danger"></i></a>'
                }

            ]
        });

    }
</script>
<script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>

<script>
    $(function(){
        var $table = App.smarttable.get("list");
        if(!$table) return;
        var crawlUrl = "{{route('admin.crawlers.crawl')}}";
        
        function crawl (id){
            App.modal.popup({
                title: "Crawl Kết quả xổ số",
                inputs: {
                    date: {
                        type: "text",
                        label: "Ngày tháng",
                        value: App.date("Y-m-d"),
                        className: "crawl-date"
                    }
                },
                done: function(data){
                    showLoading(500000);
                    App.api.post(crawlUrl, {id:id, date:data.date}).then(function(res){
                        setTimeout(function(){
                            if(res.status){
                                $table.reload();
                                App.Swal.success("Đã crawl " + res.data.length + " kết quả")
                            }else{
                                App.Swal.error(res.message);
                            }
                        }, 1000);
                    }).catch(function(error){
                        App.Swal.error("Lỗi không xác định");
                    });
                }
            }, null, function(){
                var $datePicker = $(".crawl-date");
                console.log($datePicker);
                if ($datePicker.length) {

                    $datePicker.each(function (i, el) {
                        var $el = $(el);
                        var format = $el.data('format') || "yy-mm-dd";
                        $el.datepicker({
                            dateFormat: format
                        });
                        // $( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
                    })
                }
            });
            
        }
        $(document).on("click", ".btn-crawl-all", function(e){
            e.preventDefault();
            var data = $table.getCheckedValues();
            if(data.length){
                crawl(data)
            }else{
                App.Swal.warning("Bạn chưa chọn mục nào");

            }
        });
        $(document).on("click", ".btn-crawl-item", function(e){
            e.preventDefault();
            var id = $(this).data("id");
            crawl(id)
            
        });
        
        

    });
</script>
@endsection