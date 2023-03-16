<?php
$group = [
    'work' => [
        'title' => 'Kinh nghiệm làm việc',
        'label' => 'Công việc',
        'org_label' => 'Công ty',
        'add_label' => 'Công việc',
        'add_button_text' => 'Thêm công việc',
        'exp_label' => 'Công việc',
        'end_time_label' => 'Tôi đang làm việc ở đây',
        'placeholder' => 'Nhập công việc hoặc vị trí làm việc',
        'exp_type' => 'business',
        'route' => 'profile.experiences.save',
    ],
    'education' => [
        'title' => 'Trình độ học vấn',
        'label' => 'Học vấn',
        'org_label' => 'Trường học',
        'add_label' => 'Học vấn',
        'add_button_text' => 'Thêm hoc4 vấn',
        'exp_label' => 'Học vấn',
        'end_time_label' => 'Tôi đang học ở đây',
        'placeholder' => 'Nhập trình độ học vấn hoặc ngành học',
        'exp_type' => 'education',
        'route' => 'profile.education.save',
    ]
];

if(isset($type)){
    if(in_array($t = strtolower($type), ['work', 'education'])){
        $texts = $group[$t];
    }else{
        $texts = $group['work'];
    }
}else{
    $texts = $group['work'];
}
?>
@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $title = $texts['label'])

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title)


@section('content')


<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{$texts['title']}}
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a 
                        href="javascript:void(0);" 
                        data-toggle="m-tooltip" 
                        data-placement="left" title 
                        data-original-title="{{$texts['add_button_text']}}" 
                        class="ml-3 btn btn-outline-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air btn-add-profile-experience"><i class="fa fa-plus"></i></a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="m-portlet__body">

        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content crazy-timeline">
                <!--begin:Timeline 1-->
                <div class="m-timeline-1 m-timeline-1--fixed">
                    <div class="m-timeline-1__items timeline-body">
                        <div class="m-timeline-1__marker"></div>
                        {{-- m-timeline-1__item--left m-timeline-1__item--first --}}

                        @foreach ($experiences as $item)
                        <div id="crazy-timeline-item-{{$item->id}}" data-title="{{$item->title}}" class="crazy-timeline-item m-timeline-1__item m-timeline-1__item--{{$loop->index%2==0?'left':'right'}} {{$loop->first?'m-timeline-1__item--first':''}}">
                            <div class="m-timeline-1__item-circle">
                                <div class="m--bg-danger"></div>
                            </div>
                            <div class="m-timeline-1__item-arrow"></div>
                            <span class="m-timeline-1__item-time m--font-brand">
                                @if ($item->has_start_date)
                                    {{$item->getTime('started_at', 'd/m/Y')}} - 
                                    @if ($item->has_finish_date)
                                        {{$item->getTime('finished_at', 'd/m/Y')}}
                                    @else
                                        Hiện nay
                                    @endif
                                @endif
                                {{-- <span>PM</span> --}}
                            </span>
                            <div class="m-timeline-1__item-content">
                                <div class="m-timeline-1__item-title">
                                    {{$item->title}}
                                    @if ($item->org_name)
                                        - tại: {{$item->org_name}}
                                    @endif
                                        
                                </div>
                                <div class="m-timeline-1__item-body">
                                    {!! nl2br($item->description) !!}
                                </div>
                                <div class="m-timeline-1__item-actions">
                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="Sửa" class="btn-edit text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-edit-1"></i>
                                    </a>

                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="Xóa" class="btn-delete text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-delete-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
{{--                 
                <div class="row">
                    <div class="col m--align-center">
                        <button type="button" class="btn btn-sm m-btn--custom m-btn--pill  btn-danger">Load More</button>
                    </div>
                </div> --}}

                <!--End:Timeline 1-->


                <div class="timeline-item-template d-none">
                    <div id="crazy-timeline-item-{$id}" data-title="{$title}" class="crazy-timeline-item m-timeline-1__item">
                        <div class="m-timeline-1__item-circle">
                            <div class="m--bg-danger"></div>
                        </div>
                        <div class="m-timeline-1__item-arrow"></div>
                        <span class="m-timeline-1__item-time m--font-brand">
                            {$timeinfo}
                        </span>
                        <div class="m-timeline-1__item-content">
                            <div class="m-timeline-1__item-title">
                                {$timetitle}
                                    
                            </div>
                            <div class="m-timeline-1__item-body">
                                {$description}
                            </div>
                            <div class="m-timeline-1__item-actions">
                                <a href="javascript:void(0);" data-id="{$id}" data-toggle="m-tooltip" data-placement="left" data-original-title="Sửa" class="btn-edit text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                    <i class="flaticon-edit-1"></i>
                                </a>

                                <a href="javascript:void(0);" data-id="{$id}" data-toggle="m-tooltip" data-placement="left" data-original-title="Xóa" class="btn-delete text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                    <i class="flaticon-delete-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>        
    </div>

    <!--end::Form-->
</div>


<div class="modal fade experience-modal" id="experience-modal" tabindex="-1" role="dialog" aria-labelledby="experience-modal-title">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{route($route_name_prefix.$texts['route'])}}" method="POST" id="add-experience-form">
                <input type="hidden" name="id" value="" id="experience-id">
                <div class="modal-header custom-style bg-info">
                    <h5 class="modal-title" id="experience-modal-title">
                        <i class="fa fa-info-circle"></i>
                        <span>{{$texts['add_label']}}</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">{{$texts['label']}}</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" name="title" id="experience-title" class="form-control m-input" placeholder="{{$texts['placeholder']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">Tại </label>
                        <div class="col-md-8 col-lg-9">
                            @include($_base.'forms.templates.crazyselect', [
                                'input' => html_input([
                                    "type" => "crazyselect",
                                    "label" => $texts['org_label'],
                                    'name' => 'org_id',
                                    'id' => 'org_id',
                                    "call" => "get_profile_organization_options",
                                    "params" => [["id" => ":defval", "type" => $texts['exp_type']], "Tự do"],
                                    "@select-type" => "dynamic",
                                    "@search-route" => $route_name_prefix."organizations.select-options",
                                    "@search-route-params" => ["type" => $texts['exp_type']],
                                    "@advance-click" => "Profile.experiences.add".ucfirst($texts['exp_type']),
                                    "@advance-text" => "Thêm ".$texts['org_label']
                                ])
                            ])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label" for="experience-description">Mô tả</label>
                        <div class="col-md-8 col-lg-9">
                            <textarea name="description" id="experience-description" class="form-control m-input" placeholder="Viết gì đó..."></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 col-lg-3 ">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--info">
                                <input type="checkbox" class="crazy-checkbox" name="has_start_date" id="experience-has-start-date" data-on-change="Profile.experiences.toggleStartDate"> 
                                Thởi gian
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row toggle-by-has-start-date">
                        <label class="col-md-4 col-lg-3 col-form-label" for="experience-date-started">Bắt đầu</label>
                        <div class="col-md-8 col-lg-9">
                            <?php
                                $year = date('Y');
                            ?>
                            @include($_base.'forms.templates.dateselect', [
                                'input' => html_input([
                                    'type' => 'dateselect',
                                    'name' => 'started',
                                    '@params' => [
                                        'year' => [$year, $year-40]
                                    ]
                                ])
                            ])
                        </div>
                    </div>
                    <div class="form-group row toggle-by-has-start-date">
                        <label class="col-md-4 col-lg-3 col-form-label" for="experience-date-finished">Kết thúc</label>
                        <div class="col-md-8 col-lg-9">
                            <div class="d-none">
                                <input type="checkbox" class="crazy-checkbox" name="has_finish_date" id="experience-has-finish-date" data-on-change="Profile.experiences.toggleFinishDate"> 
                            </div>
                            <div class="rtoggle-by-has-finish-date">
                                {{$texts['end_time_label']}}
                                -
                                <label for="experience-has-finish-date" class="text-info" style="cursor: pointer">
                                    Thêm thời gian
                                </label>
                            </div>
                            <div class="toggle-by-has-finish-date">
                                    <?php
                                    $year = date('Y');
                                ?>
                                @include($_base.'forms.templates.dateselect', [
                                    'input' => html_input([
                                        'type' => 'dateselect',
                                        'name' => 'finished',
                                        '@params' => [
                                            'year' => [$year, $year-40]
                                        ]
                                    ])
                                ])

                                <label for="experience-has-finish-date" class="text-danger mt-2" style="cursor: pointer">
                                    Bỏ thời gian
                                </label>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info done-btn">Thêm</button>
                    <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>
    

@endsection

{{-- Nhúng link css --}}
@section('css')
    
@endsection

{{-- Nhúng js --}}

@section('js')
<script src="{{asset('static/manager/js/profile.experiences.js')}}"></script>
<script src="{{asset('static/manager/js/profile.organizations.js')}}"></script>
@endsection
