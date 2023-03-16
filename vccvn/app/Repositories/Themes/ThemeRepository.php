<?php

namespace App\Repositories\Themes;

use App\Exceptions\NotReportException;
use App\Masks\Themes\ThemeMask;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Components\ComponentRepository;
use App\Repositories\Html\ComponentRepository as HtmlComponentRepository;
use App\Repositories\Html\AreaRepository;
use App\Repositories\Menus\ItemRepository;
use App\Repositories\Menus\MenuRepository;
use App\Repositories\Metadatas\MetadataRepository;
use App\Repositories\Options\DataRepository;
use App\Repositories\Options\GroupRepository;
use App\Repositories\Options\OptionRepository;
use App\Repositories\Web\SettingRepository;
use App\Transformers\ThemeTransformer;
use Crazy\Files\Filemanager;

class ThemeRepository extends BaseRepository
{


    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass
     */
    protected $validatorClass = 'Themes\ThemeValidator';


    /**
     * @var string $resource
     */
    protected $resourceClass = 'ThemeResource';

    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'ThemeCollection';



    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Themes\ThemeMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Themes\ThemeCollection';

    protected $responseMode = 'mask';

    /**
     * option repository
     *
     * @var OptionRepository
     */
    protected $optionRepository = null;


    /**
     * metadata
     *
     * @var MetadataRepository
     */
    protected $metadataReposirory = null;

    /**
     * menu
     *
     * @var MenuRepository
     */
    protected $menuRepository = null;

    /**
     * menu
     *
     * @var ItemRepository
     */
    protected $itemRepository = null;



    public $themeViewPath = null;


    public $perPage = 12;


    protected $defaultSortBy = [
        'id' => 'DESC'
    ];


    protected static $activeID = 0;

    protected static $theme = null;

    protected static $isChecked = false;


    protected $theme_active_list = [];

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Theme::class;
    }

    public function init()
    {
        $this->metadataReposirory = app(MetadataRepository::class);
        $this->menuRepository = app(MenuRepository::class);
        $this->itemRepository = app(ItemRepository::class);
    }
    /**
     * thiết lập active id
     *
     * @param int $id
     * @return void
     */
    public static function setActiveID($id)
    {
        self::$activeID = $id;
    }

    /**
     * kiểm tra theme active
     *
     * @param integer $id
     * @return void
     */
    public static function checkActiveTheme($id = 0)
    {

        if ($id || (!static::$isChecked && static::$activeID)) {
            $rep = (new static())->detailQuery();
            if ($theme = $rep->findBy('id', $id ? $id : (static::$activeID))) {
                $theme->applyMeta();
                static::$theme = new ThemeMask($theme);
            }
            static::$isChecked = true;
        }
    }

    /**
     * lay thong tin theme dc kich hoat
     *
     * @return \App\Masks\ThemeMask
     */
    public static function getActiveTheme()
    {
        static::checkActiveTheme();
        return static::$theme;
    }


    /**
     * lay thong tin theme dc kich hoat
     *
     * @return \App\Masks\ThemeMask
     */
    public function getCurrentTheme()
    {
        static::checkActiveTheme();
        return static::$theme;
    }

    /**
     * thiet lap theme id
     *
     * @param int $id
     * @return void
     */
    public function setThemeID($id)
    {
        self::$activeID = $id;
    }

    /**
     * lay option repository
     * @return OptionRepository
     */
    public function getOptionRepository()
    {
        if (!$this->optionRepository) {
            $this->optionRepository = app(OptionRepository::class);
        }
        return $this->optionRepository;
    }

    /**
     * thao tac voi du lieu truoc khi tao moi
     * @param array $data
     * @return array $data
     */
    public function beforeCreate(array $data = [])
    {
        $data['secret_id'] = uniqid();
        return $data;
    }


    public function beforeSave($data)
    {
        if (isset($data['web_types']) && is_array($data['web_types'])) {
            $data['web_types'] = implode(', ', $data['web_types']);
        }
        return $data;
    }

    /**
     * kích hoạt query tìm kiếm
     *
     * @return ThemeRepository
     */
    public function activeSearchMode()
    {
        $this->resetDefaultParams('owner');
        return $this->where(function ($query) {
            $query->where('privacy', 'public')->orWhere('owner_id', $this->getOwnerID());
        })->where('available', 1);
    }

    /**
     * kích hoạt query tìm kiếm
     *
     * @return ThemeRepository
     */
    public function activePublishMode()
    {
        $this->resetDefaultParams('owner');
        return $this->where(function ($query) {
            $query->whereIn('privacy', ['public', 'publish']);
        })->where('available', 1);
    }

    /**
     * kích hoạt query tìm kiếm
     *
     * @return ThemeRepository
     */
    public function detailQuery()
    {
        return $this->activeSearchMode();
    }



    /**
     * lấy slug không dụng hàng
     *
     * @param string $str
     * @param int $id
     * @param string $append
     * @return string
     */
    public function slug($str = null, $id = null, $append = null)
    {
        if (!$str && !$id = null) return null;
        if (!$str) return null;
        $aslug = str_slug($str, '-');
        $slug = null;
        $c = '';
        $s = true;
        $args = [];
        $i = 0;
        do {
            $sl = $aslug . $c;
            $args['slug'] = $sl;

            if ($pf = $this->first($args)) {
                if ($id && $pf->id == $id) {
                    $slug = $sl;
                    $s = false;
                    break;
                }
                if ($i == 1 && $append) {
                    $c = '-' . $append;
                } else {
                    $c = '-' . uniqid();
                }
            } else {
                $slug = $sl;
                $s = false;
                break;
            }
            $i++;
        } while ($s);
        return $slug;
    }

    /**
     * tạo metadata để update cho nhanh
     *
     * @param int $id
     * @return void
     */
    public function createMetaData($id)
    {
        if (!($theme = $this->findBy('id', $id))) return false;
        $filemanager = new Filemanager();
        $metadatas = $this->metadataReposirory;
        $componentRepository = new ComponentRepository();
        $this->themeViewPath = resource_path('views/clients/'.$theme->secret_id);
        $theme_path = 'themes/containers/' . $theme->slug;
        // duong dan thu muc
        $config = base_path($theme_path . '/config');

        $modules = $config . '/modules';
        $settings = $config . '/settings';
        $components = [];
        $options = [];
        $areas = [];
        $layout = [];

        $menus = [];

        $package = [];

        if ($cp = $filemanager->getJson($config . '/components')) $components = array_merge($components, $cp);
        // if ($op = $filemanager->getJson($config . '/options')) $options = array_merge($options, $op);
        if ($ar = $filemanager->getJson($config . '/areas')) $areas = array_merge($areas, $ar);
        if ($mn = $filemanager->getJson($config . '/menus')) $menus = array_merge($menus, $mn);
        if ($l = $filemanager->getJson($config . '/layout')) $layout = array_merge($layout, $l);
        if ($i = $filemanager->getJson($config . '/icons')) $package['icons'] = $i;
        if ($packageJson = $filemanager->getJson($config . '/package')) $package = array_merge($package, $packageJson);
        
        if (is_dir($config . '/components')) $components = array_merge($components, $this->getJsonComponents($filemanager, $config . '/components'));

        if (is_dir($cPath = base_path($theme_path . '/components'))) {
            $components = $this->getComponentsInFolder($cPath, '', $components);
        }

        if($groups = $this->getJsonOptions($filemanager, $config . '/options')){
            if(!isset($options['title'])) $options['title'] = $theme->name;
            if(!isset($options['groups']) || !is_array($options['groups'])) $options['groups'] = [];
            $options['groups'] = array_merge($options['groups'], $groups);

        }

        $rs = $componentRepository->createListWithOwnerID($theme->owner_id, 'blade', 'theme', $theme->id, $components, true);
        $filemanager->setDir($settings);

        if ($optionJson = $filemanager->getJson('options')) $options = array_merge($options, $optionJson);
        if ($areaJson = $filemanager->getJson('areas')) $areas = array_merge($areas, $areaJson);
        if ($layoutJson = $filemanager->getJson('layout')) $layout = array_merge($layout, $layoutJson);
        if ($menuJson = $filemanager->getJson('menus')) $menus = array_merge($menus, $menuJson);
        if ($packageJson = $filemanager->getJson('package')) $package = array_merge($package, $packageJson);
        $data = compact('components', 'options', 'areas', 'layout', 'menus', 'package');
        $metadatas->saveMany('theme', $theme->id, $data, false);
    }



    /**
     * lấy component tu folder
     *
     * @param string $path đường đẫn tới thư mục chứa component
     * @param string $sub đường dẫn tính từ thư mục component
     * @param array $components danh sach component
     * @return array
     */
    public function getComponentsInFolder($path, $sub = '', $components = [])
    {
        if(is_string($path) && is_dir($path) && ($filemanager = new Filemanager($path)) && count($list = $filemanager->getList())){
            $componentPath = $this->themeViewPath . '/components';
            $d = ($sub ? trim($sub, '/') . '/':'');

            foreach ($list as $index => $file) {
                if($file->type == 'folder'){
                    $components = $this->scanComponentFolder($file, $sub, $components);
                }elseif($file->extension == 'php'){
                    $name = str_replace('.blade.php', '', $file->name);
                    if($name != $file->name){
                        $json = [];
                        if(file_exists($js = $path . '/'.$name.'.json')){
                            $json = json_decode(file_get_contents($js), true);
                        }
                        if(!$json) $json = [];

                        $bp = $d.'.'.$name;
                        $json['path'] = $bp;
                        if(!isset($json['name'])) $json['name'] = str_replace('.', ' : ', $bp);
                        $components[$bp] = $json;
                    }
                }
            }
        }
        return $components;
    }

    /**
     * Quét thư mục
     *
     * @param Arr $folder
     * @param string $sub
     * @param array $components
     * @return array
     */
    public function scanComponentFolder($folder, $sub = '', $components = [])
    {

        $filemanager = new Filemanager($folder->path);
        $d = ($sub ? trim($sub, '/') . '/':'') . $folder->name;
        $cp = $this->themeViewPath . '/components/';
        if(file_exists($blade = $folder->path . '/view.blade.php')){
            $p = $d . '.blade.php';
            $cPath = $cp . $p;
            $filemanager->copyFile($blade, $cPath);
            $n = str_replace('/', '.', $d);
            $json = [];
            if(file_exists($js = $folder->path . '/config.json')){
                $json = json_decode(file_get_contents($js), true);
            }
            if(!$json) $json = [];

            $json['path'] = $n;
            if(!isset($json['name'])) $json['name'] = str_replace('.', ' : ', $n);
            $components[$n] = $json;
        }
        $filemanager->setDir($folder->path);
        if(count($list = $filemanager->getList())){
            foreach ($list as $index => $file) {
                if($file->type == 'folder'){
                    $components = $this->scanComponentFolder($file, $d, $components);
                }elseif($file->extension == 'php'){
                    $name = str_replace('.blade.php', '', $file->name);
                    if($name != $file->name && $name!='view'){
                        $json = [];
                        if(file_exists($js = $folder->path . '/'.$name.'.json')){
                            $json = json_decode(file_get_contents($js), true);
                        }
                        if(!$json) $json = [];

                        $bp = $d.'.'.$name;
                        $json['path'] = $bp;
                        if(!isset($json['name'])) $json['name'] = str_replace('.', ' : ', $bp);
                        $components[$bp] = $json;
                    }
                }
            }
        }
        return $components;
    }
    /**
     * get json component
     *
     * @param Filemanager $filemanager
     * @param string $dir
     * @param string $root
     * @param array $list
     * @return array
     */
    public function getJsonComponents($filemanager, $dir, $sub = '', $list = [])
    {
        if ($cpns = $filemanager->getList($dir)) {
            foreach ($cpns as $item) {
                if ($item->type == 'file' && $item->extension == 'json') {
                    if ($data = $filemanager->json($item->path)) {
                        if (!isset($data['path'])) {
                            $s = trim($sub, '.');
                            $names = explode('.', $item->name);
                            $a = array_pop($names);
                            $p = ($s ? $s . '.' : '') . implode('.', $names);
                            $data = ['path' => $p] + $data;
                        }

                        $list[] = $data;
                    }
                } elseif ($item->type == 'folder') {
                    $list = $this->getJsonComponents($filemanager, $item->path, $sub ? $sub . '.' : '', $list);
                }
            }
        }
        return $list;
    }




    /**
     * get json options
     *
     * @param Filemanager $filemanager
     * @param string $dir
     * @return array
     */
    public function getJsonOptions($filemanager, $dir, $list = [])
    {
        $options = $filemanager->getJson($dir);

        $groups = [];
        if($options){
            if(isset($options['groups'])){
                foreach ($options['groups'] as $key => $group) {
                    if(isset($group['inputs'])){
                        $groups[$key] = $group;
                    }
                    elseif (isset($group['file'])) {
                        if($g = $filemanager->getJson($dir.'/'. $group['file'])){
                            unset($group['file']);
                            $groups[$key] = array_merge($group, $g);
                        }
                    }
                }
            }
        }
        $options['groups'] = $groups;
        return $groups;
    }






    /**
     * kích hoạt theme
     *
     * @param integer $id
     * @return bool
     */
    public function active(int $id)
    {
        $theme = $this->detailQuery()->findBy('id', $id);
        if (!$theme) return false;
        $theme->applyMeta();
        if (app(SettingRepository::class)->activeTheme($theme->id)) {
            $this->firstSetup($theme);
            return true;
        }
        return false;
    }

    /**
     * kích hoạt theme
     *
     * @param integer $owner_id
     * @param integer $id
     * @return bool
     */
    public function activeDefault(int $owner_id)
    {
        $theme = $this->detailQuery()->like('web_types', 'default')->first();
        if (!$theme) return false;
        $theme->applyMeta();
        
        if (app(SettingRepository::class)->saveOwnerSetting($owner_id, ['theme_id'=>$theme->id])) {
            $this->firstSetup($theme);
            return true;
        }
        return false;
    }

    /**
     * kiểm tra thêm đạ được cài đặt trước đó hay chưa
     *
     * @param int $theme_id
     * @return bool
     */
    public function checkThemeActiveList($theme_id)
    {
        if($owner_id = $this->getOwnerID()){
            $this->metadataReposirory->setOwnerID($owner_id);
        }
        if ($listStr = $this->metadataReposirory->getMetaMeta('data', 0, 'theme_active_list')) {
            try {
                $this->theme_active_list = is_array($listStr)?$listStr:json_decode($listStr, true);
            } catch (NotReportException $th) {
                $this->theme_active_list = [];
            }
            
            return in_array($theme_id, $this->theme_active_list);
        }
        return false;
    }

    public function addThemeActiveToList($theme_id)
    {
        $a = $this->theme_active_list;

        if (!in_array($theme_id, $a)) {
            $a[] = $theme_id;
            $this->metadataReposirory->saveOne('data', 0, 'theme_active_list', $a);
        }else{
            // $this->metadataReposirory->saveOne('data', 0, 'theme_active_list', [$theme_id]);
        }
    }
    /**
     * cai dat cac file he thong
     *
     * @param \App\Models\Theme $theme
     * @return boolean
     */
    public function firstSetup($theme)
    {
        // khai báo các repository
        $optionRepository = $this->getOptionRepository();
        $groupRepository = new GroupRepository();
        $dataRepository = new DataRepository();
        $areaRepository = new AreaRepository();
        $componentRepository = new ComponentRepository();
        $htmlComponents = new HtmlComponentRepository();

        $isActiveBefore = $this->checkThemeActiveList($theme->id);
        //die(json_encode(['p' => $isActiveBefore]));
        $componentRepository->resetDefaultParams();
        // theme option
        if ($theme->options) {
            $optionData = $theme->options;
            // du lieu option
            $option = $optionRepository->createDataIfNotExists([
                'title' => $optionData['title'] ?? "Theme Options",
                'slug' => str_slug($theme->slug),
                'ref' => 'theme',
                'ref_id' => $theme->id
            ]);
            if ($option) {
                // cac group
                if (isset($optionData['groups']) && is_array($optionData['groups'])) {
                    foreach ($optionData['groups'] as $slug => $groupData) {
                        $group = $groupRepository->createOrUpdate([
                            'slug' => str_slug($slug, '_'),
                            'label' => $groupData['label'] ?? 'Group Label',
                            'option_id' => $option->id,
                            'config' => isset($groupData['config'])?$groupData['config']:[]
                        ]);
                        if ($group) {
                            //tao input theo group
                            if (isset($groupData['inputs']) && is_array($groupData['inputs'])) {
                                $dataRepository->createListData($group->id, $groupData['inputs']);
                            }
                        }
                    }
                }
            }
        }
        // tạo các areal của theme
        if ($theme->areas) {
            $areaCreated = $areaRepository->createAreaList($theme->areas, 'theme', $theme->id);
        }

        if ($theme->layout) {
            // thiết lập các thành phần trên giao diện
            $layout = $theme->layout;
            $areaSlugs = array_keys($theme->layout);

            // danh sach area
            $areas = $areaRepository->where(function ($query) use ($theme) {
                $query->where('html_areas.ref_id', '<', 1)->orWhere(function ($query) use ($theme) {
                    $query->where('html_areas.ref', 'theme')->where('html_areas.ref_id', $theme->id);
                });
            })->getBy('slug', $areaSlugs);
            // nếu có area
            if (count($areas)) {
                foreach ($areas as $area) {
                    if (isset($layout[$area->slug]) && is_array($layout[$area->slug])) {
                        // component của một area
                        $coms = $layout[$area->slug];
                        $comPaths = [];
                        $comData = [];

                        foreach ($coms as $key => $com) {
                            // duyệt xem mỗi componnent có chứa data hay không
                            $path = null;
                            $cd = $com;
                            $mayData = true;
                            $d = [];
                            // nếu là  1 mảng sẽ kiểm tra tính hợp lệ của component
                            if (is_array($com)) {
                                if (is_numeric($key)) {
                                    $mayData = false;
                                    if (isset($cd['path'])) {
                                        $path = $cd['path'];
                                        unset($cd['path']);
                                    } elseif (isset($cd['component'])) {
                                        $path = $cd['component'];
                                        unset($cd['component']);
                                    }
                                    if (isset($cd['data'])) {
                                        $d = $cd['data'];
                                        unset($cd['data']);
                                    }
                                } else {
                                    $path = $key;
                                    $d = $cd;
                                }
                            }
                            // nếu commponent không phải một mảng và key là số thì path chính bằng com
                            elseif (is_numeric($key)) {
                                $path = $cd;
                            }
                            // khác. nghĩa là com không phải mảng và key là một chuỗi
                            else {
                                $path = $key;
                                $d = ['data' => $cd];
                            }
                            if ($mayData) {
                                $d = $cd;
                            }
                            if ($path) {
                                $comPaths[] = $path;
                                $comData[$key] = [
                                    'path' => $path,
                                    'data' => $d
                                ];
                            }
                        }
                        $components = $componentRepository->where(function ($query) use ($theme) {
                            $query->where('components.ref_id', '<', 1)->orWhere(function ($query) use ($theme) {
                                $query->where('components.ref', 'theme')->where('components.ref_id', $theme->id);
                            });
                        })->getBy('path', $comPaths);
                        // tim component theo path và theo ref
                        if (count($components)) {
                            $cps = [];
                            foreach ($components as $i => $component) {
                                if ($component->path) {
                                    $cps[$component->path] = $component;
                                }
                            }
                            foreach ($comData as $key => $comp) {
                                if (isset($cps[$comp['path']])) {
                                    $component = $cps[$comp['path']];
                                    $data = [
                                        'component_id' => $component->id,
                                        'area_id' => $area->id,
                                        'data' => $comp['data'] ? $comp['data'] : $component->data
                                    ];
                                    if (!$isActiveBefore) {
                                        $htmlComponents->firstCreate($data);
                                    } else {
                                        $htmlComponents->createDataIfNotExists($data);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if($theme->menus){
            $this->makeThemeMenusIfNotexists($theme);
        }
        $this->addThemeActiveToList($theme->id);
    }



    /**
     * tạo menu theo thene
     *
     * @param \App\Models\Theme $theme
     * @return void
     */
    public function makeThemeMenusIfNotexists($theme)
    {
        $menus = $theme->menus;
        if($menus && is_array($menus) && isset($menus['menus'])){

            foreach($menus['menus'] as $slug => $menu){
                if(is_array($menu)){
                    if(!isset($menu['name']) || !$menu['name']) continue;
                    if(!isset($menu['slug']) && is_string($slug)){
                        $menu['slug'] = $slug;
                    }
                    if(!isset($menu['slug'])){
                        $menu['slug'] = str_slug($menu['name']);
                    }
                    if(!$this->menuRepository->first(['type' => 'theme', 'ref_id' => $theme->id, 'slug' => $menu['slug']])){

                        $items = isset($menu['items']) && is_array($menu['items'])?$menu['items']:[];
                        unset($menu['items']);
                        $menu['type'] = 'theme';
                        $menu['ref_id'] = $theme->id;

                        if($m = $this->menuRepository->create($menu)){
                            $menuItems = $this->itemRepository->createItems($items, $m->id, 0);
                        }
                    }
                }
            }
        }
    }

    /**
     * lấy thông tin input và data
     * @param string $group_slug
     * @param array $args
     * @return array
     */
    public function getOptionItems($group_slug, array $args = [])
    {
        if (!($theme = get_active_theme())) return [];
        $optionRepository = $this->getOptionRepository();
        return $optionRepository->getOptionItems(
            array_merge($args, [
                'option' => $theme->slug,
                'ref' => 'theme',
                'ref_id' => $theme->id,
                'group' => $group_slug
            ])
        );
    }

    /**
     * get theme option data
     *
     * @param int $theme_id
     * @return array
     */
    public function getOptionGroupData($theme_id)
    {
        // lấy thông tin options
        $option = $this->getOptionRepository()->getOptionGroupData(['ref' => 'theme', 'ref_id' => $theme_id]);
        if ($option) {
            $optionGroups = [];
            if ($option->groups) {
                foreach ($option->groups as $i => $g) {
                    $config = $g->config ? (is_array($g->config) ? $g->config : json_encode($g->config, true)) : [];
                    $gdata = [
                        'slug' => $g->slug,
                        'label' => $g->label,
                        'id' => $g->id,
                        'inputs' => [],
                        'data' => [],
                        'config' => $config
                    ];
                    if ($g->datas) {
                        $inputs = [];
                        $data = [];
                        foreach ($g->datas as $d) {
                            $v = $d->value;
                            if ($d->type == 'checklist') {
                                $v = json_decode($v, true);
                            }
                            $props = $d->props;

                            $data[$d->name] = $v;
                            $dd = $d->toFormData();
                            unset($dd['props']);
                            $dd = array_merge($dd, $props);
                            $dd['id'] = $g->slug . '-' . $d->name;
                            unset($dd['value']);
                            $inputs[$d->name] = $dd;
                        }
                        $gdata['inputs'] = $inputs;
                        $gdata['data'] = $data;
                    }
                    $optionGroups[$g->slug] = $gdata;
                }
            }
            return $optionGroups;
        }
        return [];
    }

    /**
     * lưu option data
     * @param string $group_slug
     * @param array $data
     * @param array $args
     * @return array
     */
    public function updateOptionData(string $group_slug, array $data = [], array $args = [])
    {
        if (!($theme = get_active_theme())) return [];
        $optionRepository = $this->getOptionRepository();
        return $optionRepository->updateOptionData(
            array_merge($args, [
                'option' => $theme->slug,
                'ref' => 'theme',
                'ref_id' => $theme->id,
                'group' => $group_slug
            ]),
            $data
        );
    }
}
