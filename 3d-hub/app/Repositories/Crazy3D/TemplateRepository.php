<?php

namespace App\Repositories\Crazy3D;

use App\Models\Crazy3DTemplate;
use App\Repositories\Base\BaseRepository;
use Crazy\Files\Filemanager;

class TemplateRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Crazy3D\TemplateValidator';
    
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Crazy3D\TemplateMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Crazy3D\TemplateCollection';

    /**
     * item ref repository
     *
     * @var ItemRefRepository
     */
    protected $itemRefRepository = null;

    /**
     * item ref repository
     *
     * @var ModelItemRepository
     */
    protected $itemRepository = null;

    /**
     * @var Filemanager
     */
    protected $filemanager = null;
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Crazy3DTemplate::class;
    }

    
    /**
     * @var array $defaultSortBy Mảng key value là tên cộ và kiểu sắp xếp
     */
    protected $defaultSortBy = [
        'crazy_3d_templates.id' => 'DESC'
    ];



    public function init()
    {
        $this->filemanager = new Filemanager();
        $this->itemRefRepository = app(ItemRefRepository::class);
        $this->itemRepository = app(ModelItemRepository::class);
    }

    /**
     * Cập nhật dữ liệu
     * @param Crazy3DTemplate|int $id
     * @param array $data
     * @return boolean
     */
    public function updateData($id, $data)
    {
        $template = is_object($id) && is_a($id, Crazy3DTemplate::class) ? $id: (($a = $this->findBy('id', $id))? $a : null);
        if(!$template) return false;
        $objects = [];
        if(array_key_exists('objects', $data)){
            $objects = $data['objects'];
            unset($data['objects']);
        }
        $structureData = $this->filemanager->json(json_path('data/3d/template.json'));
        unset($structureData['lights'], $structureData['objects']);
        $data = array_assign_structure_if_not_exists($data, $structureData);
        // die(json_encode($data));
        if(array_key_exists('lights', $data) && count($data['lights'])){
            $check = [
                'type'=>__STRING__, 
                'secret_key?' => __STRING__,
                'data' => [
                    'params' => __ARRAY__, 
                    'props?' => [
                        'position?' => [
                            'x?' => __NUMERIC__,
                            'y?' => __NUMERIC__,
                            'z?' => __NUMERIC__
                        ]
                    ]
                ]
            ];
            if(!array_check_structure($data['lights'], ['*' => $check])) return false;
        }
        if($objects && is_array($objects)){
            $check = [
                'type' => 'model',
                'secret_key?' => __STRING__,
                'data' => [
                    'id' => __INT__,
                    'settings?' => [
                        'props?' => [
                            'position?' => [
                                'x?' => __NUMERIC__,
                                'y?' => __NUMERIC__,
                                'z?' => __NUMERIC__
                            ],
                            'rotation?' => [
                                'x?' => __NUMERIC__,
                                'y?' => __NUMERIC__,
                                'z?' => __NUMERIC__
                            ],
                            'scale' => [
                                'x?' => __NUMERIC__,
                                'y?' => __NUMERIC__,
                                'z?' => __NUMERIC__
                            ],
                            "castShadow" => __BOOLEAN__,
                            "receiveShadow" => __BOOLEAN__
                        ],
                        'meshes?' => [
                            '*' => [
                                'name' => __STRING__,
                                'data?' => [
                                    'material?' => __ARRAY__
                                ]
                            ]
                        ]
                    ]
                ]
            ];
            if(!array_check_structure($objects, ['*' => $check])) return false;
        }
        $a = $this->updateModelItemRefs($template->id, $objects);
        if(!$a) return false;
        $template->__data__ = $data;
        return $template->save();
    }

    /**
     * cập nhật object items
     *
     * @param int $template_id
     * @param array $object_items
     * @return mixed
     */
    public function updateModelItemRefs(int $template_id, array $object_items = [])
    {
        $secret_keys = array_map(function($d){
            return $d['secret_key'];
        }, $object_items);

        $needUpdate = [];
        
        $refs = $this->itemRefRepository->get(['ref'=>'template', 'ref_id' => $template_id]);


        if(count($refs)){
            foreach ($refs as $i => $ref) {
                $d = is_array($ref->__data__) ? $ref->__data__: json_decode($ref->__data__, true);
                if(isset($d['secret_key']) || array_key_exists('secret_key', $d)){
                    if(in_array($d['secret_key'], $secret_keys)) $needUpdate[$d['secret_key']] = $ref;
                    else{
                        $ref->delete();
                    }
                }else{
                    $ref->delete();
                }
            }
        }
        $itemIds = [];
        foreach ($object_items as $key => $obj) {
            $item_id = $obj['data']['id'];
            $itemIds[] = $item_id;
        }
        $items = $this->itemRepository->mode('mask')->getData(['status' => 'published', 'id' =>$itemIds]);
        // die(json_encode($itemIds));
        $itemSettings = [];
        if(count($items)){
            foreach ($items as $key => $item) {
                $settings = [];
                $itemsetting = $item->settings;
                if(array_key_exists('meshes', $itemsetting) && count($itemsetting['meshes'])){
                    $meshes = [];
                    foreach ($itemsetting['meshes'] as $key => $mesh) {
                        if($mesh['editable'] || !(count($mesh['data']) == 1 && array_key_exists('__isObject__', $mesh['data']))){
                            $meshes[$mesh['name']] = $mesh;
                        }
                    }
                    // if(count($meshes)){
                        $settings['meshes'] = $meshes;
                    // }
                }else{
                    $settings['meshes'] = [];
                }
                if(array_key_exists('props', $itemsetting)){
                    $settings['props'] = $itemsetting['props'];
                }
                if(array_key_exists('options', $itemsetting)){
                    $settings['options'] = $itemsetting['options'];
                }
                $itemSettings[$item->id] = $settings;
            }
        }

        
        foreach ($object_items as $key => $obj) {
            $secret_key = $obj['secret_key'];
            $item_id = $obj['data']['id'];
            $settings = [];
            if(!array_key_exists($item_id, $itemSettings)) continue;
            if(array_key_exists('settings', $obj['data']) && is_array($obj['data']['settings'])){
                if(array_key_exists('props', $obj['data']['settings']) && is_array($obj['data']['settings']['props'])){
                    $settings['props'] = $obj['data']['settings']['props'];
                }
                if(array_key_exists('meshes', $obj['data']['settings']) && is_array($obj['data']['settings']['meshes'])){
                    $meshes = [];
                    $itemMeshes = $obj['data']['settings']['meshes'];
                    foreach ($itemMeshes as $j => $mesh) {
                        if(array_key_exists($mesh['name'], $itemSettings[$item_id]['meshes'])){
                            $m = ['name' => $mesh['name']];
                            if(array_key_exists('data', $mesh) && is_array($mesh['data'])){
                                $m['data'] = $mesh['data'];
                            }
                            $meshes[$j] = $m;
                        }
                        
                    }
                    $settings['meshes'] = $meshes;
                    $settings['options'] = $itemSettings[$item_id]['options']??[];
                }
            }
            if(isset($needUpdate[$secret_key]) || array_key_exists($secret_key, $needUpdate))
                $a = $this->itemRefRepository->updateItem($needUpdate[$secret_key]->id, $secret_key, $settings);
            else 
                $a = $this->itemRefRepository->addItem($item_id, 'template', $template_id, $secret_key, $settings);
            
            if(!$a) return false;
        }
        return true;
        
    }
}