

@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $menu->name)

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $menu->name)


@section('content')



<div class="row">
    <div class="col-12 col-md-5 col-xl-4">
        <!--begin::Portlet-->
        @include($_current.'templates.add-form')
        <!--end::Portlet-->
    </div>
    <div class="col-12 col-md-7 col-xl-8">
        
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <a href="{{route($route_name_prefix.'menus.list')}}" class="text-info pr-3">
                            <i class="fa fa-arrow-left"></i> 
                        </a>
                        <h3 class="m-portlet__head-text">
                            
                            Menu {{$menu->name}}
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="m-portlet__body">
        
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content">
                        <div class="setting-list">
                            
                            <div class="dd nestable menu-item-list-body" id="crazy-menu-item-list" data-max-depth="{{$menu->depth}}" data-callback="App.menu.items.sortCallback">
                                <ol class="dd-list">
                                    @if (count($items))
                                        <?php
                                            $render = function($items, $callback){
                                                $types = [
                                                    "default" => "Mặc định",
                                                    "item" => "Chỉ theo loại Item",
                                                    "custom" => "Chỉ tùy biến "
                                                ];
                                                $str = '';
                                                if(count($items)){
                                                    foreach($items as $item){
                                                        $props = $item->props;
                                                        
                                                        $subType = $item->sub_type ? (isset($types[$item->sub_type]) ? $types[$item->sub_type]: $types['default']) : $types['default'];
                                                        $str .= '
                                                        
                                                        <li class="dd-item" data-id="'.$item->id.'">
                                                                                            
                                                            <div class="item-actions">
                                                                <a href="javascript:void(0);" class="edit btn-edit-item" data-id="'.$item->id.'">
                                                                    <i class="fa fa-pencil-alt"></i>
                                                                </a>
                                                                <a href="javascript:void(0);" class="remove btn-delete-item" data-id="'.$item->id.'">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </div>
                                                            <div class="dd-handle">
                                                                <span class="item-text">'.($item->props['text']?$item->props['text']: 'icon: '.$item->props['icon']).' <span class="submenu-type-label"> sub menu: '.$subType.'</span></span>
                                                            </div>
                                                            '.(count($item->children)?'<ol class="dd-list">'.$callback($item->children, $callback).'</ol>':'').'
                                                        </li>    
                                                        ';
                                                    }
                                                }
                                                return $str;
                                            };
                                        ?>
                                        {!! $render($items, $render) !!}
                                    @endif                        
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="nesttable-template d-none">
                        <span class="item-text">{$text} <span class="submenu-type-label"> sub menu: {$subType}</span></span>
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
        
        
    </div>
</div>


@include($_current.'templates.modals')

{{-- @include($_template.'modal-icons') --}}





@endsection

{{-- Nhúng link css --}}
@section('css')
    <link rel="stylesheet" href="{{asset('static/plugins/nestable2/jquery.nestable.min.css')}}">
    
@endsection

{{-- Nhúng js --}}

@section('jsinit')
    <script>
        var menu_data = {
            urls: @json($urls)
        }
    </script>
@endsection
@if ($theme && $theme->package && is_array($theme->package) && $package = $theme->package)
@php
    if(array_key_exists('icons', $package) && is_array($package['icons'])){
        $icons = [];
        foreach ($package['icons'] as $slug => $iconData) {
            $icon = crazy_arr($iconData);
            if(is_array($icon->style)){
                foreach ($icon->style as $link) {
                    $l = str_replace('@assets/', '', $link);
                    if($l != $link){
                        add_css_link(theme_asset($l));
                    }else{
                        add_css_link($link);
                    }
                }
            }

            if(is_array($icon->list)){
                $listIcons = [];
                foreach ($icon->list as $list) {
                    if(is_array($list)){
                        if(array_key_exists('items', $list) && is_array($list['items'])){
                            $prefix = array_key_exists('prefix', $list) ? $list['prefix'] : '';
                            foreach ($list['items'] as $item) {
                                $listIcons[] = $prefix.$item;
                            }
                        }elseif(array_val_type($list, 'string')){
                            foreach ($list as $item) {
                                $listIcons[] = $item;
                            }
                        }
                    }
                }
                if(count($listIcons)){
                    $icons[$icon->key] = [
                        'title' => $icon->title,
                        'list' => $listIcons
                    ];
                }
            }
        }
        if($icons){
            add_js_data('icon_picker_data', $icons);
        }
        
    }
    
@endphp
@endif

@section('js')
<script src="{{asset('static/plugins/nestable2/dist/jquery.nestable.min.js')}}"></script>
<script src="{{asset('static/manager/js/nestable.js')}}"></script>
<script src="{{asset('static/manager/js/menu.items.js')}}"></script>
{{-- <script src="{{asset('static/manager/js/iconpicker.js')}}"></script> --}}
    @if ($e = $errors->first())
		<script>
			App.Swal.error(@json($e));
		</script>
	@endif
@endsection

