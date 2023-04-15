<?php

namespace App\Repositories\Dynamics;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Metadatas\MetadataRepository;
use Crazy\Helpers\Arr;

class DynamicRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Dynamics\DynamicValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\DynamicResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\DynamicCollection';

    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Dynamics\DynamicMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Dynamics\DynamicCollection';

    /**
     * @var string $system
     */
    protected $system = 'both';

    /**
     * @var App\Repositories\Metadatas\MetadataRepository $metadataRepository
     */
    public $metadataRepository;



    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Dynamic::class;
    }

    /**
     * thiết lập
     * @return void
     */
    public function init()
    {
        $this->metadataRepository = new MetadataRepository();
        $this->setJoinable([
            ['leftJoin', 'posts', 'posts.dynamic_id', '=', 'dynamics.id']
        ])->setGroupBy('dynamics.id')->setSelectRaw(['count(posts.id) as post_count'])->setSelectable(['dynamics.*']);
    }

    /**
     * save inputs
     */
    public function saveFormInfo($id, array $formInfo = [])
    {
        $model = $this->find($id);
        $form = new Arr($formInfo);
        // giá trị mac dinh
        $defaultMetadatas = [
            'default_fields' => [],
            'advance_props' => [],
            'custom_slug'    => false,
        ];
        $data = [];
        // lay thuoc tinh tu request
        foreach ($defaultMetadatas as $key => $value) {
            $data[$key] = $form->{$key} ?? $value;
        }


        $dff = $data['default_fields'];
        $add = [];
        $newDff = [];

        if ($model->post_type == 'custom') {
            $add = ['gallery', 'video_url', 'source'];
        } elseif ($model->post_type == 'gallery' || $model->use_gallery) {
            $add[] = 'gallery';
        } elseif (in_array($model->post_type, ['news'])) {
            $add[] = 'source';
        } elseif ($model->post_type == 'video_embed') {
            $add[] = 'video_url';
        }

        
        $after = in_array('content', $dff) ? 'content' : (in_array('description', $dff) ? 'description' : (in_array('slug', $dff) ? 'slug' : (in_array('title', $dff) ? 'title' : null)));
        
        if ($add) {
            foreach ($dff as $key) {
                $newDff[] = $key;
                if ($key == $after) {
                    $newDff = array_merge($newDff, $add);
                }
            }
            $data['default_fields'] = $newDff;
        }



        $data['prop_inputs'] = $this->parseInputs($form);
        if (!$form->id) {
            $formConfig = [
                'name' => 'Thông tin ' . $model->name,
                'layout_type' => 'column',
                'form_groups' => [
                    [
                        'title' => 'Thông tin cơ bản',
                        'class' => 'col-12 col-lg-7',
                        'inputs' => [
                            'title', 'slug', 'category_id', 'description'
                        ]
                    ],
                    [
                        'title' => 'Ảnh và riêng tư',
                        'class' => 'col-12 col-lg-5',
                        'inputs' => [
                            'feature_image'
                        ]
                    ],
                    [
                        'title' => 'Thông tin chi tiết',
                        'class' => 'col-12',
                        'inputs' => [
                            'content', 'content_type', 'video_url', 'gallery', 'source'
                        ]
                    ],
                    [
                        'title' => 'Thông tin SEO',
                        'class' => 'col-12 col-lg-6',
                        'inputs' => [
                            'meta_title', 'meta_description', 'keywords'
                        ]
                    ],
                    [
                        'title' => '',
                        'class' => 'col-12 col-lg-6',
                        'inputs' => [
                            'tags', 'privacy'
                        ]
                    ]

                ]
            ];

            if ($data['prop_inputs']) {
                $formConfig['form_groups'][] = [
                    'title' => 'Thuộc tính',
                    'class' => 'col-12',
                    'inputs' => array_keys($data['prop_inputs'])
                ];
            }
            $data['form_config'] = $formConfig;
        }
        $this->metadataRepository->saveMany('dynamic', $model->id, $data);
    }


    /**
     * lấy tất cả các input  nâng cao
     * @param Request $request
     * @return array
     */
    public function parseInputs($request)
    {
        $data = [];
        // thông tien do nguoi dung them vào
        $props = $request->advance_props;
        if (is_array($props)) {
            foreach ($props as $input) {
                $item = [
                    'name' => $input['name'],
                    'type' => $input['type'],
                    'label' => $input['label'] ?? '',
                    'validate' => $input['validate'],
                ];
                if (array_key_exists('prop_list', $input)) {
                    if (!is_array($input['prop_list'])) $propList = json_decode($input['prop_list'], true);
                    else $propList = $input['prop_list'];
                    if ($propList) {
                        foreach ($propList as $p) {
                            if (array_key_exists('key', $p) && $p['key'] && !array_key_exists($p['key'], $item)) {
                                $vl = $p['value'] ?? null;
                                $item[$p['key']] = $vl;
                            }
                        }
                    }
                }


                $data[$input['name']] = $item;
            }
        }

        return $data;
    }


    /**
     * cập nhật meta data json
     * @param int $id
     * @param string $columnName
     * @param string|array $jsonKey
     * @param mixed $value
     * 
     * @return bool|result
     */
    public function updateMetadataJson($id, string $columnName, $jsonKey, $value = null)
    {
        if (!($dynamic = $this->find($id))) return false;
        if (!$dynamic->isJson($columnName)) return false;
        $dynamic->applyMeta();
        $data = $dynamic->{$columnName} ?? [];
        if (is_array($jsonKey)) {
            foreach ($jsonKey as $key => $value) {
                $data[$key] = $value;
            }
            // $array = array_merge($array, $jsonKey);
        } else {
            $data[$jsonKey] = $value;
        }
        return $this->metadataRepository->saveOne('dynamic', $dynamic->id, $columnName, $data);
    }


    // lấy thong tin option
    public static function getSelectOptions($args = [], $firstDefault = null)
    {
        return (new static())->getDataOptions($args, $firstDefault);
    }

    /**
     * lấy thông tin dynamic và apply meta
     * @param int $id
     * @return App\Models\Dynamic|null
     */
    public function dynamic($id)
    {
        if ($dynamic = $this->first(['id' => $id])) {
            $dynamic->applyMeta();
            return $dynamic;
        }
        return null;
    }
}
