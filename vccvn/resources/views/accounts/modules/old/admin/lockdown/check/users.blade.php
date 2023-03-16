@php
$profile = getUser();
@endphp
@extends($_layout.'admin')
@section('title', 'Kiểm tra user')
{{-- @section('header_title', 'Kết quả xổ số') --}}
@section('show_sidebar', 1)
@section('content')



    <div class="ms-panel">
        
        <div class="ms-panel-body">
            @include($_current.'tool', [
                'form_id' => 'upload-user-form'
            ])
            <div class="table-responsive">
                <table id="checkout-user" class="table table-bordered thead-primary smarttable text-sm-center">
                    
                </table>
            </div>
            
        </div>
    </div>
@endsection



@section('js')
<script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>

<script>
    window.checkoutUserInit = function(){
        App.setCheckoutUser({
            el: '#checkout-user',
            filterForm: '.tool1-form',
            urls: {!! json_encode([
                'data' => route('admin.lockdown.checkout.users.change-logs'),
                'compare' => route('admin.lockdown.checkout.users.compare'),
                // 'restore' => route('admin.users.restore'),
                'lock' => route('admin.users.deactive'),
                'unlock' => route('admin.users.active')
            ]) !!}
            
        });

    }
</script>
<script src="{{asset('assets/app/js/checkout.users.js')}}"></script>

@endsection