@extends($_layout.'main')
@section('title', "Mã Nhúng")
@section('module.name', "Mã nhúng")
@section('content')
<?php
    $visible = [
        [
            'type' => 'area',
            'class' => 'col-12',
            'slug' => 'header'
        ],
        [
            'type' => 'group',
            'class' => 'col-12 col-sm-6 col-md-6 col-lg-7',
            'group' => [
                [
                    'type' => 'area',
                    'class' => 'col-12',
                    'slug' => 'article_top'
                ],
                [
                    'type' => 'area',
                    'class' => 'col-12',
                    'slug' => 'article_bottom'
                ]
            ]
        ],
        [
            'type' => 'group',
            'class' => 'col-12 col-sm-6 col-md-6 col-lg-5',
            'group' => [
                [
                    'type' => 'area',
                    'class' => 'col-12',
                    'slug' => 'sidebar_top'
                ],
                [
                    'type' => 'area',
                    'class' => 'col-12',
                    'slug' => 'sidebar_bottom'
                ]
            ]
        ],
        [
            'type' => 'area',
            'class' => 'col-12',
            'slug' => 'footer'
        ],
        
        
    ];

    $hidden = [
        [
            'type' => 'area',
            'class' => 'col-12 col-sm-6 col-lg-4',
            'slug' => 'head'
        ],
        [
            'type' => 'area',
            'class' => 'col-12 col-sm-6 col-lg-4',
            'slug' => 'top'
        ],
        [
            'type' => 'area',
            'class' => 'col-12 col-sm-6 col-lg-4',
            'slug' => 'bottom'
        ],
        [
            'type' => 'area',
            'class' => 'col-12',
            'slug' => 'custom'
        ]
    ];
    $column = [
        'type' => 'area',
        'class' => 'col-12 col-sm-6 col-md-4'
    ];
    
    $render = function($list, $type, $options, $callback, $renderArea){
        $html = '';
        if(count($list)){
            $html .= '<div class="row">';
            if($type == 'layout'){
                foreach ($options as $option) {
                    $html .= '<div class="'.$option['class'].'">';
                    if($option['type'] == 'area'){
                        $html .= $renderArea(isset($list[$option['slug']])?$list[$option['slug']]:null);
                    }
                    elseif($option['type'] == 'group'){
                        $html.= $callback($list, $type, $option['group'], $callback, $renderArea);
                    }
                    $html.='</div>';
                }
            }elseif($type == 'column'){
                foreach ($list as $area) {
                    $html .= '<div class="'.$options['class'].'">'.($renderArea($area)).'</div>';
                }
            }
            $html.='</div>';
            
        }
        return $html;
    };


    $renderArea = function($area){
        $html = '';
        if($area){
            add_js_data('nestable_selectors', '#embed-area-'.$area->id);
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
                                <a href="javascript:void(0)" data-area-id="'.$area->id.'" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm mã nhúng" class="btn btn-outline-info btn-add-embed m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="m-portlet__body">
                    <div class="m-section mb-0">
                        <div class="m-section__content">';
                            $html.='
                            <div class="dd nestable embed-list-body" id="embed-area-'.$area->id.'" data-area-id="'.$area->id.'" data-max-depth="1" data-callback="App.embeds.sortCallback">
                                <ol class="dd-list">
                                    ';

                                    if(count($area->embeds)){
                                        foreach($area->embeds as $embed){
                                            $html.= '
                                            
                                            <li class="dd-item" data-id="'.$embed->id.'">
                                                                                
                                                <div class="item-actions">
                                                    <a href="javascript:void(0);" class="edit btn-edit-item" data-id="'.$embed->id.'" data-area-id="'.$embed->area_id.'">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="remove btn-delete-item" data-id="'.$embed->id.'" data-area-id="'.$embed->area_id.'" data-label="'.$embed->label.'">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                                <div class="dd-handle">
                                                    <span class="embed-label">'.($embed->label?$embed->label:$embed->slug).'</span>
                                                </div>
                                            </li>    
                                            ';
                                        }
                                    }                        
                                    $html .='
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
?>
<div class="html-areas">
@if (isset($areas['default']))
    <div class="row">
        <div class="col-12">
            <h4 class="mb-4">
                Vị trí mã nhúng
            </h4>
            {!! $render($areas['default'], 'layout', $hidden, $render, $renderArea) !!}
        </div>
{{-- 
        <div class="col-12">
            <h4 class="mb-4">
                Theo layout
            </h4>
            {!! $render($areas['default'], 'layout', $visible, $render, $renderArea) !!}
        </div> --}}
        
    </div>
@endif

@if (isset($areas['theme']) && $areas['theme'])
    <div class="row">
        <div class="col-12">
            <h4 class="mb-4">
                Theo giao diện
            </h4>
            {!! $render($areas['theme'], 'column', $column, $render, $renderArea) !!}
        </div>

    </div>
@endif
</div>
<div class="nesttable-template d-none">
    <span class="embed-label">{$label}</span>
</div>
<div class="item-action-template d-none">
    <div class="item-actions embed-action-{$id}">
        <a href="javascript:void(0);" class="edit btn-edit-item" data-id="{$id}" data-area-id="{$area_id}">
            <i class="fa fa-pencil-alt"></i>
        </a>
        <a href="javascript:void(0);" class="remove btn-delete-item" data-id="{$id}" data-area-id="{$area_id}" data-label="{$label}">
            <i class="fa fa-trash"></i>
        </a>
    </div>
</div>
@endsection


{{-- Nhúng link css --}}
@section('css')
    <link rel="stylesheet" href="{{asset('static/plugins/nestable2/jquery.nestable.min.css')}}">
    
@endsection

{{-- Nhúng js --}}

@section('jsinit')
    <script>
        var embed_data = {
            urls: @json($urls)
        }
    </script>
@endsection

@section('js')
<script src="{{asset('static/plugins/nestable2/jquery.nestable.js')}}"></script>
<script src="{{asset('static/manager/js/nestable.js')}}"></script>
<script src="{{asset('static/manager/js/embeds.js')}}"></script>
    @if ($e = $errors->first())
		<script>
			App.modal.error(@json($e));
		</script>
	@endif
@endsection