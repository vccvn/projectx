@if (count($tags = $helper->getTags(['@sort'=> $data->sorttype, '@limit' => $data->tag_number])))


<div class="widget tag_widget">
    <h4 class="c_head">{{$data->title('Thẻ bải viết')}}</h4>
    <ul class="list-unstyled w_tag_list">
        @foreach ($tags as $tag)
        <li>
            <a href="{{route('client.posts.tag', ['tag' => $tag->slug])}}">{{$tag->name}}</a>
        </li>
        @endforeach
    </ul>
</div>

    


@endif