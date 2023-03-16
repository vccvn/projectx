<?php

namespace App\Repositories\Users;

use AB0;
use App\Engines\DCryptEngine;
use App\Http\Controllers\Apis\Admin\AccountController;
use App\Models\User;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Options\SettingRepository as OptionSetting;
use App\Repositories\Html\AreaRepository;
use App\Repositories\Metadatas\MetadataRepository;
use App\Repositories\Themes\ThemeRepository;
use App\Repositories\Web\SettingRepository;
use App\Repositories\Profiles\ProfileRepository;
use App\Repositories\Web\DataRepository;
use App\Repositories\Options\OptionRepository;
use Crazy\Apis\Api;
use Crazy\Database\MyAdmin;
use Illuminate\Support\Facades\Config;

class BranchRepository extends BaseUserRepository
{

    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Users\BranchValidator';

    protected $columns = [
        'id' => 'users.id',
        'name' => 'users.name',
        'email' => 'users.email',
        'username' => 'users.username',
        'phone_number' => 'users.phone_number',
        'type' => 'users.type',
        'status' => 'users.status',
        'deleted' => 'users.deleted',
        'user_owner_id' => 'users.owner_id',
        'master_id' => 'users.master_id',

        'first_name' => 'profiles.first_name',
        'last_name' => 'profiles.last_name',
        'gender' => 'profiles.gender',
        'birthday' => 'profiles.birthday',
        'address' => 'profiles.address',
        'academic_id' => 'profiles.academic_id',
        'work_id' => 'profiles.work_id',
        'org_id' => 'profiles.org_id',

        'theme_id' => 'web_settings.theme_id',
        'web_type' => 'web_settings.web_type',
        'base_domain' => 'web_settings.base_domain',
        'subdomain' => 'web_settings.subdomain',
        'account_type' => 'web_settings.account_type',
        'expired_at' => 'web_settings.expired_at',
        'alias_domain' => 'web_settings.alias_domain',

    ];


    /**
     * profile
     *
     * @var ProfileRepository
     */
    public $profiles = null;
    /**
     * websetting
     *
     * @var SettingRepository
     */
    public $webSettings = null;
    /**
     * option
     *
     * @var OptionSetting
     */
    public $optionSetting = null;
    /**
     * html
     *
     * @var AreaRepository
     */
    public $htmlAreaRepository = null;
    /**
     * dynamic
     *
     * @var DynamicRepository
     */
    public $dynamicRepository = null;

    /**
     * Controller
     * @var AccountController
     */
    public $controller = null;

    // public function init()
    // {
    //     $this->defaultSortBy = [
    //         'id' => 'DESC'
    //     ];
    // }


    /**
     * set cac repositories khac
     *
     * @param ProfileRepository $profileRepository
     * @param SettingRepository $settingRepository
     * @param OptionSetting $OptionSetting
     * @param AreaRepository $htmlAreaRepository
     * @param DynamicRepository $dynamicRepository
     * @return $this
     */
    public function setRepositories(
        ProfileRepository $profileRepository,
        SettingRepository $settingRepository,
        OptionSetting $OptionSetting,
        AreaRepository $htmlAreaRepository,
        DynamicRepository $dynamicRepository
    ) {
        $this->profiles = $profileRepository;
        $this->webSettings = $settingRepository;
        $this->optionSetting = $OptionSetting;
        $this->htmlAreaRepository = $htmlAreaRepository;
        $this->dynamicRepository = $dynamicRepository;
        return $this;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }
    public function init()
    {
        $this->initMaster();
        $this->defaultSortBy = [
            'id' => 'DESC'
        ];
    }

    public function initMaster()
    {
        $this->addDefaultParam('master_id', static::$master_id)
            ->addDefaultValue('master_id', static::$master_id)
            ->addDefaultValue('type', 'branch-member');
    }


    /**
     * get staffs by info
     * @param string
     */
    public function findLogin($info)
    {
        return $this->where(function ($query) use ($info) {
            $query->where('phone_number', $info)
                ->orWhere('username', $info)
                ->orWhere('email', $info);
        })->first(['status' => 1, 'owner_id' => 0]);
    }


    /**
     * thiết lập truy vấn để sử dụng trong trang quản trị
     * @return object instance
     */
    public function fullInfo()
    {
        $this->setJoinable([
            ['leftJoin', 'profiles', 'profiles.profile_id', '=', 'users.id'],
            ['leftJoin', 'web_settings', 'web_settings.owner_id', '=', 'users.id']
        ])
            ->setSelectable(array_merge($this->columns, ['created_at' => 'users.created_at', 'avatar' => 'users.avatar', 'secret_id' => 'users.secret_id']));
        // dd($this);
        return $this;
    }


    /**
     * thiết lập truy vấn để sử dụng trong trang quản trị
     * @return object instance
     */
    public function enableManagerQuery()
    {
        $this->fullInfo();
        $cc = [
            'id' => 'users.id',
            'secret_id' => 'users.secret_id',
            'secret_key' => 'users.secret_key',
            'client_key' => 'users.client_key',
            'name' => 'users.name',
            'email' => 'users.email',
            'username' => 'users.username',
            'phone_number' => 'users.phone_number',
            'first_name' => 'profiles.first_name'
        ];
        $this->setSearchable($cc)
            ->setWhereable($cc)
            ->setSortable(array_merge($this->columns, ['created_at' => 'users.created_at', 'avatar' => 'users.avatar']));
        // dd($this);
        $this->addDefaultParam('owner_id', 'owner_id', '=', 0);
        return $this;
    }

    /**
     * lấy thông tin chủ web
     * @return \App\Models\User
     */
    public function getOwner()
    {
        return ($id = $this->getOwnerID()) ? $this->clear()->fullInfo()->with(['userWebSetting', 'profile'])->getDetail(['id' => $id]) : null;
    }


    /**
     * tạo dữ liệu chủ web
     *
     * @param User $user
     * @param array $data
     * @param boolean $is_created
     * @return boolean
     */
    public function createOwnerData(User $user, $data = null, $is_created = false)
    {
        // luu thong tin pro file
        $this->profiles->saveProfile($user->id, $data, false);

        // luu thong tin thiet lap
        $this->webSettings->saveOwnerSetting($user->id, $data);

        // $this->optionRepository->createNewData($user->id);


        if ($is_created) {
            // active theme mac dinh tranh bi loi
            ThemeRepository::addOwnerID($user->id);
            // $this->themeRepository->setOwnerID();
            $themeRepository = new ThemeRepository();
            $themeRepository->activeDefault($user->id);
        }

        // thoing tin khoi tao host
        $data['alias_comment'] = isset($data['alias_domain']) && $data['alias_domain'] ? '' : '#';
        $data['alias_domain'] = isset($data['alias_domain']) && $data['alias_domain'] ? $data['alias_domain'] : '';
        $client_key = $user->client_key ? $user->client_key : substr(md5(substr(md5($user->id), 4, 20)), 4, 16);
        $secret_key = $user->secret_key ? $user->secret_key : substr(md5(substr(md5($user->id), 4, 20)), 4, 16);
        $data['secret'] = $client_key;


        $web_type = isset($data['web_type']) ? $data['web_type'] : 'default';

        if ($web_type == "wordpress") {
            if (!is_dir(public_path('wp-content/' . $client_key))) {
                $api = new Api();
                $rs = $api->get(env('HOSTING_MANAGER_API') . '/wp/create?secret_id=' . $client_key)->getBody()->getContents();
                if ($rs != '1') {
                    if ($is_created) {
                        $this->delete($user->id);
                    }
                    return false;
                }
            }


            $metadataRepository = (new MetadataRepository())->addDefaultValue('owner_id', $user->id)->addFixableParam('owner_id', $user->id);
            if (!($meta = $metadataRepository->first(['ref' => 'data', 'ref_id' => 0, 'name' => 'wp_config']))) {
                $pass = null;
                $myConfig = Config::get('database.myadmin', []);
                $myAdmin = new MyAdmin($myConfig['host'], $myConfig['username'], $myConfig['password']);
                $myAdmin->connect();

                if($myAdmin->isConnected){
                    $cs = '`~!@#$%^&*()=,./[]{}';

                    $password = substr(base64_encode(md5(uniqid())), 5, rand(4, 8)) . substr($cs, strlen($cs)-1, 1) .rand(1, 9999). substr($cs, strlen($cs)-1, 1) .substr(md5(base64_encode(md5(uniqid()))), 5, rand(4, 8));
                    if($myAdmin->createDUG($secret_key.'_db', $secret_key.'_master', $password)){
                        $pass = $password;
                        $dCrypt = new DCryptEngine();
                        $pwCrypt = $dCrypt->encode($pass);
                        $ab = new AB0($user->secret_id);
                        
                        $pass = $ab->encode($pass);
                        $meta = $metadataRepository->saveOne('data', 0, 'db_password', $pwCrypt);
                    }
                }
                
                $wpConfig = json_encode([
                    'db_host' => 'localhost',
                    'db_name' => $secret_key.'_db',
                    'db_user' => $secret_key.'_master',
                    'db_password' => $pass?$pass:'',
                    'table_prefix' => 'wp_',
                    'db_charset' => 'utf8',
                    'db_collate' => '',
                    'debug' => false,
                    'use_my_db' => true
                ]);
                $metadata = $metadataRepository->saveOne('data', 0, 'wp_config', $wpConfig, false);
            }
            return true;
        } elseif ($web_type == "vcchosting") {
            $data['secret'] = $secret_key;
            if (
                ($filemanager = $this->controller->getFilemanager(public_path())) &&
                ($secret_key) &&
                ($conf = str_eval($filemanager->getContent(base_path('webdata/vcc.conf')), $data)) &&
                ($nginx = str_eval($filemanager->getContent(base_path('webdata/nginx.conf')), $data))
            ) {
                $stt = false;
                $oldConf = $is_created ? '' : $filemanager->getContent(base_path('webdata/hosting/' . $secret_key . '.conf'));
                $oldNginx = $is_created ? '' : $filemanager->getContent(base_path('webdata/hosting/' . $secret_key . '.nginx.conf'));
                if (
                    ($is_created
                        && $filemanager->save(base_path('webdata/hosting/' . $secret_key . '.conf'), $conf, 'conf')
                        && $filemanager->save(base_path('webdata/hosting/' . $secret_key . '.nginx.conf'), $nginx, 'conf')) ||
                    (!$is_created
                        && $conf != $oldConf
                        && $filemanager->save(base_path('webdata/hosting/' . $secret_key . '.conf'), $conf, 'conf')
                        && $nginx != $oldNginx
                        && $filemanager->save(base_path('webdata/hosting/' . $secret_key . '.nginx.conf'), $nginx, 'conf'))

                ) {
                    $p = $is_created ? 'create' : 'update';
                    $html = str_eval($filemanager->getContent(base_path('webdata/index.html')), $data);
                    $filemanager->save(base_path('webdata/hosting/' . $secret_key . '.html'), $html, 'html');
                    $api = new Api();
                    $rs = $api->get(env('HOSTING_MANAGER_API') . '/hosting/' . $p . '?secret_id=' . $secret_key)->getBody()->getContents();
                    if ($rs != '1') {
                        if ($is_created) {
                            $this->delete($user->id);
                        }
                        return false;
                    }
                    $filemanager->delete(base_path('webdata/hosting/' . $secret_key . '.html'));
                } elseif (!$is_created && $conf == $oldConf) {
                    return true;
                } else {
                    return false;
                }
            }
        }


        return true;
    }
}
