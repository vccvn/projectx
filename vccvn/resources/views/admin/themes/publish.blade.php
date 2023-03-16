@extends($_layout.'main')
{{-- khai báo title --}}
@section('title', 'Danh sách các Giao diện')
{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Giao diện')

<?php
	$web_types = ["all" => 'Tất cả'];
	if($types = get_system_config('web_type_list')){
		$web_types = $web_types + $types;
	}
	$web_type = get_web_type();
	$tab = isset($type)?$type:null;
	$tabActive = $tab && array_key_exists($tab, $web_types) ? $tab : 'all';
?>

{{-- Nội dung --}}
@section('content')
@if ($web_types)
	<div class="m-portlet m-portlet--tabs" id="theme-tabs-list">
		<div class="m-portlet__head">
			<div class="m-portlet__head-tools">
				<ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
					
					@foreach ($web_types as $key => $label)
					@if (in_array($key, ['default', 'all', $web_type]))
							
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link {{$tabActive == $key?'active':''}}" data-type="{{$key}}" data-toggle="tab" href="#{{$key}}_tab_content" role="tab">
								{{$label}}
							</a>
						</li>
						
						@endif
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
					@if (in_array($key, ['default', 'all', $web_type]))
						<div class="tab-pane {{$tabActive == $key?'active':''}}" id="{{$key}}_tab_content" role="tabpanel">
							<div class="{{$key}}-theme-list">
								<div class="row theme-list-body">
								</div>
								
							</div>
						</div>
					@endif
		
				@endforeach

			</div>
			<div class="list-buttons text-center">
				<button type="button" class="btn-see-more btn m-btn--pill m-btn--air btn-info m-btn m-btn--custom"><span class="fa fa-cloud-download-alt mr-2"></span> Xem thêm</button>
			</div>
			<div class="list-message text-center">
				<p class="">Không có kết quả</p>
			</div>
		</div>
	</div>
@endif

<textarea class="theme-list-template d-none" style="display: none">
	<div class="row theme-list-body"></div>
</textarea>
<textarea class="theme-item-template d-none" style="display: none">
	<div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4" id="theme-item-{$id}">
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
					<a href="javascript:void(0)" data-id="{$id}" class="btn m-btn--pill btn-active-theme {$btn_class} btn-sm m-btn m-btn--custom"><span class="btn-text">{$btn_text}</span></a>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
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
	<script src="{{asset('static/manager/js/admin.themes.js')}}"></script>
@endsection
