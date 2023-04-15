@php
    $args = [
        '@limit' => $data->post_number?$data->post_number:4,
        '@sort' => $data->sorttype?$data->sorttype:1
    ];
    $title = null;
    if($data->dynamic_id && $dynamic = $helper->getDynamic(['id' => $data->dynamic_id])){
        $args['dynamic_id'] = $data->dynamic_id;
        $title = $dynamic->name;
    }
    if($data->category_id && $category = $helper->getPostCategory(['id' => $data->category_id])){
        $args['@category'] = $data->category_id;
        $title = $category->name;
        
    }
    
    if($data->title) $title = $data->title;
    
    
@endphp

                <div class="equal-height col-md-3 col-sm-6 item">
                    <div class="f-item recent-post">
                        <h4 class="widget-title">{{$title?$title:'Tin bài'}}</h4>
                        @count($posts = $helper->getPosts($args))
                            @foreach ($posts as $post)
                            
                        <div class="single">
                            <div class="content">
                                <a href="{{$post->getViewUrl()}}">
                                    {{$post->title}}
                                </a>
                                <ul class="meta">
                                    <li>
                                        <i class="ti-calendar"></i> {{$post->dateFormat('d/m/Y')}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                            @endforeach
                        @endcount


                    </div>
                </div>