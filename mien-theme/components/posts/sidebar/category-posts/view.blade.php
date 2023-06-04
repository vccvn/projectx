@php
    $url = null;
    $args = [
        '@limit' => $data->cate_number ? $data->cate_number : 10,
    ];
    $post_args = [
        '@limit' => $data->post_number ? $data->post_number : 20,
        '@sort' => $data->post_sorttype ? $data->post_sorttype : 1,
    ];
    $title = null;
    if ($data->get_by_dynamic_active && ($active = $helper->getActiveModel('dynamic'))) {
        $args['dynamic_id'] = $active->id;
        $post_args['dynamic_id'] = $active->id;
    } else {
        if ($data->dynamic_id && ($dynamic = $helper->getDynamic(['id' => $data->dynamic_id]))) {
            $args['dynamic_id'] = $data->dynamic_id;
            $post_args['dynamic_id'] = $data->dynamic_id;
        }
        if ($data->category_id && ($category = $helper->getPostCategory(['id' => $data->category_id]))) {
            $args['parent_id'] = $data->category_id;
        }
    }
@endphp

<div class="widget category-widget">
    @count($categories = $helper->getPostCategories($args))
        @foreach ($categories as $category)
            <div class="category-box box">
                <h3 class="box-title">
                    <a href="{{ $category->getViewUrl() }}">
                        {{ $category->name }}
                    </a>
                </h3>
                @php
                    $post_args['category_id'] = $category->id;
                @endphp
                @count($posts = $helper->getPosts($post_args))
                    <div class="box-body">
                        <ul class="post-list">

                            @foreach ($posts as $item)
                                <li><a href="{{ $item->getViewUrl() }}">{{ $item->title }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                @endcount
            </div>
        @endforeach
    @endcount

</div>
