@php
$profile = getUser();
@endphp
@extends($_layout.'admin')
@section('title', 'Danh sách cược')
{{-- @section('header_title', 'Danh sách cược') --}}
{{-- @section('show_sidebar', 1) --}}
@section('content')



    <div class="ms-panel">
        <div class="ms-panel-body">
            @include($_template.'filter.daterange',[
                'sortable' => [
                    'area_name' => 'Khu vực',
                    'type_name' => 'Hình thức',
                    'points' => 'Điểm',
                    'total_point' => 'Tổng điểm',
                    'created_at' => 'Thời gian tạo'
                ],
                
            ])
            @if (count($history))
                
            <div class="table-responsive">
                <table id="betting-history" class="table table-bordered thead-primary type-table smart-table smart-data-table sortable text-sm-center" data-title="Cược">
                    <thead>
                        <tr>
                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="hide-sm">Thời gian chơi <i class="fa fa-{$icon}"></i></th>',null, 'id') !!}
                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="hide-sm">Loại giải <i class="fa fa-{$icon}"></i></th>',null, 'area_name') !!}
                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="hide-sm">Hình thức chơi <i class="fa fa-{$icon}"></i></th>',null, 'type_name') !!}
                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}">Số đặt cược <i class="fa fa-{$icon}"></i></th>',null, 'str_numbers') !!}

                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}">Điểm <i class="fa fa-{$icon}"></i></th>',null, 'points') !!}
                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="hide-sm">Số con <i class="fa fa-{$icon}"></i></th>',null, 'number_count') !!}
                            
                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="hide-sm">Tổng điểm <i class="fa fa-{$icon}"></i></th>',null, 'total_point') !!}
                            <th scope="col" class="text-center"><div class="d-none d-sm-block">Trạng thái</div><div class="d-sm-none">TT</div></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($history as $item)
                            <tr id="history-{{$item->id}}">
                                <td class="hide-sm">{{$time = $item->dateFormat('H:i - d/m/Y')}}</td>
                                <td class="hide-sm">{{$item->area_name}}</td>
                                <td class="hide-sm">{{$item->type_name}}</td>
                                
                                <td class="max-300">
                                    <div class="d-md-none">
                                        <strong>Hình thức chơi:</strong> {{$item->type_name}}
                                        <br>
                                        <strong>Thời gian:</strong> {{$time}}
                                        
                                    </div>
                                    <span class="d-md-none"><strong>Số đã cược</strong>:</span>
                                    {{$item->subNumberText()}} 
                                    @if (count($item->numbers) > 1)
                                        <br>
                                        <a href="{{route('admin.bettings.detail', ['id' => $item->id])}}">Xem Chi tiết</a>
                                    @endif
                                </td>
                                <td>{{$item->points}}</td>
                                <td class="hide-sm">{{$item->number_count}}</td>
                                <td class="hide-sm">{{$item->total_point}}</td>
                                
                                <td class="text-center">
                                    {{$item->getStatusText()}}
                                </td>
                                
                            </tr>
        
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{$history->links($_template.'pagination')}}
            @else
                <div class="alert alert-danger text-center">Không có dữ liệu</div>
            @endif
        </div>
    </div>
@endsection



@section('js')
    {{-- <script src="{{asset('assets/app/js/betting.history.js')}}"></script>  --}}
@endsection