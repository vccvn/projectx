<?php

namespace App\Repositories\Options;

use Illuminate\Support\Str;
use Crazy\Helpers\Arr;
use Crazy\Files\Filemanager;

class SettingRepository extends OptionRepository
{
    protected $validatorClass = 'App\Validators\Options\SettingValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'SettingResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'SettingCollection';

    
    /**
     * tao moi setting
     */
    public function createNewData()
    {
        $this->activeDataGroup();
        $this->filemanager = new Filemanager(base_path('json/data/web'));
        

        $data = [
            'title' => 'Thiết lập',
            'slug' => 'settings'
        ];

        $this->createIfNotExists($data, function($option) {
            $this->groupRepository->createIfNotExists([
                'slug' => 'system',
                'label' => 'Cài đặt hệ thống',
                'option_id' => $option->id
            ], function($group){
                if($system = $this->filemanager->json('system')){
                    $this->dataRepository->createListData($group->id, $system['data'], false);
                }
            });
            $this->groupRepository->createIfNotExists([
                'slug' => 'websettings',
                'label' => 'Web Setting',
                'option_id' => $option->id
            ], function($group){
                if($system = $this->filemanager->json('web')){
                    $this->dataRepository->createListData($group->id, $system['data'], false);
                }
            });
            $this->groupRepository->createIfNotExists([
                'slug' => 'mailer',
                'label' => 'Thiết lập Email',
                'option_id' => $option->id
            ], function($group){
                if($siteinfo = $this->filemanager->json('mailer')){
                    $this->dataRepository->createListData($group->id, $siteinfo['data'], false);
                }
            });
            $this->groupRepository->createIfNotExists([
                'slug' => 'siteinfo',
                'label' => 'Thông tin website',
                'option_id' => $option->id
            ], function($group){
                if($siteinfo = $this->filemanager->json('siteinfo')){
                    $this->dataRepository->createListData($group->id, $siteinfo['data'], false);
                }
            });

            $this->groupRepository->createIfNotExists([
                'slug' => 'posts',
                'label' => 'Thiết lập tin bài',
                'option_id' => $option->id
            ], function($group){
                if($siteinfo = $this->filemanager->json('posts')){
                    $this->dataRepository->createListData($group->id, $siteinfo['data'], false);
                }
            });
            $this->groupRepository->createIfNotExists([
                'slug' => 'products',
                'label' => 'Thiết lập trang Sản phẩm',
                'option_id' => $option->id
            ], function($group){
                if($siteinfo = $this->filemanager->json('products')){
                    $this->dataRepository->createListData($group->id, $siteinfo['data'], false);
                }
            });
            
            $this->groupRepository->createIfNotExists([
                'slug' => 'projects',
                'label' => 'Thiết lập trang Dự án',
                'option_id' => $option->id
            ], function($group){
                if($siteinfo = $this->filemanager->json('projects')){
                    $this->dataRepository->createListData($group->id, $siteinfo['data'], false);
                }
            });

            $this->groupRepository->createIfNotExists([
                'slug' => 'ecommerce',
                'label' => 'Thiết lập cửa hàng',
                'option_id' => $option->id
            ], function($group){
                if($siteinfo = $this->filemanager->json('ecommerce')){
                    $this->dataRepository->createListData($group->id, $siteinfo['data'], false);
                }
            });
            $this->groupRepository->createIfNotExists([
                'slug' => 'payments',
                'label' => 'Thiết lập thanh toán',
                'option_id' => $option->id
            ], function($group){
                if($siteinfo = $this->filemanager->json('payments')){
                    $this->dataRepository->createListData($group->id, $siteinfo['data'], false);
                }
            });

            $this->groupRepository->createIfNotExists([
                'slug' => 'jssdk',
                'label' => 'Javascript SDK',
                'option_id' => $option->id
            ], function($group){
                if($siteinfo = $this->filemanager->json('jssdk')){
                    $this->dataRepository->createListData($group->id, $siteinfo['data'], false);
                }
            });
        });
    }


    
    /**
     * lấy thông tin input và data
     * @param string $group_slug
     * 
     * @return array
     */
    public function getSettingFormData(string $group_slug)
    {
        return $this->getOptionFormData([
            'option' => 'settings',
            'ref_id' => 0,
            'group' => $group_slug
        ]);
    }

    
    /**
     * lấy thông tin input và data
     * @param string $group_slug
     * @param array $args
     * @return array
     */
    public function getSettingItems(string $group_slug, array $args = [])
    {
        return $this->getOptionItems(array_merge($args, [
            'option' => 'settings',
            'ref_id' => 0,
            'group' => $group_slug
        ]));
        
    }

    
    /**
     * lấy thông tin input và data
     * @param string $group_slug
     * @param string $name
     * @return array
     */
    public function getSettingItem(string $group_slug, string $name)
    {
        return $this->getOptionItem([
            'option' => 'settings',
            'ref_id' => 0,
            'group' => $group_slug,
            'name' => $name
        ]);
        
    }

    /**
     * lấy thông tin input và data
     * @param string $group_slug
     * @param array $data
     * @param array $args
     * @return array
     */
    public function updateSettingData(string $group_slug, array $data = [], array $args = [])
    {
        return $this->updateOptionData(array_merge($args, [
            'option' => 'settings',
            'ref_id' => 0,
            'group' => $group_slug
        ]), $data);
    }

    
    /**
     * lấy thông tin input và data
     * @param string $group_slug
     * @param array $args
     * @return array
     */
    public function getSettingGroup(string $group_slug, array $args = [])
    {
        return $this->getOptionGroup(array_merge($args, [
            'option' => 'settings',
            'ref_id' => 0,
            'group' => $group_slug
        ]));
        
    }

}