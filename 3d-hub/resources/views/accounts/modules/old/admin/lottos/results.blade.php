@php
$profile = getUser();
$addArgs = [];
$routeArgs = [];
if($area){
    $addArgs['area_id'] = $area->id;
    $routeArgs['area'] = $area->slug;
}
$addArgs['open_date'] = ($od = request()->open_date)?$od:date('Y-m-d');
@endphp
@extends($_layout.'admin')
@section('title', 'Kết quả Lotto')
{{-- @section('header_title', 'Kết quả xổ số') --}}
@section('show_sidebar', 1)
@section('content')



    <div class="ms-panel">
        <div class="ms-panel-header">
            <h6>Kết quả lotto {{$area?$area->name:''}}
                <div class="d-block d-md-inline-block mt-2 mt-md-0">
                    <a href="{{route('admin.lottos.add', $addArgs)}}" class="btn btn-primary">Thêm</a>

                <a href="#" class="btn btn-success btn-import" id="btn-import">Nhập từ kết quả Xổ số</a>
                </div>
            </h6>
        </div>
        <div class="ms-panel-body">
            @include($_current.'filter',[
                'sortable' => [
                    'area_name' => 'Khu vực',
                    'type_name' => 'Loại cược',
                    'open_date' => 'Ngày mở thưởng'
                ],
                
            ])
            <div class="table-responsive">
                <table id="betting-lottos" class="table table-bordered thead-primary type-table smart-table smart-data-table sortable text-sm-center" 
                    data-title="Kết quã giải">
                    
                </table>
            </div>
            
        </div>
    </div>
@endsection



@section('js')
<script>
    window.smarttableInit = function(){
        var $lottos = App.smarttable.setup("list", {
            el: '#betting-lottos',
            filterForm: '.filter-form',
            urls: {!! json_encode([
                'data' => route('admin.lottos.list.data', $routeArgs),
                'trash' => route('admin.lottos.move-to-trash'),
            ]) !!},
            item: {
                id: 'id'
            },
            checklist: "id",
            tools: ["trash"],
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
                    title: "Khu vực",
                    className: "hide-xs ",
                    sortby: "area_name",
                    content: '<a href="{{route('admin.lottos.area-result')}}/{$area_slug}">{$area_name}</a>'
                },
                {
                    title: "Loại cược",
                    className: "hide-xs ",
                    sortby: "type_name",
                    content: '{$type_name}'
                },
                {
                    title: "Ngày mở thưởng",
                    className: "hide-xs",
                    sortby: "open_date",
                    content: '{$open_date}'
                },
                {
                    title: "Kết quả",
                    className: "max-300",
                    sortby: "number",
                    content: '<div class="d-md-none">' +
                            '<strong>Khu vực:</strong> <a href="{{route('admin.lottos.area-result')}}/{$area_slug}">{$area_name}</a>' +
                            '<br>' + 
                            '<strong>Loại cược:</strong> {$type_name}' +
                            '<br>' +
                            '<strong>Mở thưởng:</strong> {$open_date}' +
                        '</div>' +
                        '<span class="d-md-none"><strong>Kết quả</strong>:</span>' + 
                        '{$number_str}'
                },
                {
                    title: "Cập nhật",
                    className: "hide-xs",
                    sortby: "updated_at",
                    content: '{$updated_time}'
                },
                {
                    title: "#",
                    className: "text-center",
                    content: '<a href="{{route("admin.lottos.update")}}/{$id}" data-name="{$number}"><i class="fas fa-pencil-alt text-secondary"></i></a>' + 
                            '<a class="btn-trash-item" href="#" data-id="{$id}" data-name="{$number}"><i class="far fa-trash-alt ms-text-danger"></i></a>'
                }

            ],
            parseItem: function(item){

            }
        });
        var $table = App.smarttable.get("list");
            $('#btn-import').click(function(e){
                e.preventDefault();
                var data = {!! json_encode($addArgs) !!};
                data.open_date = $table.getFilterData().open_date || App.date("Y-m-d");
                    
                App.Swal.confirm("Hãy cẩn thận! <br>Hành đỗng này có thể ghi dè dữ liệu hiện có trong ngày "+data.open_date+"!<br>Bạn có muôn tiếp tục không?", function(){
                    showLoading();
                    App.api.post("{{route('admin.lottos.import')}}", data)
                        .then(function(res){
                            if(res.status){
                                App.Swal.success("Đã import được " + res.data.length + " kết quả! ", null, function(){
                                    $table.reload();
                                })
                                
                            }else{
                                App.Swal.warning(res.message);
                            }
                        })
                        .catch(function(error){
                            App.Swal.error("Lỗi không xác định");

                        })
                })
            })
    }
</script>
<script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>

    {{-- <script src="{{asset('assets/app/js/app.table.js')}}"></script>  --}}
    <script>
        $(function(){
            
        })
    </script>
@endsection