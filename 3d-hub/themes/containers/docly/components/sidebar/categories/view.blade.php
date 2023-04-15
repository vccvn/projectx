@php
    $url = null;
    $args = [
        '@limit' => $data->cate_number?$data->cate_number:10,
        '@advance' => ['post_count'],
    ];
    $title = null;
    if($data->get_by_dynamic_active && $active = $helper->getActiveModel('dynamic')){
        $args['dynamic_id'] = $active->id;
        $title = $active->name;
        
    }
    else{
        if($data->dynamic_id && $dynamic = $helper->getDynamic(['id' => $data->dynamic_id])){
            $args['dynamic_id'] = $data->dynamic_id;
            $title = $dynamic->name;
            $url = $dynamic->getViewUrl();
        }
        if($data->category_id && $category = $helper->getPostCategory(['id' => $data->category_id])){
            $args['parent_id'] = $data->category_id;
            if(!$title) $title = $category->name;
        }
        
    }
    if($data->title) $title = $data->title;
@endphp


@count($categories = $helper->getPostCategories($args))

<div class="widget categorie_widget">
    <h4 class="c_head">{{$title}}</h4>
    <ul class="list-unstyled categorie_list">
        @foreach ($categories as $category)
            
            <li><a href="{{$category->getViewUrl()}}" title="{{$category->name}}">{{$category->name}} <span>({{$category->post_count}})</span></a></li>
            
        @endforeach
    </ul>
</div>

@endcount
