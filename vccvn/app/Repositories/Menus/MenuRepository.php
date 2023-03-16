<?php

namespace App\Repositories\Menus;

use App\Engines\CacheEngine;
use App\Repositories\Base\BaseRepository;
use Crazy\Helpers\Arr;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Pages\PageRepository;

class MenuRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Menus\MenuValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'MenuResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'MenuCollection';
    
    protected $defaultSortBy = [
        'priority' => 'ASC'
    ];

    /**
     * danh muc bai viet
     *
     * @var CategoryRepository
     */
    public $categoryRepository;


    /**
     * trang
     *
     * @var PageRepository
     */
    public $pagetRepository;

    /**
     * dynamic
     *
     * @var DynamicRepository
     */
    public $dynamicRepository;
    
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Menu::class;
    }

    public function init()
    {
        $this->registerCacheMethod('getClientMenu');
        $this->categoryRepository = app(CategoryRepository::class);
        $this->pageRepository = app(PageRepository::class);
        $this->dynamicRepository = app(DynamicRepository::class);
        
        
    }

    public function beforeSave($data)
    {
        if(isset($data['positions'])){
            if(is_array($data['positions'])){
                $data['positions'] = ' '. implode(', ', $data['positions']) . ',';
            }else{
                $data['positions'] = '';
            }
        }
        return $data;
    }

    
    /**
     * sap xep lai thu tu
     * @param integer $id
     * @param integer $priority
     * @return void
     */
    public function updatePriority($id, $priority=0)
    {
        // nếu tìm không thấy id thì trả về false luôn
        if(!($menu = $this->findBy('id', $id))) return false;
        $c = $this->count();
        if($menu->priority==0 || $priority == 0){
            if($menu->priority==0){
                $menu->priority = $c;
                $menu->save();
                return true;
            }
            return $this->updatePriority($id, $c);
        }
        // nếu thứ tữ khác 0 và khác thứ tự cụ
        if($priority != $menu->priority){
            // nếu thứ tự lớn hơn tổng số thì gán thứ tự bằng tổng số
            if($priority > $c) $priority = $c;
            
            // xử lý trường hợp thay đổi vị trí trong khoảng 0 < priority < max

            $query = $this->newRepo()->where('id', '!=', $menu->id);
            
            // vị trí bắt đầu
            $begin = ($priority<$menu->priority)?$priority:$menu->priority;
            // vị trí kết thúc
            $end = ($priority>$menu->priority)?$priority:$menu->priority;    
            
            $query->whereBetween('priority',[$begin,$end]);
            
            if($list = $query->get()){
                if($priority > $menu->priority){
                    foreach($list as $item){
                        $item->priority = $item->priority - 1;
                        $item->save();
                    }
                    
                }
                else{
                    foreach($list as $item){
                        $item->priority = $item->priority + 1;
                        $item->save();
                    }
                }   
            }
            $menu->priority = $priority;
            $menu->save();
            return true;
        }
        return false;
    }


    /**
     * sửa thứ tự hiển thị
     *
     * @return void
     */
    public function repairPriority()
    {
        if(( $max = count($list = $this->orderBy('priority','DESC')->get()) ) > 0){
            // nếu có danh sách sẽ duyệt qua và sap91 xep71 từ cao đến thấp 
            foreach($list as $item){
                if($item->priority>$max){
                    $item->priority = $max;
                    $item->save();
                }
                $max--;
            }
        }
    }

    /**
     * sap xep 
     *
     * @param array $items
     * 
     * @return bool
     */
    public function sortMenus(array $items = [])
    {
        $status = true;
        if(count($list = $this->get())){
            foreach ($list as $menu) {
                if(!array_key_exists($menu->id, $items)){
                    $menu->delete();
                }elseif ($menu->priority != $items[$menu->id]) {
                    $menu->priority = $items[$menu->id];
                    $menu->save();
                }
            }
        }else{
            $status = false;
        }
        return $status;
    }

    
    /**
     * get thong tin menu
     *
     * @param string $position
     * @param array $args
     * 
     * @return array
     */
    public function getMenu($position = "custom", array $args = [])
    {
        if(!$args) return null;
        if($position) $this->like('positions', " $position,");
        $menu = $this->with(['items' => function($query){
            $query->with(['children' => function($query){
                $query->with(['children' => function($query){
                    $query->with('children');
                }]);
            }]);
        }])->first($args);
        if($menu) return $this->parseMenu($menu);
        return null;
    }


    
    /**
     * get thong tin menu
     *
     * @param string $position vị trí lấy menu
     * @param array $args Tham số
     * @param int $depth d065 sâu menu
     * @return array
     */
    public function getClientMenu($position = null, array $args = [], $depth = 4)
    {
        if(!$args && !$position) return [];
        if(is_array($position) && !$args){
            $args = $position;
            $position = null;
            if(isset($args['positions'])){
                if(is_array($args['positions'])){
                    // lam gi do
                }
                elseif($args['positions']) {
                    $position = $args['positions'];
                }
                unset($args['positions']);
            }
            if(isset($args['position'])){
                if(is_array($args['position'])){
                    // lam gi do
                }
                elseif($args['position']) {
                    $position = $args['position'];
                }
                unset($args['position']);
            }
        }
        
        if(isset($args['depth'])){
            if($args['depth'] > 0 && $args['depth'] < 5) $depth = $args['depth'];
            unset($args['depth']);
        }
        if(!$depth || $depth < 1 || $depth > 4) $depth = 4;
        $key = CacheEngine::getKey($position.'--depth--'.$depth, $args);
        if(!($data = get_web_data('__menu__'.$key))){
            if($position) $this->like('positions', " $position,");
            
            if($position || $args){
                $this->with(['items' => function($query) use($depth){
                    if($depth > 1){
                        $query->with(['children' => function($query) use($depth){
                            if($depth > 2){
                                $query->with(['children' => function($query) use($depth){
                                    if($depth > 3){
                                        $query->with('children');
                                    }
                                }]);
                            }
                        }]);
                    }
                }]);
                $menu = $this->first($args);
                // dd($menu);
                if($menu) $data = $this->parseMenu($menu, true, $depth);
                else $data = [];
            }
            else $data = [];
            
            set_web_data('__menu__'.$key, $data);
        }
        return $data;
    }


    /**
     * convert dạng menu chuẩn
     *
     * @param \App\Models\Menu $menu
     * @return void
     */
    public function parseMenu($menu, $generate_url = false, $depth = 4){
        $data = [];
        if($menu->items){
            $data = $this->parseItemList($menu->items, $generate_url, $depth, 0);
        }
        return $data;
    }

    /**
     * lấy danh sách item
     *
     * @param mixed $items
     * @return array
     */
    public function parseItemList($items, $generate_url = false, $depth = 4, $level = 0)
    {
        $list = [];
        if($items && is_countable($items) && count($items)){
            foreach ($items as $key => $item) {
                $list[] = $this->parseItem($item, $generate_url, $depth, $level);
            }
        }
        return $list;
    }

    /**
     * lấy thông tin item
     *
     * @param \App\Models\MenuItem $item
     * @return array
     */
    public function parseItem($item, $generate_url = false, $depth = 4, $level = 0)
    {
        $data = [];
        if(is_a($item, 'App\Models\MenuItem')){
            $props = $item->props;
            // $attrs = ['menu_id', 'parent_id', 'type', 'ref', 'ref_id', 'sub_type'];
            // foreach ($attrs as $attr) {
            //     $data[$attr] = $item->{$attr};
            // }
            $data['sub_type'] = $item->sub_type;
            $list = ['text', 'title', 'icon', 'class', 'link_class', 'target', 'active_key', 'show_submenu'];
            if($props && is_array($props)){
                foreach ($props as $key => $value) {
                    if(in_array($key, $list)) $data[$key] = $value;
                }
            }
            if(!$item->title){
                $data['title'] = $props['text'];
            }
            if($generate_url){
                $data['url'] = $item->getUrl();
            }

            $submenu = [];
            if($level < $depth -1){
                if(in_array($item->sub_type, ['default', 'custom', 'mega'])){
                    if(($children = $item->getRela('children')) && count($children)){
                        $submenu = array_merge($submenu, $this->parseItemList($children, $generate_url, $depth, $level+1) );
                    }
                }
                if($item->sub_type != 'custom'){
                    if(in_array($item->ref, ['post_category', 'product_category', 'project_category'])){
                        $submenu = array_merge($submenu, $this->renderChildrenByCategoryItem($item, $depth, $level));
                    }
                    elseif ($item->ref == 'dynamic') {
                        $submenu = array_merge($submenu, $this->renderCategoryByDynamicItem($item, $depth, $level));
                    }
                }
            }
            $data['submenu'] = $submenu;
            
            
        }
        return $data;
    }

    /**
     * tạo submenu danh mục từ dynamic item
     *
     * @param \App\Models\MenuItem $item
     * @param integer $depth
     * @param integer $level
     * @return array
     */
    public function renderCategoryByDynamicItem($item, $depth = 4, $level = 1)
    {
        $submenu = [];
        // thủ tục lấy các danh mục con
        $rep = $this->categoryRepository->cache('category-submenu-'.$item->ref_id . '--' . $depth . '--' . $level, system_setting()->cache_data_time(0));
        if($level<$depth-1){
            $rep->with(['children' => function($query) use($depth, $level){
                $query->where('deleted', 0);
                if($level<$depth-2){
                    $query->with(['children' => function($query) use($depth, $level){
                        $query->where('deleted', 0);
                        
                    }]);
                }
            }]);
        }
        if(count($categories = $rep->get(['parent_id' => 0, 'dynamic_id' => $item->ref_id, 'type' => 'post']))){
            $submenu = $this->renderCategories($categories);
        }
        return $submenu;
    }

    /**
     * tạo submenu danh mục
     *
     * @param \App\Models\MenuItem $item
     * @param integer $depth
     * @param integer $level
     * @return array
     */
    public function renderChildrenByCategoryItem($item, $depth = 4, $level = 1)
    {
        $submenu = [];
        // thủ tục lấy các danh mục con
        $rep = $this->categoryRepository->cache('category-submenu-'.$item->ref_id . '--' . $depth . '--' . $level, system_setting()->cache_data_time(0));
        if($level<$depth-1){
            $rep->with(['children' => function($query) use($depth, $level){
                $query->where('deleted', 0);
                if($level<$depth-2){
                    $query->with(['children' => function($query) use($depth, $level){
                        $query->where('deleted', 0);
                        
                    }]);
                }
            }]);
        }
        if(count($categories = $rep->get(['parent_id' => $item->ref_id]))){
            $submenu = $this->renderCategories($categories);
        }
        return $submenu;
    }

    /**
     * tao submenu tu danh sach danh mux
     *
     * @param \App\Masks\Categories\CategoryCollection $categories
     * @return void
     */
    protected function renderCategories($categories){
        $submenu = [];
        foreach ($categories as $key => $category) {
            $item = [
                'title' => $category->name,
                'text' => $category->name,
                'active_key' => $category->slug,
                'url' => $category->getViewUrl()
            ];
            if($children = $category->getRela('children')){
                $item['submenu'] = $this->renderCategories($children);
            }
            $submenu[] = $item;
        }
        return $submenu;
    }


    
    /**
     * tạo submenu rừ page item
     *
     * @param \App\Models\MenuItem $item
     * @param integer $depth
     * @param integer $level
     * @return array
     */
    public function renderChildrenByPageItem($item, $depth = 4, $level = 1)
    {
        $submenu = [];
        // thủ tục lấy các danh mục con
        $rep = $this->pageRepository->cache('page-submenu-'.$item->ref_id . '--' . $depth . '--' . $level, system_setting()->cache_data_time(0));
        if($level<$depth-1){
            $rep->with(['children' => function($query) use($depth, $level){
                $query->where('deleted', 0);
                if($level<$depth-2){
                    $query->with(['children' => function($query) use($depth, $level){
                        $query->where('deleted', 0);
                        
                    }]);
                }
            }]);
        }
        if(count($pages = $rep->get(['parent_id' => $item->ref_id]))){
            $submenu = $this->renderPages($pages);
        }
        return $submenu;
    }


    
    /**
     * tao submenu tu danh sach danh mux
     *
     * @param \App\Masks\Pages\PageCollection $categories
     * @return void
     */
    protected function renderPages($pages){
        $submenu = [];
        foreach ($pages as $key => $page) {
            $item = [
                'title' => $page->name,
                'text' => $page->name,
                'active_key' => $page->slug,
                'url' => $page->getViewUrl()
            ];
            if($children = $page->getRela('children')){
                $item['submenu'] = $this->renderPages($children);
            }
            $submenu[] = $item;
        }
        return $submenu;
    }

}