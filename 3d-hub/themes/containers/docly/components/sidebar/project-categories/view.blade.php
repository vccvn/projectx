@php
    $url = null;
    $args = [
        '@limit' => $data->cate_number?$data->cate_number:10,
        '@withCountProjects' => 'project_count',
    ];
    $title = null;
    if($data->parent_id && $category = $helper->getProjetCategory(['id' => $data->parent_id])){
        $args['parent_id'] = $data->parent_id;
        if(!$title) $title = $category->name;
    }
    
    if($data->title) $title = $data->title;
@endphp


@count($categories = $helper->getProjectCategories($args))

<div class="widget categorie_widget">
    <h4 class="c_head">{{$title}}</h4>
    <ul class="list-unstyled categorie_list">
        @foreach ($categories as $category)
            
            <li><a href="{{$category->getViewUrl()}}" title="{{$category->name}}">{{$category->name}} <span>({{$category->project_count}})</span></a></li>
            
        @endforeach
    </ul>
</div>

@endcount
