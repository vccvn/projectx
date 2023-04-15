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
@section('title', 'Kết quả xổ số')
{{-- @section('header_title', 'Kết quả xổ số') --}}
@section('show_sidebar', 1)
@section('content')



    <div class="ms-panel">
        <div class="ms-panel-header">
            <h6>Kết quả xổ số {{$area?$area->name:''}}
                <a href="{{route('admin.jackpots.add', $addArgs)}}" class="btn btn-primary">Thêm</a>

                <a href="{{route('admin.jackpots.addmore', $addArgs)}}" class="btn btn-success">Thêm toàn bộ</a>
            </h6>
        </div>
        <div class="ms-panel-body">
            @include($_current.'filter',[
                'sortable' => [
                    'area_name' => 'Khu vực',
                    'order' => 'Loại giải',
                    'open_date' => 'Ngày mở thưởng'
                ],
                
            ])
                
            <div class="table-responsive">
                <table id="betting-jackpots" class="table table-bordered thead-primary type-table smart-table smart-data-table sortable text-sm-center" 
                    data-title="Kết quã giải"
                    >
                    
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
@endsection



@section('js')

<script>
    window.smarttableInit = function(){
        App.smarttable.add("list", {
            el: '#betting-jackpots',
            filterForm: '.filter-form',
            urls: {!! json_encode([
                'data' => route('admin.jackpots.list.data', $routeArgs),
                'trash' => route('admin.jackpots.move-to-trash'),
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
                size: 10
            },

            columns: [
                {
                    title: "Khu vực",
                    className: "hide-xs ",
                    sortby: "area_name",
                    content: '<a href="{{route('admin.jackpots.area-result')}}/{$area_slug}">{$area_name}</a>'
                },
                {
                    title: "Loại giải",
                    className: "hide-xs ",
                    sortby: "order",
                    content: '{$order_text}'
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
                            '<strong>Khu vực:</strong> <a href="{{route('admin.jackpots.area-result')}}/{$area_slug}">{$area_name}</a>' +
                            '<br>' + 
                            '<strong>Loại giải:</strong> {$order_text}' +
                            '<br>' +
                            '<strong>Mở thưởng:</strong> {$open_date}' +
                        '</div>' +
                        '<span class="d-md-none"><strong>Kết quả</strong>:</span>' + 
                        '{$number}'
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
                    content: '<a href="{{route("admin.jackpots.update")}}/{$id}" data-name="{$number}"><i class="fas fa-pencil-alt text-secondary"></i></a>' + 
                            '<a class="btn-trash-item" href="#" data-id="{$id}" data-name="{$number}"><i class="far fa-trash-alt ms-text-danger"></i></a>'
                }

            ],
            parseItem: function(item){
                // item.number = item.numbers && item.numbers.length ? item.numbers.join('; ') : '';
            }
        });

    }
</script>
<script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
@endsection