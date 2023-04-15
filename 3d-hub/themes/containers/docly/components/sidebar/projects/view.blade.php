@php
    $args = [
        '@limit' => $data->project_number?$data->project_number:20,
        '@sort' => $data->sorttype?$data->sorttype:1
    ];
    $title = null;
    if($data->category_id && $category = $helper->getProjectCategory(['id' => $data->category_id])){
        $args['@category'] = $data->category_id;
        if(!$title) $title = $category->name;
    }
    
    if($data->title) $title = $data->title;
    
@endphp

<div class="widget recent_news_widget">
    <h4 class="c_head">{{$title?$title:'Mới nhất'}}</h4>
    @if (count($list = $helper->getProjects($args)))
        @foreach ($list as $item)
            
     
    <div class="media recent_post_item">
        <a href="{{$u = $item->getViewUrl()}}"><img src="{{$item->getImage('90x90')}}" alt="{{$item->title}}"></a>
        
        <div class="media-body">
            <a href="{{$u}}">
                <h5>{{$item->title}}</h5>
            </a>
            <div class="entry_post_date">{{$item->dateFormat('d/m/Y')}}</div>
        </div>
    </div>
    

        @endforeach
    @endif
</div>
