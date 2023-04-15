@if (count($tags = $helper->getTags(['@sort'=> $data->sorttype, '@limit' => $data->tag_number])))

    <div class="sidebar-item tags">
        <div class="title">
            <h4>{{$data->title}}</h4>
        </div>
        <div class="sidebar-info">
            <ul>
                @foreach ($tags as $tag)
                <li>
                    <a href="{{route('client.posts.tag', ['tag' => $tag->slug])}}">{{$tag->name}}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    


@endif