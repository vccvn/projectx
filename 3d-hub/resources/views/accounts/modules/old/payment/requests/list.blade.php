@php
$profile = getUser();
@endphp
@extends($_layout.'master')
@section('title', 'Danh sách Yêu cầu thanh toán')
@section('header_title', 'Yêu cầu thanh toán')
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
                                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}">Tên <i class="fa fa-{$icon}"></i></th>',null, 'name') !!}
                                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="hide-xs text-center">Email <i class="fa fa-{$icon}"></i></th>',null, 'email') !!}
                                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="text-center">Yêu cầu <i class="fa fa-{$icon}"></i></th>',null, 'type') !!}
                                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="text-center">Số điểm <i class="fa fa-{$icon}"></i></th>',null, 'amount') !!}
                                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="hide-xs text-center">Thời gian <i class="fa fa-{$icon}"></i></th>',null, 'created_at') !!}
                                            {!! render_sort_url('<th scope="col" data-url="{$url}" data-active="{$active}" class="text-center hide-xs">Trạng thái <i class="fa fa-{$icon}"></i></th>',null, 'status') !!}
                                            <th scope="col" class="text-center">X</th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paymentRequests as $item)
                                            
                                        <tr id="smart-item-{{$item->id}}" class="smart-item" data-id="{{$item->id}}" data-name="{{$item->name}}" data-amount="{{$item->amount}}">
                                            <th scope="row">{{$item->id}}</th>
                                            <td class="name">
                                                <span class="d-sm-none">Tên: </span>
                                                {{$item->name}}
                                                <div class="d-sm-none">
                                                    Email: {{$item->email}}
                                                    <br>
                                                    Trạng thái: {{$item->getStatusText()}}
                                                </div>
                                                
                                            </td>
                                            <td class="email hide-xs text-center">{{$item->email}}</td>
                                            <td class="text-center">{{$item->type_text}}</td>
                                            <td class="text-center">{{nbformat($item->amount_text)}}</td>
                                            <td class="hide-xs text-center">{{$item->created_time}}</td>
                                            <td class="hide-xs text-center status">{{$item->status_text}}</td>
                                            <td class="text-center">
                                                {{-- <a href="{{route('admin.bettings.types.update',['id' => $item->id])}}"><i class="fas fa-pencil-alt text-secondary"></i></a> --}}

                                                @if ($item->isPending())
                                                <a class="btn-action approve" href="#" data-id="{{$item->id}}"><i class="fa fa-check-circle ms-text-success"></i></a>
                                                <a class="btn-action decline" href="#" data-id="{{$item->id}}"><i class="fa fa-ban ms-text-warnibg"></i></a>
                                                @elseif($item->isType(['deposit', 'withdraw']) && ($item->isDeclined() || ($item->isApproved() && $item->canUndo('approve'))))
                                                <a class="btn-action undo" href="#" data-id="{{$item->id}}"><i class="fa fa-undo ms-text-success"></i></a>
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
            'approve' => route('payment.requests.approve'),
            'decline' => route('payment.requests.decline'),
            'undo' => route('payment.requests.undo')
            
        ]) !!}
    }
</script>
<script src="{{asset('assets/app/js/app.payment.js')}}"></script>
    
@endsection