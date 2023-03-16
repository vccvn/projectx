<?php

namespace App\Http\Controllers\CPanel;

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
     * @var DCryptEngine $dcrypt
     */
    public $dcrypt = null;
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
    public function __construct(UserRepository $userRepository, MetadataRepository $metadataRepository, DCryptEngine $dCryptEngine)
    {
        $this->repository = $userRepository;
        $this->metadatRepositoery = $metadataRepository;
        $this->activeMenu();
        $this->filemanager = new Filemanager();
        $this->dcrypt = $dCryptEngine;
        $myConfig = Config::get('database.myadmin', []);
        $this->myAdmin = new MyAdmin($myConfig['host'], $myConfig['username'], $myConfig['password']);
        $this->myAdmin->connect();
    }

    public function getIndex(Request $request)
    {
        $user = $request->user();

        $dbExists = $this->myAdmin->dbExists($user->secret_id);

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
        if (!($createUser = $this->myAdmin->createDatabase($secret_id))) {
            $with['error'] = 'Lỗi hệ thống không thể tạo database';
        } elseif (!($createDatabase = $this->myAdmin->createUser($secret_id, $data['db_password']))) {
            $with['error'] = 'Không thể khởi tạo user';
            $with['error'] = 'Không thể khởi tạo user (' .('SQLSTATE[HY000]: General error: 1819 Your password does not satisfy the current policy requirements' == $this->myAdmin->errorMessage ?'Mật khẩu không an toàn': $this->myAdmin->errorMessage) .')';
            if(!$this->myAdmin->dropDatabase($secret_id)){
                // throw new Exception("Không thể xóa database");
            }
        } elseif (!($grant = $this->myAdmin->grant($secret_id, $secret_id))) {
            $this->myAdmin->dropDatabase($secret_id);
            $this->myAdmin->dropUser($secret_id);
            $with['error'] = 'Không thể gán quyền choi user';
        } else {
            $this->metadatRepositoery->addDefaultParam('owner_id', $user->id)->addDefaultValue('owner_id', $user->id);
            $meta = $this->metadatRepositoery->saveOne('data', 0, 'db_password', $this->dcrypt->encode($data['db_password']));
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
                $meta->value = $this->dcrypt->decode($meta->value);
                $data = $meta;
                $status = true;
            } catch (Exception $e) {
                $message = 'Không thể hiển thị mật khẩu database ngay lúc này';
                $errors = [
                    'decrypt' => 'message: '. $e->getMessage() .' on line: ' . $e->getLine() . ' of file: ' . $e->getFile() 
                ];
            }
            
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
}
