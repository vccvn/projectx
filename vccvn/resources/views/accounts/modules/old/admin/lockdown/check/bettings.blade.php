@php
$profile = getUser();
@endphp
@extends($_layout.'admin')
@section('title', 'Kiểm tra Cược')
{{-- @section('header_title', 'Kết quả xổ số') --}}
@section('show_sidebar', 1)
@section('content')



    <div class="ms-panel">
        
        <div class="ms-panel-body">
            @include($_current.'tool')
            <div class="table-responsive">
                <table id="lockdown-backup" class="table table-bordered thead-primary smarttable text-sm-center">
                    
                </table>
            </div>
            
        </div>
    </div>
@endsection

@section('css')
    <style>
        .dch div.data-numbers{
            height: 0;
            overflow: hidden;
            visibility: hidden;
            opacity: 0;
            transition: all ease-in-out 0.3s;
        }
        .dch.click div.data-numbers{
            height: auto;
            overflow: auto;
            visibility: visible;
            opacity: 1;
        }
        
    </style>
@endsection


@section('js')
<script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>

<script>
    window.checkoutInit = function(){
        App.setCheckoutBetting({
            el: '#lockdown-backup',
            filterForm: '.tool1-form',
            urls: {!! json_encode([
                'data' => route('admin.lockdown.checkout.bettings.change-logs'),
                'compare' => route('admin.lockdown.checkout.bettings.compare'),
                'lock' => route('admin.bettings.lock'),
                'unlock' => route('admin.bettings.unlock'),
                // 'deactive' => route('admin.users.deactive')
            ]) !!}
            
        });

    }
</script>
<script src="{{asset('assets/app/js/checkout.bettings.js')}}"></script>


@endsection