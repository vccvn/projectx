@php
    $args = [
        '@limit' => $data->number_comment(5),
        '@order_by' => ['id' => 'DESC']
    ];
    if($data->ref && $data->ref != 'all'){
        $args['ref'] = $data->ref;
    }
@endphp


@count($comments = $helper->getComments($args))
<div class="widget comments_widget">
    <h4 class="c_head">{{$data->title('Bình luận mới')}}</h4>
    <ul class="list-unstyled recent_comments">
        @foreach ($comments as $comment)
            @php
                // $avatar = ($comment->author_id && $author = get_model_data('user', $comment->author_id)) ? get_user_avatar($author->avatar) : asset('images/default/avatar.png');
                $refer = $comment->refer;
            @endphp
            <li>
                <h6><i class="icon_chat_alt"></i>{{$comment->author_name}}:</h6>
                <a href="{{$refer?$refer->getViewUrl():'#'}}" class="text">
                    {{$comment->sub('message', 120, '...')}}
                </a>
            </li>


        @endforeach
    </ul>
</div>

@endcount
