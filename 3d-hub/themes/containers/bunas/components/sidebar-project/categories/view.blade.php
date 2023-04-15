@php
    $url = null;
    $args = [
        '@limit' => $data->cate_number?$data->cate_number:10,
        '@sort' => $data->sorttype?$data->sorttype:10,
        '@advance' => ['project_count']
    ];
    $title = null;
    if($data->title) $title = $data->title;
@endphp


@count($categories = $helper->getProjectCategories($args))


<div class="sidebar-item category">
    <div class="title">
        <h4>{{$title}}</h4>
    </div>
    <div class="sidebar-info">
        <ul>
            @foreach ($categories as $category)
            
            <li><a href="{{$category->getViewUrl()}}" title="{{$category->name}}">{{$category->name}} <span>({{$category->post_count}})</span></a></li>
            
            @endforeach
        </ul>
    </div>
</div>
@endcount
