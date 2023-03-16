@php
$profile = getUser();
@endphp
@extends($_layout.'master')
@section('title', 'Chi tiết cược')
@section('header_title', 'Chi tiết cược')
@section('show_sidebar', 1)
@section('content')



<div class="row">
    @if ($betting)
        
    <div class="col-md-4">

        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>Thông tin</h6>
            </div>
            <div class="ms-panel-body">
                    
                <div class="table-responsive">
                    <table class="table table-bordered thead-primary type-table smart-table" data-title="Cược">
                        <thead>
                            <tr>
                                <th scope="col">Nhãn</th>
                                <th scope="col">Giá trị</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">Khu vực</td>
                                <td>{{$betting->area_name}}</td>
                            </tr>
                            <tr>
                                <td scope="row">Hình tdức chơi</td>
                                <td>{{$betting->type_name}}</td>
                            </tr>
                            <tr>
                                <td scope="row">Số đặt cược</td>
                                <td>{{$betting->subNumberText()}}</td>
                            </tr>
                            <tr>
                                <td scope="row">Điểm / con</td>
                                <td>{{$betting->points}}</td>
                            </tr>
                            <tr>
                                <td scope="row">Số con</td>
                                <td>{{$betting->number_count}}</td>
                            </tr>
                            <tr>
                                <td scope="row">Tổng điểm</td>
                                <td>{{$betting->total_point}}</td>
                            </tr>
                            <tr>
                                <td scope="row">Thời gian</td>
                                <td>{{$betting->dateFormat('H:i - d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <td scope="row">Trạng thái</td>
                                <td>
                                    {{$betting->getStatusText()}}
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        

        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>Chi tiết</h6>
            </div>
            <div class="ms-panel-body">
                @if (count($betting->numbers))
                    
                <div class="table-responsive">
                    <table id="betting-history" class="table table-bordered thead-primary type-table smart-table smart-data-table sortable text-center" data-title="Cược">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Số</th>
                                <th scope="col" class="text-center max-120">Điểm thắng</th>
                                <th scope="col" class="text-center">Trạng thái</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($betting->numbers as $item)
                                <tr id="history-{{$item->id}}">
                                    <td class="text-center">
                                        {{$item->number}}
                                    </td>
                                    <td class="text-center max-120">
                                        {{$item->is_win?($betting->rate*$betting->points*$item->is_win):'---'}}
                                    </td>
                                    <td class="text-center">
                                        @if (!$betting->isLock())
                                            Chờ
                                        @elseif($item->is_ein)
                                            Thắng {{$item->getStatusText()}} lần
                                        @endif
                                    </td>
                                    
                                </tr>
            
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="alert alert-danger text-center">Không có dữ liệu</div>
                @endif
            </div>
        </div>
        
    </div>
    
    @else
        <div class="col-12">
            <div class="alert alert-warning">
                Không có dữ liệu
            </div>
        </div>
    @endif
</div>
@endsection



@section('js')
    <script src="{{asset('assets/app/js/betting.history.js')}}"></script> 
@endsection