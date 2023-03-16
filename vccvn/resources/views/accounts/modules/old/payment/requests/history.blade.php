@php
$profile = getUser();
@endphp
@extends($_layout.'master')
@section('title', 'Lịch sử yêu cầu')
@section('header_title', 'Lịch sử yêu cầu')
@section('show_sidebar', 1)
@section('content')



                    <div class="ms-panel">
                        <div class="ms-panel-body">
                            @include($_template.'filter.daterange',[
                                'searchable' => [
                                    'name' => 'Tên',
                                    'email' => 'Email'
                                ],
                                'sortable' => [
                                    'name' => 'Tên',
                                    'email' => 'email',
                                    'amount' => 'Số điểm',
                                    'status' => 'Trạng thái',
                                    'created_at' => 'Thời gian tạo'
                                ],
                                
                            ])
                            @if (count($paymentRequests))
                                
                            <div class="table-responsive">
                                <table class="table table-bordered thead-primary type-table smart-table smart-data-table sortable" data-title="Yêu cầu thanh toán">
                                    <thead>
                                        <tr>
                                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}">ID <i class="fa fa-{$icon}"></i></th>',null, 'id') !!}
                                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="text-center">Yêu cầu <i class="fa fa-{$icon}"></i></th>',null, 'type') !!}
                                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="text-center">Số điểm <i class="fa fa-{$icon}"></i></th>',null, 'amount') !!}
                                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="hide-xs text-center">Thời gian <i class="fa fa-{$icon}"></i></th>',null, 'created_at') !!}
                                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="text-center">Trạng thái <i class="fa fa-{$icon}"></i></th>',null, 'status') !!}
                                            <th scope="col" class="text-center">X</th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paymentRequests as $item)
                                            
                                        <tr id="smart-item-{{$item->id}}" class="smart-item" data-id="{{$item->id}}" data-name="{{$item->name}}" data-amount="{{$item->amount}}">
                                            <th scope="row">{{$item->id}}</th>
                                            <td class="text-center">{{$item->getTypeText()}}</td>
                                            <td class="text-center">{{nbformat($item->amount)}}</td>
                                            <td class="hide-xs text-center">{{$item->created_at}}</td>
                                            <td class="text-center status">{{$item->getStatusText()}}</td>
                                            <td class="text-center">
                                                {{-- <a href="{{route('admin.bettings.types.update',['id' => $item->id])}}"><i class="fas fa-pencil-alt text-secondary"></i></a> --}}

                                                @if ($item->isPending())
                                                <a class="btn-action cancel" href="#" data-id="{{$item->id}}"><i class="fa fa-ban ms-text-danger"></i></a>
                                                @endif
                                                {{-- <a class="btn-trash-item" href="#" data-id="{{$item->id}}"><i class="far fa-trash-alt ms-text-danger"></i></a> --}}
                                            </td>
                                            
                                        </tr>
                                        
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{$paymentRequests->links($_template.'pagination')}}
                            @else
                                <div class="alert alert-danger text-center">Không có yêu cầu nào</div>
                            @endif
                        </div>
                    </div>
@endsection



@section('js')
<script>
    paymentOptions = {
        urls: {!! json_encode([
            'cancel' => route('payment.requests.cancel')
            
        ]) !!}
    }
</script>
<script src="{{asset('assets/app/js/app.payment.js')}}"></script>
    
@endsection