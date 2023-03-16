

<input type="hidden" name="{{$input->name}}" value="{{$input->value}}">

@if($input->value && $area = get_component_area($input->value))

    <?php    
        set_web_data('has_component_area', true);
        add_js_data('nestable_selectors', '#component-area-'.$area->id);
        $title_by = $input->hiddenData('title-by');
    ?>
    
<div class="m-area__content">
    <div class="dd nestable component-list-body" id="component-area-{{$area->id}}" data-area-id="{{$area->id}}" data-title-by="{{$title_by}}" data-max-depth="1" data-callback="App.components.sortCallback">
        <ol class="dd-list">
            

            @if(count($area->components))
                @foreach($area->components as $component)
                    @php
                        $data = $component->data;
                    @endphp
                    

                    <li class="dd-item" data-id="{{$component->id}}">
                                                        
                        <div class="item-actions">
                            <a href="javascript:void(0);" class="edit btn-edit-item" data-id="{{$component->id}}" data-area-id="{{$component->area_id}}">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a href="javascript:void(0);" class="remove btn-delete-item" data-id="{{$component->id}}" data-area-id="{{$component->area_id}}" data-label="{{$title_by && isset($data[$title_by])?$data[$title_by]:$component->label}}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        <div class="dd-handle">
                            <span class="component-name">{{($title_by && isset($data[$title_by])?$data[$title_by]:($component->label?$component->label:($component->name??$component->path)))}}</span>
                        </div>
                    </li>    
                    
                @endforeach
            @endif
            
        </ol>
    </div>

    <div class="text-center">
        <a href="javascript:void(0)" data-area-id="{{$area->id}}" data-toggle="m-tooltip" data-placement="top" title data-original-title="Thêm component" class="btn btn-outline-info btn-add-component btn-sm btn-block"><i class="fa fa-plus"></i> Thêm</a>
    </div>
</div>

@endif