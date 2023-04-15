@php
    $profile = getUser();
    if(!$menu) $menu = [];
@endphp
@extends($_layout.'admin')
@section('title', 'Thiết lập hệ thống')
@section('header_title', 'Thiết lập hệ thống')

@section('content')



<div class="row">
    <div class="col-xl-8 col-md-10 col-lg-9 mx-auto">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>menu</h6>
            </div>
            <div class="ms-panel-body">
                <form method="POST" action="{{route('admin.setting.menu')}}" class="smart-form auto-validation" novalidate>
                    @csrf
                    <div class="form-row">
                        
                        <div class="col-sm-12">
                            <label for="menu">Menu Area</label>
                            <div class="input-group">
                                @include($_theme.'forms.templates.checklist', [
                                    'input' => html_input([
                                        'name' => 'menu',
                                        'type' => 'checklist',
                                        'value' => old('menu', $menu),
                                        'data' => get_area_options([])
                                    ])
                                ])
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary mt-4 d-block w-100" type="submit">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>

    
@endsection