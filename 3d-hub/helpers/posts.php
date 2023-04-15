<?php

use App\Engines\ShortCode;
use App\Masks\Categories\CategoryCollection;
use App\Masks\Categories\CategoryMask;
use App\Repositories\Comments\CommentRepository;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Posts\CategoryRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Tags\TagRepository;
use App\Repositories\Pages\PageRepository;
use App\Repositories\Posts\SearchRepository;
use App\Repositories\Projects\CategoryRepository as ProjectsCategoryRepository;

if (!function_exists('get_parse_query_args')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return array
     */
    function get_parse_query_args(array $params = [])
    {
        return array_merge([
            'deleted' => 0,
            'privacy' => 'public',
            'approved' => 1
        ], $params);
    }
}


if (!function_exists('get_dynamic')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Dynamic
     */
    function get_dynamic(array $params = [])
    {
        return app(DynamicRepository::class)->cache('dynamic-get-detail', system_setting()->cache_data_time, $params)->mode('mask')->detail(get_parse_query_args($params));
    }
}
if (!function_exists('get_post_channel')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Dynamic
     */
    function get_post_channel(array $params = [])
    {
        return get_dynamic($params);
    }
}

if (!function_exists('get_dynamics')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Dynamic[]
     */
    function get_dynamics(array $params = [])
    {
        return app(DynamicRepository::class)->mode('mask')->cache('dynamic-get-list', system_setting()->cache_data_time, $params)->getData(get_parse_query_args($params));
    }
}

if (!function_exists('get_post_channels')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Dynamic
     */
    function get_post_channels(array $params = [])
    {
        return get_dynamics($params);
    }
}
if (!function_exists('count_dynamic')) {
    /**
     * đếm nội dung
     * @param array $params
     * @return int
     */
    function count_dynamic(array $params = [])
    {
        return app(DynamicRepository::class)->count(get_parse_query_args($params));
    }
}

if (!function_exists('get_post_category')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Category
     */
    function get_post_category(array $params = [])
    {
        if ($category = app(CategoryRepository::class)->avaliableCategory()->first(get_parse_query_args($params))) {
            return new CategoryMask($category);
        }
        return null;
    }
}



if (!function_exists('get_post_categories')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Category[]
     */
    function get_post_categories(array $params = [])
    {
        if (count($categories = app(CategoryRepository::class)->mode('mask')->avaliableCategory()->getCategories(get_parse_query_args($params)))) {
            return $categories;
        }
        return [];
    }
}



if (!function_exists('get_posts')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Post[]
     */
    function get_posts(array $params = [])
    {
        return app(PostRepository::class)->mode('mask')->getData(get_parse_query_args($params));
    }
}

if (!function_exists('get_related_posts')) {
    /**
     * lấy thông tin bài viết lên quan
     * @param \App\Models\Post|\App\Masks\Posts\PostMask $post
     * @param int $limit
     * @return \App\Models\Post[]
     */
    function get_related_posts($post, $limit = 4)
    {
        /**
         * @var \App\Repositories\Posts\SearchRepository
         */
        $repo = app(SearchRepository::class)->mode('mask');
        $repo->where('id', '!=', $post->id)->limit($limit > 0 ? $limit : 4);
        $params = [
            'dynamic_id' => $post->dynamic_id,
            'category_id' => $post->category_id,
            'parent_id' => $post->parent_id,
            '@order_by' => 'rand()'
        ];
        return $repo->getData(get_parse_query_args($params));
    }
}


if (!function_exists('get_post')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Post[]
     */
    function get_post(array $params = [])
    {
        return app(PostRepository::class)->mode('mask')->detail(get_parse_query_args($params));
    }
}




if (!function_exists('get_post_sortby_options')) {
    /**
     * thông tin sap xep san phẩm
     *
     * @return array
     */
    function get_post_sortby_options()
    {
        $options = get_general_config('posts.list.sortby', []);

        return $options;
    }
}

if (!function_exists('get_content_type_options')) {
    /**
     * thông tin sap xep san phẩm
     *
     * @return array
     */
    function get_content_type_options($defaultFirst = null)
    {
        $options = get_general_config('posts.list.content_type', []);
        if ($defaultFirst) {
            $options = ["" => $defaultFirst] + $options;
        }
        return $options;
    }
}


if (!function_exists('get_category_sortby_options')) {
    /**
     * thông tin sap xep danh mục chung
     *
     * @return array
     */
    function get_category_sortby_options()
    {
        $options = get_general_config('categories.list.sortby', []);
        return $options;
    }
}


if (!function_exists('get_post_category_sortby_options')) {
    /**
     * thông tin sap xep danh mục bài viết
     *
     * @return array
     */
    function get_post_category_sortby_options()
    {
        $options = get_general_config('categories.list.sortby', []);
        return $options;
    }
}




if (!function_exists('get_pages')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Page[]
     */
    function get_pages(array $params = [])
    {
        return app(PageRepository::class)->mode('mask')->getData(get_parse_query_args($params));
    }
}


if (!function_exists('get_page')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Page
     */
    function get_page(array $params = [])
    {
        return app(PageRepository::class)->mode('mask')->detail(get_parse_query_args($params));
    }
}





// if(!function_exists('get_dynamic_options')){
//     /**
//      * lấy mục nội dung
//      * @param array $params
//      * @return \App\Models\Dynamic[]
//      */
//     function get_dynamic_options(array $params = [])
//     {
//         $data = ["" => 'Chọn một'];
//         if(count($dynamics = get_dynamics($params))){
//             foreach ($dynamics as $dynamic) {
//                 $data[$dynamic->id] = $dynamic->name;
//             }
//         }
//         return $data;
//     }
// }


if (!function_exists('admin_dynamic_url')) {
    /**
     * lấy dương dẫn mục nội dung
     * @param string $module
     * @param array $params
     * @return string
     */
    function admin_dynamic_url($module, array $params = [])
    {
        $url = null;
        if (isset($params['dynamic']) && $params['dynamic']) {
            $url = route('admin.posts.' . $module, $params);
        } elseif ($dynamic = get_web_data('dynamic')) {
            $url = route('admin.posts.' . $module, array_merge($params, [
                'dynamic' => $dynamic->slug,
            ]));
        }
        return $url;
    }
}





if (!function_exists('admin_check_dynamic')) {
    /**
     * kiểm tra mục nội dung đã được set hay chưa
     * @param string $module
     * @param array $params
     * @return string
     */
    function admin_check_dynamic()
    {
        static $isCheck = false;
        static $status = false;
        if ($isCheck) return $status;
        $request = request();
        if ($request->dynamic && $dynamic = app(DynamicRepository::class)->first(['slug' => $request->dynamic])) {
            $isCheck = true;
            if ($dynamic->deleted) {
                $status = false;
            } else {
                // set dynamic id cho post va category
                CategoryRepository::setDynamicID($dynamic->id);
                PostRepository::setDynamicID($dynamic->id);
                $dynamic->applyMeta();
                set_web_data('dynamic', $dynamic);
                view()->share('dynamic', $dynamic);
                $status = true;
            }

            return $status;
        }
        return false;
    }
}

if (!function_exists('get_dynamic_options')) {
    /**
     * lấy dynamic option
     * @param array $args
     * @return array mảng [key => value]
     */
    function get_dynamic_options(array $args = [], $defaultFirst = null): array
    {
        return DynamicRepository::getSelectOptions(get_parse_query_args($args), $defaultFirst);
    }
}


if (!function_exists('get_page_options')) {
    /**
     * lấy dynamic option
     * @param array $args
     * @return array mảng [key => value]
     */
    function get_page_options(array $args = []): array
    {
        return PageRepository::getPageSelectOptions($args);
    }
}

if (!function_exists('get_post_options')) {
    /**
     * lấy dynamic option
     * @param array $args
     * @return array mảng [value => text]
     */
    function get_post_options($args = [], $defaultFirst = null, $value_key = 'id', $text_key = 'title'): array
    {
        return app(PostRepository::class)->getPostOptions($args, $defaultFirst, $value_key, $text_key);
    }
}


if (!function_exists('get_post_category_options')) {
    /**
     * lấy dynamic option
     * @param array $args
     * @param bool $require_dynamic_id kiểm tra tham số truyền vào có chứa fynamic id hay không? nếu ko trả về mảng ["Không"]
     * @return array mảng [key => value]
     */
    function get_post_category_options(array $args = [], $require_dynamic_id = false): array
    {
        if ($require_dynamic_id && (!isset($args['dynamic_id']) || !$args['dynamic_id'])) return ["-- Chọn một --"];
        return CategoryRepository::getCategorySelectOptions(array_merge(['deleted' => 0], $args));
    }
}


if (!function_exists('get_post_cate_options')) {
    /**
     * lấy dynamic option
     * @param array $args
     * @return array mảng [value => text]
     */
    function get_post_cate_options($args = [], $defaultFirst = null, $value_key = 'id', $text_key = 'name'): array
    {
        $args = array_merge(['parent_id' => 0], $args);
        return app(CategoryRepository::class)->getDataOptions($args, $defaultFirst, $value_key, $text_key);
    }
}


if (!function_exists('get_parent_page_options')) {
    /**
     * lấy danh sach danh mục cha
     * @param array $args tham số
     * @return array
     */
    function get_parent_page_options(...$args)
    {
        return PageRepository::getParentSelectOptions(...$args);
    }
}





if (!function_exists('get_tags')) {
    /**
     * lấy danh sách tag
     * @param array $args
     */
    function get_tags(array $args = [])
    {
        return (new TagRepository())->getTags($args);
    }
}

if (!function_exists('get_ref_tags')) {
    /**
     * lấy danh sách tag
     * @param string $ref
     * @param int $ref_id
     * @param array $args
     */
    function get_ref_tags(string $ref = 'post', $ref_id = 0, array $args = [])
    {
        return (new TagRepository())->getRefTags($ref, $ref_id, $args);
    }
}

if (!function_exists('get_tag_sortby_options')) {
    /**
     * thông tin sap xep danh mục bài viết
     *
     * @return array
     */
    function get_tag_sortby_options()
    {
        $options = get_general_config('tags.list.sortby', []);
        return $options;
    }
}

if (!function_exists('get_input_tag_data')) {
    /**
     * lấy danh sách tag
     * @param string $ref
     * @param int $ref_id
     * @param array $args
     */
    function get_input_tag_data(string $ref = 'post', $ref_id = 0, array $args = [])
    {
        $data = [];
        if (!$ref_id) return $data;
        if (count($tags = get_ref_tags($ref, $ref_id, $args))) {
            foreach ($tags as $tag) {
                $data[] = [
                    'id' => $tag->id,
                    'name' => $tag->name
                ];
            }
        }
        return $data;
    }
}



if (!function_exists('get_search_ref_options')) {
    /**
     * lấy mục ref tìm kiếm
     * @return array
     */
    function get_search_ref_options()
    {
        $data = ["" => 'Tất cả'];
        $webType = get_web_type();
        if (in_array($webType, ['personal', 'business'])) {
            $data['project'] = 'Dự án';
        }
        if (count($dynamics = get_dynamics())) {
            foreach ($dynamics as $dynamic) {
                $data[$dynamic->slug] = $dynamic->name;
            }
        }
        $data['page'] = 'Trang';
        return $data;
    }
}

if (!function_exists('catelist2menu')) {
    /**
     * Chuyển đổi list danh mục thành menu data
     * @param array|App\Masks\Categories\CategoryCollection $categories
     * @return array
     */
    function catelist2menu($categories)
    {
        $menu = [];

        if ($categories && count($categories)) {
            /**
             * render danh muc
             * @param App\Masks\Categories\CategoryCollection $categories
             * @param Closure $renderChildren
             */
            $renderCategory = function ($category, $renderChildren, $renderCategory) {
                $data = [];
                if ($category) {
                    $data = [
                        'text' => $category->name,
                        'url' => $category->getViewUrl(),
                        'active_key' => $category->slug
                    ];
                    if ($category->children && count($category->children)) {
                        $data['submenu'] = $renderChildren($category->children, $renderChildren, $renderCategory);
                    }
                }
                return $data;
            };
            $renderList = function ($children, $renderChildren, $renderCategory) {
                $list = [];
                foreach ($children as $child) {
                    $list[] = $renderCategory($child, $renderChildren, $renderCategory);
                }
                return $list;
            };
            $menu = $renderList($categories, $renderList, $renderCategory);
        }

        return $menu;
    }
}


if (!function_exists('get_comment_ref_options')) {
    /**
     * lấy option mục tham chiếu của bình luận
     * @param string $defaultFirst text hien thi cua option dau tien
     * @param string|int|float|double $defaultFirstValue  gia tri mac dinh cua option dau tien
     * @return array
     */
    function get_comment_ref_options($defaultFirst = null, $defaultFirstValue = null)
    {
        $data = [];
        if ($defaultFirst || !is_null($defaultFirstValue)) {
            if ($defaultFirst) {
                if (!is_null($defaultFirstValue)) {
                    $data[$defaultFirstValue] = $defaultFirst;
                } else {
                    $data[''] = $defaultFirst;
                }
            } else {
                $data[$defaultFirstValue] = $defaultFirstValue;
            }
        }
        $options = get_general_config('comments.list.refs', []);
        if ($data) $options = $data + $options;
        switch (get_web_type()) {
            case 'ecommerce':
                unset($options['project']);
                break;
            case 'personal':
            case 'business':
                unset($options['product']);
                break;
            default:
                unset($options['project'], $options['product']);
                break;
        }
        return $options;
    }
}




if (!function_exists('get_comments')) {
    /**
     * lấy danh sach Binh luan 
     * @param array $params
     * @return \App\Models\Comment[]
     */
    function get_comments(array $params = [])
    {
        return app(CommentRepository::class)->mode('mask')->getComments(get_parse_query_args($params));
    }
}


if (!function_exists('get_comment')) {
    /**
     * lấy Binh luan
     * @param array $params
     * @return \App\Models\Comment
     */
    function get_comment(array $params = [])
    {
        return app(CommentRepository::class)->mode('mask')->detail(get_parse_query_args($params));
    }
}


if (!function_exists('get_project_category')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Category
     */
    function get_project_category(array $params = [])
    {
        if ($category = app(ProjectsCategoryRepository::class)->avaliableCategory()->first(get_parse_query_args($params))) {
            return new CategoryMask($category);
        }
        return null;
    }
}



if (!function_exists('get_project_categories')) {
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Category[]
     */
    function get_project_categories(array $params = [])
    {
        if (count($categories = app(ProjectsCategoryRepository::class)->mode('mask')->avaliableCategory()->getCategories(get_parse_query_args($params)))) {
            return $categories;
        }
        return [];
    }
}



if (!function_exists('add_shortcode')) {
    /**
     * lấy Binh luan
     * @param string $tag
     * @param callable $callable
     * @return mixed
     */
    function add_shortcode($tag, $callable)
    {
        return ShortCode::getInstance()->add($tag, $callable);
    }
}
if (!function_exists('has_shortcode')) {
    /**
     * lấy Binh luan
     * @param string $tag
     * @return mixed
     */
    function has_shortcode($content, $tag)
    {
        return ShortCode::getInstance()->has($content, $tag);
    }
}

if (!function_exists('check_shortcode')) {
    /**
     * lấy Binh luan
     * @param string $tag
     * @return mixed
     */
    function check_shortcode($tag)
    {
        return ShortCode::getInstance()->exists($tag);
    }
}


if (!function_exists('do_shortcode')) {
    /**
     * lấy Binh luan
     * @param string $tag
     * @return mixed
     */
    function do_shortcode($content)
    {
        return ShortCode::getInstance()->doShortCode($content);
    }
}
