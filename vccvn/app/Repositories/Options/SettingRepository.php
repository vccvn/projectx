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
     * @param int $owner_id
     */
    public function createNewData(int $owner_id)
    {
        $this->activeDataGroup();
        $this->filemanager = new Filemanager(base_path('json/data/web'));


        $data = [
            'title' => 'Thiết lập',
            'slug' => 'settings',
            'owner_id' => $owner_id
        ];

        $this->createDataIfNotExists($data, function($option) use($owner_id) {
            $this->groupRepository->createDataIfNotExists([
                'slug' => 'system',
                'label' => 'Cài đặt hệ thống',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($system = $this->filemanager->json('system')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $system['data'], false);
                }
            });
            $this->groupRepository->createDataIfNotExists([
                'slug' => 'mailer',
                'label' => 'Thiết lập Email',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('mailer')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });
            $this->groupRepository->createDataIfNotExists([
                'slug' => 'siteinfo',
                'label' => 'Thông tin website',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('siteinfo')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });

            $this->groupRepository->createDataIfNotExists([
                'slug' => 'display',
                'label' => 'Thiết lập hiển thị',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('display')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });

            $this->groupRepository->createDataIfNotExists([
                'slug' => 'default',
                'label' => 'Thông số mặc định',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('default')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });
            $this->groupRepository->createDataIfNotExists([
                'slug' => 'posts',
                'label' => 'Thiết lập tin bài',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('posts')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });
            $this->groupRepository->createDataIfNotExists([
                'slug' => 'products',
                'label' => 'Thiết lập trang Sản phẩm',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('products')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });

            $this->groupRepository->createDataIfNotExists([
                'slug' => 'projects',
                'label' => 'Thiết lập trang Dự án',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('projects')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });

            $this->groupRepository->createDataIfNotExists([
                'slug' => 'ecommerce',
                'label' => 'Thiết lập cửa hàng',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('ecommerce')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });
            $this->groupRepository->createDataIfNotExists([
                'slug' => 'payments',
                'label' => 'Thiết lập thanh toán',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('payments')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });

            $this->groupRepository->createDataIfNotExists([
                'slug' => 'jssdk',
                'label' => 'Javascript SDK',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('jssdk')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });
            $this->groupRepository->createDataIfNotExists([
                'slug' => 'favicons',
                'label' => 'Biểu tượng Website',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('favicons')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });
            $this->groupRepository->createDataIfNotExists([
                'slug' => 'pwa',
                'label' => 'Thiết lập PWA',
                'option_id' => $option->id,
                'owner_id' => $owner_id
            ], function($group) use($owner_id){
                if($siteinfo = $this->filemanager->json('pwa')){
                    $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $siteinfo['data'], false);
                }
            });


        });

        $urlOptions = [
            'title' => 'Thiết lập URL',
            'slug' => 'urlsettings', 
            'owner_id' => $owner_id
        ];
        
        $this->createDataIfNotExists($urlOptions, function($option) use($owner_id){
            $groups = $this->filemanager->json('urls');
            if($groups){
                foreach ($groups as $key => $g) {
                    $this->groupRepository->createDataIfNotExists([
                        'slug' => $key,
                        'label' => $g['title'],
                        'option_id' => $option->id,
                        'owner_id' => $owner_id
                    ], function($group) use($owner_id, $g){
                        if($g['inputs']){
                            $this->dataRepository->createListWithOwnerID($owner_id, $group->id, $g['inputs'], false);
                        }
                    });
                }
            }

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
