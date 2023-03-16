@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $title = 'Kỹ năng')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title)


@section('content')


<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Danh sách kỹ năng
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm Kỹ năng" class="ml-3 btn btn-outline-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air btn-add-profile-skill"><i class="fa fa-plus"></i></a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="m-portlet__body">

        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="skill-list">
                    <div class="skill-list-header">
                        <div class="list-actions">
                            Actions
                        </div>
                        <div class="list-header-content">
                            <div class="row">
                                <div class="col-7 col-md-8 col-lg-8">Kỹ năng</div>
                                <div class="col-3 col-md-2 col-lg-2 text-center">Điểm</div>
                                <div class="col-2 col-md-2 col-lg-2 text-center">
                                    <div class="d-none d-md-block">
                                        Hiển thị
                                    </div>
                                    <div class="d-block d-md-none">
                                        Hiện
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="dd nestable skill-list-body" id="profile-skill-list" data-max-depth="1" data-callback="Profile.skills.sortCallback">
                        <ol class="dd-list">
                            @if (count($skills))
                                @foreach ($skills as $skill)
                                <?php
                                    $showLabels = ["", "Có"];
                                ?>
                                <li class="dd-item" data-id="{{$skill->id}}">
                                    <div class="item-actions">
                                        <a href="javascript:void(0);" class="edit btn-edit-item" data-id="{{$skill->id}}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="remove btn-delete-item" data-id="{{$skill->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <div class="dd-handle">
                                        <div class="row">
                                            <div class="col-7 col-md-8 col-lg-8"><span class="skill-name">{{$skill->name}}</span></div>
                                            <div class="col-3 col-md-2 col-lg-2 text-center"><span class="skill-percentage">{{$skill->percentage}}</span></div>
                                            <div class="col-2 col-md-2 col-lg-2 text-center"><span class="skill-show">{{$showLabels[$skill->show]}}</span></div>
                                            
                                        </div>
                                    </div>
                                </li>    
                                @endforeach
                            @endif                        
                        </ol>
                    </div>
                </div>
            </div>

            <div class="nesttable-template d-none">
                <div class="row">
                    <div class="col-7 col-md-8 col-lg-8"><span class="skill-name">{$name}</span></div>
                    <div class="col-3 col-md-2 col-lg-2 text-center"><span class="skill-percentage">{$percentage}</span></div>
                    <div class="col-2 col-md-2 col-lg-2 text-center"><span class="skill-show">{$show_label}</span></div>
                </div>
            </div>
            <div class="item-action-template d-none">
                <div class="item-actions">
                    <a href="javascript:void(0);" class="edit btn-edit-item" data-id="{$id}">
                        <i class="fa fa-pencil-alt"></i>
                    </a>
                    <a href="javascript:void(0);" class="remove btn-delete-item" data-id="{$id}">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
        
    </div>

    <!--end::Form-->
</div>



<div class="modal fade skill-modal" id="skill-modal" tabindex="-1" role="dialog" aria-labelledby="skill-modal-title">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{route($route_name_prefix.'skills.add')}}" method="POST" id="add-skill-form">
                <div class="modal-header custom-style bg-info">
                    <h5 class="modal-title" id="skill-modal-title">
                        <i class="fa fa-info-circle"></i>
                        <span>Thêm kỹ năng</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">Tên kỹ năng</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" name="name" id="skill-name" class="form-control m-input" placeholder="Nhập tên kỹ năng">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">Phân loại</label>
                        <div class="col-md-8 col-lg-9">
                            <div class="checkbox-radio display-inline">
                                <label class="inp-label checkbox-label m-radio pr-3">
                                    <input type="radio" name="type" value="hard" checked="checked"> <span></span> 
                                    <i>Kỹ năng chuyên môn</i>
                                </label> 
                                <label class="inp-label checkbox-label m-radio pr-3">
                                    <input type="radio" name="type" value="soft" class=""> <span></span>
                                     <i>kỹ năng mềm</i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">Nghề nghiệp</label>
                        <div class="col-md-8 col-lg-9">
                            @include($_base.'forms.templates.crazyselect', [
                                'input' => html_input([
                                    'name' => 'work_id',
                                    'id' => 'work_id',
                                    "type" => "crazyselect",
                                    "label" => "Nghề nghiệp",
                                    "call" => "get_work_options",
                                    "params" => [],
                                    "@select-type" => "dynamic",
                                    "@search-route" => $route_name_prefix."works.select-options",
                                    "@advance-click" => "Profile.skills.addWork",
                                    "@advance-text" => "Thêm Nghề nghiệp"
                                ])
                            ])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label" for="skill-description">Mô tả</label>
                        <div class="col-md-8 col-lg-9">
                            <textarea name="description" id="skill-description" class="form-control m-input" placeholder="Viết gì đó..."></textarea>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Thêm</button>
                    <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>
    


<div class="modal fade profile-skill-modal" id="profile-skill-modal" tabindex="-1" role="dialog" aria-labelledby="profile-skill-modal-title">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{route($route_name_prefix.'profile.skills.save')}}" method="POST" id="profile-skill-form">
                <input type="hidden" name="id" id="profile-skill-id" value="0">
                <div class="modal-header custom-style bg-info">
                    <h5 class="modal-title" id="profile-skill-modal-title">
                        <i class="fa fa-info-circle"></i>
                        <span>Thêm kỹ năng</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">Kỹ năng</label>
                        <div class="col-md-8 col-lg-9">
                            @include($_base.'forms.templates.crazyselect', [
                                'input' => html_input([
                                    'type' => 'crazyselect',
                                    'name' => 'skill_id',
                                    'id' => 'skill_id',
                                    'call' => 'get_profile_skill_options',
                                    'params' => [],
                                    '@select-type' => 'dynamic',
                                    '@search-route' => $route_name_prefix.'skills.select-options',
                                    '@advance-click' => 'Profile.skills.showSkillForm',
                                    '@advance-text' => 'Thêm kỹ năng'
                                ])
                            ])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label" for="skill-percentage">Thang điểm</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="number" name="percentage" id="skill-percentage" class="form-control m-input" placeholder="nhập thang điểm từ 0 đến 100" min="0" max="100">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">Hiển thị</label>
                        <div class="col-md-8 col-lg-9">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--info">
                                <input type="checkbox" class="crazy-checkbox" name="show" id="skill-show"> 
                                Hiển thị trang chủ
                                <span></span>
                            </label>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-done">Thêm</button>
                    <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>
    



@endsection

{{-- Nhúng link css --}}
@section('css')
    <link rel="stylesheet" href="{{asset('static/plugins/nestable2/jquery.nestable.min.css')}}">
    
@endsection

{{-- Nhúng js --}}

@section('js')
<script src="{{asset('static/plugins/nestable2/dist/jquery.nestable.min.js')}}"></script>
<script src="{{asset('static/manager/js/nestable.js')}}"></script>
<script src="{{asset('static/manager/js/profile.skills.js')}}"></script>
<script src="{{asset('static/manager/js/profile.works.js')}}"></script>

@endsection
