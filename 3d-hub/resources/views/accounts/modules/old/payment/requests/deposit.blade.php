@php
    $profile = getUser();
@endphp
@extends($_layout.'master')
@section('title', 'Yêu cầu nạp điểm')
@section('show_sidebar', 1)

{{-- @section('header_title', "Thanh toán") --}}

@section('content')



<div class="row">
    <div class="col-xl-6 col-md-10 col-lg-8 mx-auto">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>Yêu cầu nạp điểm</h6>
            </div>
            <div class="ms-panel-body">
                <form method="POST" action="{{route('payment.requests.deposit')}}" class="smart-form auto-validation" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="amount">Số điểm</label>
                            <div class="input-group">
                                <input type="number" name="amount" step="1" min="1" class="form-control {{($amount = $errors->first('amount'))?'is-invalid':''}}" id="amount"
                                    placeholder="Số điểm" required>
                                <div class="invalid-feedback">
                                    {{$amount?$amount:"Vui lòng nhập số điểm"}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-4 d-block w-100" type="submit">Gửi yêu cầu</button>
                </form>
            </div>
        </div>
    </div>
</div>

    
@endsection