<?php

namespace App\Http\Controllers\Wordpress;

use AB0;
use App\Engines\DCryptEngine;
use Illuminate\Http\Request;

use App\Repositories\Users\UserRepository;

use App\Repositories\Metadatas\MetadataRepository;

use Crazy\Helpers\Arr;

use Crazy\Database\MyAdmin;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class DatabaseController extends ManagerController
{

    protected $module = 'database';
    protected $moduleBlade = 'database';
    protected $moduleName = 'Database';

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
        $this->filemanager = new Filemanager();

        $myConfig = Config::get('database.myadmin', []);

        $this->myAdmin = new MyAdmin($myConfig['host'], $myConfig['username'], $myConfig['password']);
        $this->myAdmin->connect();
    }

    public function getIndex(Request $request)
    {
        $user = $request->user();



        $dbExists = $this->myAdmin->dbExists($user->secret_key.'_db');

        return $this->viewModule('index', compact('dbExists', 'user'));
    }

    public function createDatabase(Request $request)
    {
        $data = $request->validate([
            'db_password' => 'required|string|min:6'
        ], [
            'db_password' => 'Mật khẩu không hợp lệ'
        ]);
        $user = $request->user();
        $secret_id = $user->secret_id;
        $with = [];
        if(!$this->myAdmin->createDUG($user->secret_key.'_db', $user->secret_key.'_master', $data['db_password'])){
            $with['error'] = $this->myAdmin->dugError;
        }
        else{
            $this->metadatRepositoery->addDefaultParam('owner_id', $user->id)->addDefaultValue('owner_id', $user->id);
            $ab = new AB0($user->secret_id);
            $meta = $this->metadatRepositoery->saveOne('data', 0, 'db_password', $ab->encode($data['db_password']));
            $with['success'] = 'Thiết lập database thành công!';
        }
        return redirect()->back()->with($with);
    }


    public function getPassword(Request $request)
    {
        $user = $request->user();
        extract($this->apiDefaultData);
        if (!$request->password) {
            $message = 'Vui lòng nhập mật khẩu';
        } elseif (!Hash::check($request->password, $user->password)) {
            $message = 'Mật khẩu không đúng';
        } elseif (!($meta = $this->metadatRepositoery->first(['owner_id' => $user->id, 'ref' => 'data', 'name' => 'db_password']))) {
            $message = 'Database chưa dược khởi tạo';
        } else {

            try {
                
                $data = $meta->toArray();
                $data['value'] = (new DCryptEngine())->decode($data['value']);
                $status = true;
            } catch (DecryptException $e) {
                $message = 'Không thể hiển thị mật khẩu database ngay lúc này';
                $errors = [
                    'decrypt' => 'message: '. $e->getMessage() .' on line: ' . $e->getLine() . ' of file: ' . $e->getFile() 
                ];
            }
            
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
}
