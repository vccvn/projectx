@php
	add_css_link('static/manager/css/model-form.min.css');
@endphp
@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách model')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Model')

@section('content')
	<?php
	admin_action_menu([
		[
			'url' => route($route_name_prefix.'3d.models.trash'),
			'text' =>  'Model đã xoa',
			'icon' => 'fa fa-trash'
		]
	]);
	?>
    @include($_current.'results', ['type' => 'default'])
	
<div class="m-portlet m-portlet--skin-dark m-portlet--bordered-semi preview d-none" id="editor-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="flaticon-statistics"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    Dark Skin
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon btn-close-preview">
                        <i class="la la-close"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body" id="editor-portlet-body">
        <div class="btns-block">
            <button type="button" class="btn btn-sm btn-danger btn-close-editor"><i class="fa  fa-check"></i> Xong</button>
        </div>
        <div class="frame">
            
        </div>
    </div>
</div>
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"models",
				title:"{{$title}}",
				urls:{
					move_to_trash_url: @json(route($route_name_prefix.'3d.models.move-to-trash'))
				}
			})
		};
		// khai báo ở dây
	</script>
@endsection

{{-- Nhúng js --}}

@section('js')
	<script src="{{asset('static/crazy/js/items.js')}}"></script>
	<script>
		
$(function () {
    var editorportlet = new mPortlet("editor-portlet");
	var url = "{{route($route_name_prefix.'3d.items.edit',['secret_id' => 'DoanHaha'])}}";
    $(document).on("click", ".btn-edit-3d", function (e) {

        e.preventDefault();
        var id = $(this).data('id');
		var u = App.str.replace(url, 'DoanHaha', id);
		// $('#preview-portlet').removeClass('d-none');
        // previewportlet.fullscreen();
        $('#editor-portlet-body .frame').html(
            '<iframe width="560" height="315" src="'+u+'" title="Crazy 3D" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
        );
        $('#editor-portlet').removeClass('d-none');
        editorportlet.fullscreen();
    })
    $(document).on("click", ".btn-close-editor", function (e) {
        e.preventDefault();
        $('#editor-portlet-body .frame').html(
            ''
        );
        editorportlet.unFullscreen();
        $('#editor-portlet').addClass('d-none');
        
    })

    
    
     
    
});
	</script>
@endsection
