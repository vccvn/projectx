@php
    $args = [
        '@limit' => $data->post_number?$data->post_number:20,
        '@sort' => $data->sorttype?$data->sorttype:1
    ];
    $title = null;
    if($data->dynamic_id && $dynamic = $helper->getDynamic(['id' => $data->dynamic_id])){
        $args['dynamic_id'] = $data->dynamic_id;
        $title = $dynamic->name;
    }
    if($data->category_id && $category = $helper->getPostCategory(['id' => $data->category_id])){
        $args['@category'] = $data->category_id;
        if(!$title) $title = $category->name;
    }
    
    if($data->content_type && $data->content_type != 'all'){
        $args['content_type'] = $data->content_type;
    }
    if($data->title) $title = $data->title;
    
@endphp

    <div class="sidebar-item recent-post">
        <div class="title">
            <h4>{{$title?$title:'Mới nhất'}}</h4>
        </div>
        <ul>
            @if (count($list = $helper->getPosts($args)))
                @foreach ($list as $item)
                    
                
            <li>
                <div class="info">
                    <a href="{{$item->getViewUrl()}}">{{$item->title}}</a>
                    <div class="meta-title">
                        <span class="post-date">{{$item->dateFormat('d/m/Y')}}</span></a>
                    </div>
                </div>
            </li>

                @endforeach
            @endif
        </ul>
    </div>