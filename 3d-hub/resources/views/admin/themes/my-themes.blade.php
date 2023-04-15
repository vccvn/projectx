@extends($_layout.'main')
{{-- khai báo title --}}
@section('title', $title = 'Giao diện của tôi')
{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title)

<?php
	$web_types = [
        "all" => 'Tất cả',
        "available" => 'Đã được duyệt',
        'pending' => 'Chờ duyệt',
        'upload' => 'Tải lên'
    ];
	
    $tab = isset($tab)?$tab:old('tab');
    $tabActive = $tab && array_key_exists($tab, $web_types) ? $tab : 'all';
    $config = array_merge($config,[
        'save_button_text' => 'Tải lên',
        'cancel_button_text' => 'Hủy'
    ]);
    $attrs = [
        'method' => 'POST',
        'action' => route($route_name_prefix.'themes.save'),
        'id' => 'theme-upload-form',
        'class' => 'crazy-form'
    ];
    $inputs = [
        'tab' => [
            'type' => 'hidden',
            'value' => 'upload'
        ]
    ]+$inputs;
?>


{{-- Nội dung --}}
@section('content')
@if ($web_types)
	<div class="m-portlet m-portlet--tabs" id="theme-tabs-list">
		<div class="m-portlet__head">
			<div class="m-portlet__head-tools">
				<ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
					
					@foreach ($web_types as $key => $label)
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link {{$tabActive == $key?'active':''}}" data-type="{{$key}}" data-tab="{{$key}}" data-toggle="tab" href="#{{$key}}_tab_content" role="tab">
								{{$label}}
							</a>
						</li>
					@endforeach
					
				</ul>
			</div>
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<form action="" method="get" id="search-theme-form">
						<input type="hidden" name="type" id="search-theme-type">
						<div class="input-group">
							<input type="search" id="search-theme-input" name="keyword" class="form-control" placeholder="Tìm kiếm...">
							<div class="btn-append-group">
								<button class="btn btn-info btn-search-icon"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</form>
				</div>
			</div>
			
		</div>
		<div class="m-portlet__body">
			<div class="tab-content">
				@foreach ($web_types as $key => $label)
					<div class="tab-pane {{$tabActive == $key?'active':''}}" id="{{$key}}_tab_content" role="tabpanel">
                        @if ($key!='upload')
                            
                            <div class="{{$key}}-theme-list">
                                <div class="row theme-list-body">
                                </div>
                                
                            </div>
                            <div class="list-buttons text-center">
                                <button type="button" class="btn-see-more btn m-btn--pill m-btn--air btn-info m-btn m-btn--custom"><span class="fa fa-cloud-download-alt mr-2"></span> Xem thêm</button>
                            </div>
                            <div class="list-message text-center">
                                <p class="">Không có kết quả</p>
                            </div>

                        @else
                            @include($_base.'forms.form')
                        @endif
                        
					</div>
		
				@endforeach

			</div>
			
		</div>
	</div>
@endif

<textarea class="theme-list-template d-none" style="display: none">
	<div class="row theme-list-body"></div>
</textarea>

<textarea class="theme-item-template d-none" style="display: none">
	<div class="col-12 col-sm-6 col-md-4 mb-4" id="theme-item-{$id}">
		<div class="theme-item">
			<div class="thumb">
				<a href="javascript:void(0)" class="theme-quick-view-btn" data-id="{$id}">
					<img src="{$image}" alt="{$name}" class="theme-image">
				</a>
			</div>
			<div class="theme-info clearfix">
				<div class="theme-name">
					<h4><a href="javascript:void(0)" class="theme-quick-view-btn" data-id="{$id}">{$name}</a></h4>
				</div>
				<div class="tools">
					{$tool} 
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</textarea>

<textarea class="theme-available-template d-none" style="display: none">
	{{-- <a href="javascript:void(0)" class="btn m-btn--pill  btn-sm m-btn m-btn--custom"><span class="btn-text">{$btn_text}</span></a> --}}
	<a href="javascript:void(0)" data-id="{$id}" title="Kích hoạt" class="ml-3 btn btn-active-theme {$btn_class} m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-bolt"></i></a>
	<a href="{$edit_url}" title="Sửa" class="ml-3 btn btn-outline-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="flaticon-edit-1"></i></a>
	{{-- <a href="javascript:void(0)" data-id="{$id}" title="Xóa" class="ml-3 btn btn-outline-danger btn-delete-theme m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-trash"></i></a> --}}
</textarea>
<textarea class="theme-pending-template d-none" style="display: none">
	<a href="{$edit_url}" title="Sửa" class="ml-3 btn btn-outline-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="flaticon-edit-1"></i></a>
	<a href="javascript:void(0)" data-id="{$id}" title="Xóa" class="ml-3 btn btn-outline-danger btn-delete-theme m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-trash"></i></a>
</textarea>
<textarea class="theme-delete-template d-none" style="display: none">
	<a href="javascript:void(0)" data-id="{$id}" title="Xóa" class="ml-3 btn btn-outline-danger btn-delete-theme m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-trash"></i></a>
</textarea>


<textarea class="theme-detail-template d-none" style="display: none">
	<div class="theme-detail">
		<div class="row">
			<div class="col-12 col-md-6 col-lg-5">
				<div class="theme-image">
					<img src="{$image}" alt="{$name}">
				</div>
			</div>
			<div class="col-12 col-md-6 col-lg-7">
				<h4 class="theme-name">{$name}</h4>
				<p>Phiên bản: <span>{$version}</span></p>
				<p>Loại theme: <span>{$view_type_text}</span></p>
				<p>Hỗ trợ: <span>{$web_type_text}</span></p>
				<p>Tác giả: <span>{$owner.name}</span></p>
			</div>
			
		</div>
		<div class="row mt-4">
			<div class="col-12">
				<h4>Mô tả</h4>
				<p>{$description}</p>
			</div>
		</div>
		<div class="row mt-4 theme-gallery">
			{$gallery_html}
		</div>
		
	</div>
</textarea>

<textarea class="theme-gallery-template d-none" style="display: none">
	<div class="col-sm-6 col-md-4 col-lg-3 mb-3 theme-gallery-item">
		<a data-fancybox="gallery" href="{$src}"><img src="{$src}"></a>
	</div>
</textarea>



@endsection

{{-- Nhúng link css --}}
@section('css')
	<link rel="stylesheet" href="{{asset('static/plugins/fancybox/jquery.fancybox.min.css')}}">
	<style>
    .crazy-form.m-form.m-form--fit .m-form__group{
        padding-left: 0;
        padding-right: 0;
    }
    </style>
@endsection


{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
        var theme_data = {
			current_theme: {{web_setting('theme_id')}},
			el: "#theme-tabs-list",
            urls: @json($urls)
        }
    </script>
@endsection

{{-- Nhúng js --}}

@section('js')
	<script src="{{asset('static/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
	<script src="{{asset('static/manager/js/admin.mythemes.js')}}"></script>
@endsection
