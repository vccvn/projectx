<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;

use App\Repositories\Users\UserRepository;

use App\Repositories\Metadatas\MetadataRepository;

use Crazy\Helpers\Arr;

use Crazy\Database\MyAdmin;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class ApiCallbackController extends ManagerController
{

    protected $module = 'config';
    protected $moduleBlade = 'config';
    protected $moduleName = 'Config';

    /**
     * myAdmin
     *
     * @var MyAdmin
     */
    public $myAdmin = null;

    /**
     * @var Filemanager
     */
    public $filemanager = null;


    /**
     * user
     *
     * @var UserRepository
     */
    public $repository = null;

    /**
     * metadata
     *
     * @var MetadataRepository
     */
    public $metadatRepositoery = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, MetadataRepository $metadataRepository)
    {
        $this->repository = $userRepository;
        $this->metadatRepositoery = $metadataRepository;
        $this->activeMenu();
    }

    public function getIndex(Request $request)
    {
        $user = $request->user();

        // $dbExists = $this->myAdmin->dbExists($user->secret_id);

        $user->applyMeta();
        $meta = $this->metadatRepositoery->first([
            'ref' => 'data',
            'ref_id' => 0,
            'name' => 'api_config',
            'owner_id' => $user->id
        ]);
        $api = new Arr($meta->value?json_decode($meta->value) : []);
        return $this->viewModule('index', compact('api', 'user'));
    }

    public function saveWPConfig(Request $request)
    {
        $validator = $this->repository->validator($request, 'Web\WPConfig');
        $with = [];
        $user = $request->user();
        $errors = [];
        $this->metadatRepositoery->addDefaultParam('owner_id', $user->id)->addDefaultValue('owner_id', $user->id);
        if(!$validator->success() || !($data = $validator->inputs())){
            $with['error'] = 'Dữ liệu không hợp lệ';
            $errors = $validator->getErrorObject();
        }
        elseif (!($this->metadatRepositoery->saveOne('data', 0, 'api_config', $data))) {
            $with['error'] = 'Lỗi hệ thống không thể tạo cấu hình';
        } else {
            $with['success'] = 'Thiết lập Cấu hình thành công!';
        }
        $back = redirect()->back();
        if($errors) $back->withErrors($errors);
        return $back->with($with);
    }
}
