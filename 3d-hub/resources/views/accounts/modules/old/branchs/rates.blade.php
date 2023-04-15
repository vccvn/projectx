@php
    $profile = getUser();
    $oldArea = old('area');
    extract($rates);
    $request = request();
    $page = request()->page;
@endphp
@extends($_layout.'master')
@section('title', 'Thiết lập Tỷ lệ nhánh')
@section('show_sidebar', 1)
@section('header_title', 'Tỷ lệ Nhánh')


@section('content')
<div class="row">

    @if ((!$page || $page < 2) && $request->tab!='history' && !$request->search && !$request->sortby && !$request->sorttype && !$request->per_page)
    

    <div class="col-md-8">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>Thiết lập Tỷ lệ nhánh</h6>
            </div>
            <div class="ms-panel-body">
                <form method="POST" action="{{route('branchs.rates')}}" class="smart-form auto-validation" novalidate>
                    @csrf

                    @if (count($areas))
                        <div class="betting-sub-type-select radio-nav nav-skew nav-sm nav-filled ps-border bottom size-1 prymary" data-ref="rate-areas">
                            @foreach ($areas as $area)
                                
                            <label for="{{$area->slug}}">
                                <input type="radio" name="area" id="{{$area->slug}}" value="{{$area->id}}" @if((!$oldArea && $loop->first) || $oldArea == $area->id) checked @endif> <span>{{$area->name}}</span>
                            </label>
        
                            @endforeach
                        </div> 

                        <div class="ref-items" data-ref-toggle="rate-areas">
                            
                            @foreach ($areas as $area)
                                <div class="ref-item" data-ref-id="{{$area->id}}">
                                    @if (count($types))
                                        @foreach ($types as $type)
                                            @if (count($type->notTrashedChildren))
                                                <h6 class="">{{$type->name}}</h6>
                                                <div class="form-row">
                                                    @foreach ($type->notTrashedChildren as $child)
                                                
                                                        <div class="col-sm-6 col-md-4">
                                                            <label for="rates-{{$area->id}}-{{$child->id}}">{{$child->name}}</label>
                                                            <div class="input-group">
                                                                <input type="number" name="rates[{{$area->id}}][{{$child->id}}]" id="rates-{{$area->id}}-{{$child->id}}" min="0" step="0.1" max="9999.9" value="{{old('rates.'.$area->id.'.'.$child->id, (isset($data[$area->id]) && isset($data[$area->id][$child->id]))?$data[$area->id][$child->id]:($child->default_rate?$child->default_rate:1))}}" placeholder="Nhập tỷ lệ" class="form-control {{($rate = $errors->first('rates.'.$area->id.'.'.$child->id))?'is-invalid':''}}" required>
                                                                <div class="invalid-feedback">
                                                                    {{$rate?$rate:"Không được bỏ trống"}}
                                                                </div>
                                                            </div>
                                                        </div>
                        
                                                        
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="field">
                                                    <h6><label for="rates-{{$area->id}}-{{$type->id}}">{{$type->name}}</label></h6>
                                                    <div class="input-group">
                                                        <input type="number" name="rates[{{$area->id}}][{{$type->id}}]" id="rates-{{$area->id}}-{{$type->id}}" min="0" step="0.1" max="9999.9" value="{{old('rates.'.$area->id.'.'.$type->id, (isset($data[$area->id]) && isset($data[$area->id][$type->id]))?$data[$area->id][$type->id]:($type->default_rate?$type->default_rate:1))}}" placeholder="Nhập tỷ lệ" class="form-control {{($rate = $errors->first('rates.'.$area->id.'.'.$type->id))?'is-invalid':''}}" required>
                                                        <div class="invalid-feedback">
                                                            {{$rate?$rate:"Không được bỏ trống"}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                            
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    
                
                    <div class="text-center mt-3 pt-3 ps-border top size-1 primary">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="reset" class="btn btn-secondary">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        @include($_template.'profile-card')
    </div>

    
@endif
    <div class="col-md-12">
        
        <div class="ms-panel">
            <div class="ms-panel-body">
                <div class="table-responsive">
                    <table id="rate-data-table" class="table table-bordered thead-primary user-table smart-table" data-title="Lịch sử">
                        
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection



@section('js')
<script src="{{asset('assets/app/js/app.datatable.js')}}"></script>
<script>
    App.datatable.add({
        el: "#rate-data-table",
        type: "ajax",
        columns: [
            {
                title: "Khu vực",
                className: "",
                scope: "row",
                content: "{$area.name}"
            },
            {
                title: "Loại cược",
                className: "",
                content: '{$betting_type.name}'
            },
            {
                title: "Tỉ lệ",
                className: "text-center",
                content: '{$rate}'
            },
            {
                title: "Bắt dâu",
                className: "hide-sm text-center",
                content: '{$started_at}'
            },
            {
                title: "Kết thúc",
                className: "hide-sm text-center",
                content: '{$ended_at}'
            }
            
        ],
        urls: {!! 
            json_encode([
                'dataUrl' => route('branchs.rates.data')
            ]) 
        !!}
    })
</script>
    
@endsection