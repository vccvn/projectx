<?php

namespace App\Repositories\Menus;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Pages\PageRepository;
use App\Repositories\Posts\CategoryRepository as PostCategoryRepository;
use App\Repositories\Projects\CategoryRepository as ProjectCategoryRepository;
use App\Repositories\Products\CategoryRepository as ProductCategoryRepository;

use App\Engines\JsonData;
use App\Repositories\Posts\PostRepository;
use Crazy\Helpers\Arr;

class ItemRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Menus\ItemValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'MenuItemResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'MenuItemCollection';

    protected static $menuID = 0;

    /**
     * ref type khả dụng
     *
     * @var array
     */
    public $refTypes = [
        'page'                 => PageRepository::class,
        'post'                 => PostRepository::class,
        'dynamic'              => DynamicRepository::class, 
        'post_category'        => PostCategoryRepository::class, 
        'product_category'     => ProductCategoryRepository::class, 
        'project_category'     => ProjectCategoryRepository::class
    ];

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\MenuItem::class;
    }

    
    /**
     * ham lấy và lọc dử liệu
     * 
     * @return model
     */
    public function getDetail(array $args = [])
    {
        $this->buildJoin();
        $this->buildSelect();
        return $this->with(['children' => function($query){
            $query->with(['children' => function($query){
                $query->with('children');
            }]);
        }])->first($args);
    }

    
    /**
     * thiết lập menu id
     *
     * @param integer $menuID
     * @return void
     */
    public static function setMenuID($menuID = 0)
    {
        static::$menuID = $menuID;
    }

    public static function getMenuID()
    {
        return static::$menuID;
    }

    /**
     * lấy các item có parent id bằng 0
     *
     * @param int $menu_id
     * @return Collection
     */
    public function getMenuRootItems($menu_id)
    {
        return $this->orderBy('priority', 'ASC')
                ->with(['children' => function($query){
                    $query->with(['children' => function($query){
                        $query->with('children');
                    }]);
                }])
                ->get([
                    'menu_id' => $menu_id,
                    'parent_id' => 0
                ]);
    }


    public function getTree($menu_id)
    {
        return $this->with(['children' => function($query){
            $query->with(['children' => function($query){
                $query->with('children');
            }]);
        }])->get([
            'menu_id' => $menu_id,
            'parent_id' => 0
        ]);
    }

    /**
     * lấy thông tin group input để thêm menu item
     * @return array
     */
    public function getInputGroup()
    {
        // danh sách và thông tin input
        // owner
        // $owner = get_owner();
        $web_type = get_web_type();
        $engine = new JsonData();
        // lấy thông tin input và group
        $form = $engine->getData('admin/forms/menus.items'); // lay du lieu tu cache store hoac file json
        $inputs = $form['inputs'];
        $inputGroups = [];
        $formGroup = $form['config']['form_groups'];

        // phân loại các nhóm
        // các nhóm cơ bản
        $groups = array_copy($formGroup, 'url', 'route', 'page', 'dynamic');

        if($web_type == 'ecommerce'){
            // thuong mai dien tu
            $groups['product_category'] = $formGroup['product_category'];
        }
        elseif(in_array($web_type, ['personal', 'business'])){
            // trang gioi thieu
            $groups['project_category'] = $formGroup['project_category'];
        }
        // tong hop lai thong tin cac nhom 
        foreach ($groups as $key => $group) {
            $g = [
                'text' => $group['text'],
                'icon' => $group['icon']
            ];
            $inputList = array_copy($inputs, $group['inputs']);
            $g['inputs'] = $inputList;
            $inputGroups[$key] = $g;
        }

        // bo xung them danh muc bai viet
        if(count($dynamics = get_dynamics())){
            // lay list danh muc cua cac kenh co yeu cau danh muc
            foreach ($dynamics as $dynamic) {
                $g = [
                    'text' => $dynamic->name,
                    'icon' => 'flaticon-list',
                    'dynamic_id' => $dynamic->id
                ];
                $g['inputs'] = array_copy($inputs, $formGroup['post']['inputs']);
                if(!isset($g['inputs']['post_id']['params']) || !is_array($g['inputs']['post_id']['params'])) $g['inputs']['post_id']['params'] = [];
                $g['inputs']['post_id']['params'][0] = ['dynamic_id' => $dynamic->id];
                $g['inputs']['post_id']['id'] = 'post_id-dynamic-'.$dynamic->id;
                $g['inputs']['post_id']['label'] = $dynamic->name;
                $inputGroups['post-'.$dynamic->id] = $g;

                if($dynamic->use_category){
                    $g = ['text' => "Danh muc ".$dynamic->name, 'icon' => 'flaticon-folder-1'];
                    $g['inputs'] = array_copy($inputs, $formGroup['post_category']['inputs']);
                    $g['inputs']['post_category_id']['params'] = [['dynamic_id' => $dynamic->id]];
                    $g['inputs']['post_category_id']['id'] = 'post_category_id-dynamic-'.$dynamic->id;
                    $inputGroups[$dynamic->id] = $g;
                }
                

                
            }
        }

        return $inputGroups;
    }

    /**
     * lấy thông tin ref theo type
     *
     * @param string $type
     * @param Arr $props
     * @param int $id
     * @return array
     */
    public function getRefData($type, $props, $id = 0)
    {
        $data = ['ref' => null, 'ref_id' => 0];
        $types = ['page','dynamic', 'post_category', 'product_category', 'project_category', 'post'];
        $text = $props->text;
        if(!$text && $id && $item = $this->findBy('id', $id)){
            if(isset($item->props['text']) && $item->props['text']){
                $text=$item->props['text'];
            }
        }
        if(in_array($type, $types)){
            $ref_id = $props->{$type.'_id'} ? $props->{$type.'_id'} : 0;
            $data['ref'] = $type;
            $data['ref_id'] = $ref_id;
            $ref = app($this->refTypes[$type])->findBy('id', $ref_id);
            if(!$text) $text = $ref?($ref->name?$ref->name:$ref->title):'Menu Item';
            if($type == 'post_category' && $ref){
                $props->dynamic_id = $ref->dynamic_id;
            }elseif($type == 'post' && $ref){
                $props->dynamic_id = $ref->dynamic_id;
            }
        }
        $props->text = $text;
        return $data;
    }

    /**
     * sap xep item
     *
     * @param array $data
     * @param integer $parent_id
     * @return array
     */
    public function sortItems($data = [], $parent_id = 0)
    {
        $return = [];
        if(is_array($data)){
            foreach ($data as $orderNumber => $item) {
                if(isset($item['id'])){
                    if($itemSaved = $this->update($item['id'], ['priority' => $orderNumber + 1, 'parent_id' => $parent_id])){
                        $it = ['id' => $item['id']];
                        if(isset($item['children']) && $item['children']){
                            $it['children'] = $this->sortItems($item['children'], $item['id']);
                        }
                        $return[] = $it;
                    }
                    
                }
            }
        }
        return $return;
    }

    /**
     * tạo menu item
     *
     * @param array $items
     * @param integer $menu_id
     * @param integer $parent_id
     * @return array
     */
    public function createItems($items = [], int $menu_id, int $parent_id = 0)
    {
        $menuItems = [];
        if(count($items)){
            $a = new Arr([]);
            $i = 1;
            foreach($items as $item){
                $itemData = new Arr($item);
                $sub = [];
                if($itemData->submenu){
                    $sub = $itemData->submenu;
                    $itemData->remove('submenu');
                }
                $props = $itemData->cutWithout(['menu_id', 'parent_id', 'priority', 'type', 'ref', 'ref_id', 'sub_type', 'props']);
                if($itemData->props){
                    $itemData->props = array_merge($itemData->props, $props);
                }else{
                    $itemData->props = $props;
                }
                $itemData->merge(compact('menu_id', 'parent_id'));
                $itemData->priority = $i;
                if($menuItem = $this->create($itemData->all())){
                    if(count($sub)){
                        $menuItem->submenu = $this->createItems($sub, $menu_id, $menuItem->id);
                    }
                    $menuItems[] = $menuItem;
                    $i++;
                }
            }
        }
        return $menuItems;
    }
}