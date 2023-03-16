@extends($_layout.'master')
@section('title', $account->formConfig->title)
@section('header_title', "Thiết lập")

@section('content')



<div class="row">
    <div class="col-xl-6 col-md-10 col-lg-8 mx-auto">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>{{$account->formConfig->title}}</h6>
            </div>
            <div class="ms-panel-body">
                <form method="POST" action="{{route('accounts.settings.tab', ['tab' => $account->formConfig->slug])}}" class="smart-form auto-validation" novalidate>
                    @csrf
                    <div class="form-row">
                        
                        @if ($form = $account->form)
                            <?php
                                $form->map('addClass', 'form-control');
                            ?>
                            @foreach ($form as $input)
                                <div class="col-md-12 mb-3">
                                    <label for="{{$input->id}}" class="form__label">{{$input->label}}</label>
                                    <div class="input-group">
                                        @php
                                            if($input->error){
                                                $input->addClass('is-invalid');
                                            }
                                        @endphp
                                        {!!$input!!}
                                        <div class="invalid-feedback">{{$input->error?$input->error:"Vui lòng nhập Mật khẩu hiện tại"}}</div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button class="btn btn-primary mt-4 d-block w-100" type="submit">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection