@extends($_layout.'main')
@section('title', "Components")
@section('module.name', "Components")
@section('content')
<?php
    add_js_src('static/crazy/js/select.js');
    $layout = [
        [
            'type' => 'area',
            'class' => 'col-12',
            'slug' => 'header'
        ],
        [
            'type' => 'area',
            'class' => 'col-12 col-sm-6 col-md-6 col-lg-7',
            'slug' => 'main'
        ],
        [
            'type' => 'area',
            'class' => 'col-12 col-sm-6 col-md-6 col-lg-5',
            'slug' => 'sidebar'
        ],
        [
            'type' => 'area',
            'class' => 'col-12',
            'slug' => 'footer'
        ],
        
        
    ];

    $column = [
        'type' => 'area',
        'class' => 'col-12 col-md-6'
    ];
    
    $render = function($list, $type, $options, $callback, $renderArea, $renderComponents = null){
        $html = '';
        if(count($list)){
            $html .= '<div class="row">';
            if($type == 'layout'){
                foreach ($options as $option) {
                    $html .= '<div class="'.$option['class'].'">';
                    if($option['type'] == 'area'){
                        $html .= $renderArea(isset($list[$option['slug']])?$list[$option['slug']]:null, $renderComponents);
                    }
                    elseif($option['type'] == 'group'){
                        $html.= $callback($list, $type, $option['group'], $callback, $renderArea, $renderComponents);
                    }
                    $html.='</div>';
                }
            }elseif($type == 'column'){
                foreach ($list as $area) {
                    $html .= '<div class="'.$options['class'].'">'.($renderArea($area, $renderComponents)).'</div>';
                }
            }
            $html.='</div>';
            
        }
        return $html;
    };



    $renderArea = function($area, $renderComponents = null){
        $html = '';
        if($area){
            add_js_data('nestable_selectors', '#component-area-'.$area->id);
            $html .= '<div class="m-portlet  m-portlet--head-md">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                '.$area->name.'
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="javascript:void(0)" data-area-id="'.$area->id.'" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm mã nhúng" class="btn btn-outline-info btn-add-component m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="m-portlet__body">
                    <div class="m-section mb-0">
                        <div class="m-section__content">';
                            $html.='
                            <div class="dd nestable component-list-body" id="component-area-'.$area->id.'" data-area-id="'.$area->id.'" data-max-depth="10" data-callback="App.components.sortCallback">
                                <ol class="dd-list">
                                    ' . (count($area->components) && is_callable($renderComponents) ? $renderComponents($area->components, $renderComponents) : '') .'
                                </ol>
                            </div>';

                        $html .= '    
                        </div>
                    </div>
                    
                </div>
            </div>';
        }
        return $html;
    };

    $renderComponents = function($components, $render = null){
        $html = '';
        if($components && count($components)){
            foreach($components as $component){
                $html.= '
                
                <li class="dd-item" data-id="'.$component->id.'">
                                                    
                    <div class="item-actions">
                        <a href="javascript:void(0);" class="edit btn-edit-item" data-id="'.$component->id.'" data-area-id="'.$component->area_id.'">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <a href="javascript:void(0);" class="remove btn-delete-item" data-id="'.$component->id.'" data-area-id="'.$component->area_id.'" data-label="'.$component->label.'">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                    <div class="dd-handle">
                        <span class="component-name">'.($component->name??$component->path).'</span>
                    </div>
                    '.($component->children && count($component->children) && is_callable($render)?'<ol class="dd-list">'.$render($component->children, $render).'</ol>':'').'
                </li>    
                ';
            }
        }
        return $html;
    };

    $defaultAreaClass = (isset($areas['theme']) && $areas['theme'])? 'col-12 col-md-6 pr-lg-5': 'col-12';
?>





<ul class="nav nav-tabs m-tabs-line" role="tablist">
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#theme_tab_content" role="tab">
            Giao diện
        </a>
    </li>
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#default_tab_content" role="tab">
            Mặc định
        </a>
    </li>

</ul>
<div class="tab-content html-areas">
    <div class="tab-pane active" id="theme_tab_content" role="tabpanel">
        {!! $render($areas['theme'], 'column', $column, $render, $renderArea, $renderComponents) !!}
    </div>
    <div class="tab-pane" id="default_tab_content" role="tabpanel">
        {!! $render($areas['default'], 'layout', $layout, $render, $renderArea, $renderComponents) !!}
    </div>

</div>

@include($_current.'modal-template')


@endsection


{{-- Nhúng link css --}}
@section('css')
<link rel="stylesheet" href="{{asset('static/plugins/nestable2/jquery.nestable.min.css')}}">
@endsection

{{-- Nhúng js --}}

@section('jsinit')
<script>
    var component_data = {
        urls: @json($urls)
    }
    posts_data = {
        urls: {
            get_category_url: "{{route('admin.posts.category-options')}}"
        }
    };

</script>
@endsection

@section('js')
<?php
add_js_src('static/crazy/js/select.js');
?>
<script src="{{asset('static/plugins/nestable2/jquery.nestable.js')}}"></script>
<script src="{{asset('static/manager/js/nestable.js')}}"></script>
<script src="{{asset('static/manager/js/components.js')}}"></script>
@if ($e = $errors->first())
<script>
    App.Swal.error(@json($e));

</script>
@endif
@endsection
