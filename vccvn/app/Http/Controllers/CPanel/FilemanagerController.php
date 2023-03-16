<?php

namespace App\Http\Controllers\CPanel;

use Illuminate\Http\Request;

use App\Repositories\Users\UserRepository;
use Crazy\Apis\Api;
use Crazy\Helpers\Arr;

class FilemanagerController extends ManagerController
{
    use PathMethods;

    protected $module = 'filemanager';
    protected $moduleBlade = 'filemanager';
    protected $moduleName = 'Filemanager';

    /**
     * @var Filemanager
     */
    public $filemanager = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repositoy = null;
        $this->activeMenu();
        $this->filemanager = new Filemanager();
    }

    public function getIndex(Request $request)
    {
        if (!($data = $this->getPathData($request))) return $this->notFound();
        extract($data);

        if (file_exists($fullPath)) {
            if (is_dir($fullPath)) return $this->viewFolder($fullPath, $relativePath, $path);
            return $this->viewFile($request);
        }

        return $this->notFound();
    }
    public function getFolderSize(Request $request)
    {
        extract($this->apiDefaultData);
        if (!($p = $this->getHomePath($request))) {
            $message = 'Đường dẫn gốc không hợp lệ';
        } else {
            $data = [
                'size' => number_format(get_folder_size($p, 'm'), 2),
                'unit' => 'MB'
            ];
            $status = true;
            $message = 'Đã tạo thư mục thành công!';
        }
        return $this->json(compact(...$this->apiSystemVars));
    }


    public function viewFolder($path, $relativePath = null, $title = null)
    {
        $user = request()->user();
        $list = $this->filemanager->getList($path, null, true);
        return $this->viewModule('filelist', ['user' => $user,'list' => $list, 'path' => $relativePath, 'title' => $title]);
    }

    public function viewFile(Request $request)
    {
        if (!($p = $this->getPathData($request)) || !file_exists($fp = $p['fullPath']) || !is_file($fp)) {
            return $this->notFound();
        } elseif (!in_array($ext = pathinfo($fp, PATHINFO_EXTENSION), get_editor_support_types())) {
            return $this->download($request);
        } 
        return $this->editor($request);
    }

    public function showUploadForm(Request $request)
    {
        if (!($data = $this->getPathData($request)) || count($data) < 4 || !file_exists($data['fullPath']) || !is_dir($data['fullPath'])) return $this->notFound();
        return $this->viewModule('upload', $data);
    }

    public function doUpload(Request $request)
    {
        extract($this->apiDefaultData);
        $code = 500;
        if (!($fdata = $this->getPathData($request)) || count($fdata) < 4 || !file_exists($fdata['fullPath']) || !is_dir($fdata['fullPath'])) {
            $message = 'Đường dẫn không hợp lệ';
            $code = 404;
        } elseif (!$request->hasFile('file')) {
            $message = 'Không cos file đính kèm';
            $code = 415;
        } elseif (!($file = $request->file('file')) || !$file->move($fdata['fullPath'], $file->getClientOriginalName())) {
            $message = 'Upload không thành công!';
            $code = 500;
        } else {
            $status = true;
            $code = 200;
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = $file->getClientOriginalName();
            $mime = $file->getClientMimeType();
            $ftype = explode('/', $mime);
            $filetype = $ftype[0];
            $filepath = rtrim($fdata['fullPath'], '/') . '/' . $filename;
            $size = filesize($filepath) / 1024;
            $data = new Arr(compact('filename', 'mime', 'size', 'filetype', 'extension', 'fdata'));
        }
        return $this->json(compact(...$this->apiSystemVars), $code);
    }

    public function moveItems(Request $request)
    {
        extract($this->apiDefaultData);
        if (!($p = $this->getPathData($request))) {
            $message = 'Đường dẫn gốc không hợp lệ';
        } elseif (!is_dir($newDir = $p['homePath'] . ($request->directory ? '/' . ltrim($request->directory) : ''))) {
            $message = 'Đường dẫn đích không hợp lệ';
        } elseif (trim($request->directory, '/') == trim($p['relativePath'], '/')) {
            $message = 'Thao tác không hợp lệ';
        } elseif (!is_array($request->items) || !count($request->items)) {
            $message = 'Không có mục nào được chọn';
        } else {
            // $status = true;
            $max = count($items = $request->items);
            $f = $p['fullPath'] . '/';
            $list = [];
            for ($i = 0; $i < $max; $i++) {
                $item = $items[$i];
                if (file_exists($rf = $f . $item)) {
                    if (str_replace($rf, '', $newDir) != $newDir) {
                        $message = 'Bạn không thể di chuyển thư mục vào bên trong nó hay các thư mục con của nó';
                        return $this->json(compact(...$this->apiSystemVars));
                    }
                    $list[] = $item;
                }
            }
            if ($list && $this->filemanager->move($p['fullPath'], $newDir, $list)) {
                $status = true;
                $data = $list;
            } else {
                $message = 'Không thể d chuyển các mục đã chọn';
            }
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function unzip(Request $request)
    {
        extract($this->apiDefaultData);
        if (!($p = $this->getPathData($request))) {
            $message = 'Đường dẫn gốc không hợp lệ';
        } elseif (!is_dir($newDir = $p['homePath'] . ($request->directory ? '/' . ltrim($request->directory) : ''))) {
            $message = 'Đường dẫn đích không hợp lệ';
        } elseif (!$request->filename || !file_exists($fp = $p['fullPath'] . '/' . $request->filename) || !($file = $this->filemanager->info($fp)) || $file->ext != 'zip') {
            $message = 'File không hợp lệ';
        } elseif (!$this->filemanager->extract($fp, $newDir)) {
            $message = 'Giải nén không thành công! Vui lòng thử lại sau giây lát';
        } else {
            $status = true;
            $message = 'Giải nén thành công!';
            $data = [
                'directory' => $request->directory,
            ];

        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function rename(Request $request)
    {
        extract($this->apiDefaultData);
        if (!($p = $this->getPathData($request))) {
            $message = 'Đường dẫn gốc không hợp lệ';
        } elseif ($request->old_name == $request->new_name) {
            $message = 'Tên mới chả khác mẹ gì tên cũ';
        } elseif (!$request->old_name || !file_exists($old_item = $p['fullPath'] . '/' . $request->old_name)) {
            $message = 'Mục này không tồn tại';
        } elseif (!$request->new_name || !is_filename($request->new_name)) {
            $message = 'Tên mới không hợp lệ';
        } elseif (file_exists($new_item = $p['fullPath'] . '/' . trim($request->new_name))) {
            $message = 'Trùng tên';
        } elseif (!$this->filemanager->copy($old_item, $new_item) || !file_exists($new_item)) {
            $message = 'Đã có lỗi xảy ra. vui lòng thử lại sau giây lát';
        } else {
            $status = true;
            $message = 'Đã đổi tên thành công!';
            $this->filemanager->delete($old_item, $new_item);
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function download(Request $request)
    {
        if (!($p = $this->getPathData($request)) || !file_exists($fp = $p['fullPath']) || !is_file($fp)) {
            return $this->notFound();
        }
        $a = explode('/', $p['fullPath']);
        $filename = array_pop($a);
        return response()->download($p['fullPath'], $filename);
    }

    public function deleteItems(Request $request)
    {
        extract($this->apiDefaultData);
        if (!($p = $this->getPathData($request))) {
            $message = 'Đường dẫn gốc không hợp lệ';
        } elseif (!is_array($request->items) || !count($request->items)) {
            $message = 'Không có mục nào được chọn';
        } else {
            // $status = true;
            $max = count($items = $request->items);
            $f = $p['fullPath'] . '/';
            $list = [];
            for ($i = 0; $i < $max; $i++) {
                $item = $items[$i];
                if (file_exists($rf = $f . $item)) {
                    if ($this->filemanager->delete($rf)) {
                        $list[] = $item;
                    }
                }
            }
            if ($list) {
                $status = true;
                $data = $list;
            } else {
                $message = 'Không thể xoá các mục đã chọn';
            }
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function createFolder(Request $request)
    {
        extract($this->apiDefaultData);
        if (!($p = $this->getPathData($request))) {
            $message = 'Đường dẫn gốc không hợp lệ';
        } elseif (!$request->name || !is_filename($request->name)) {
            $message = 'Tên thư mục không hợp lệ';
        } elseif (is_dir($d = $p['fullPath'] . '/' . trim($request->name))) {
            $message = 'Thư mục đã dược tạo trước đó';
        } elseif (!$this->filemanager->makeDir($d, 0777) || !is_dir($d)) {
            $message = 'Không thể tạo tư mục trong thời điểm hiện tại. vui lòng thử lại sau giây lát';
        } else {
            $status = true;
            $message = 'Đã tạo thư mục thành công!';
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function createFile(Request $request)
    {
        extract($this->apiDefaultData);
        if (!($p = $this->getPathData($request))) {
            $message = 'Đường dẫn gốc không hợp lệ';
        } elseif (!$request->name || !is_filename($filename = $request->name)) {
            $message = 'Tên file không hợp lệ';
        } elseif (!in_array($ext = $request->extension, get_editor_support_types())) {
            $message = 'Loại file không hỗ trợ';
        } elseif (file_exists($d = $p['fullPath'] . '/' . trim($filename))) {
            $message = 'File đã dược tạo trước đó';
        } else {
            $a = explode('.', $filename);
            $e = strtolower(array_pop($a));
            if ($e != $ext) {
                $filename .= '.' . $ext;
                $d .= '.' . $ext;
            }
            if ($this->filemanager->save($d, $request->content, $ext)) {
                $status = true;
                $message = 'Đã tệp tin ' . $filename . ' thành công!';
                $data = [
                    'filename' => $filename,
                    'path' => str_replace($p['homePath'], '', $d)
                ];
            } else {
                $message = 'Đã có lỗi xảy ra. Vui lòng thử lại sau giây lát';
            }
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function editor(Request $request)
    {
        if (!($p = $this->getPathData($request)) || !file_exists($fp = $p['fullPath']) || (!is_file($fp) && !is_dir($fp))) {
            return $this->notFound();
        }
        extract($p);

        if (is_dir($fp)) {
            $content = '';

            $path = $relativePath;
            $filename = '';
            $ext = '*';
        } elseif (!in_array($ext = pathinfo($fp, PATHINFO_EXTENSION), get_editor_support_types())) {
            return $this->message("Loại file này không được hỗ trợ ");
        } else {
            $content = $this->filemanager->getContent($fp);

            $a = explode('/', $relativePath);
            $filename = array_pop($a);
            $path = implode('/', $a);
        }

        return $this->viewModule('editor', compact('filename', 'content', 'path', 'relativePath',  'ext'));
    }

    public function saveFileContent(Request $request)
    {
        $errors = [];
        if (!($p = $this->getPathData($request))) $errors['path'] = 'Đường dẫn không hợp lệ';
        elseif (!($fn = $request->filename) || !is_filename($fn)) {
            $errors['filename'] = 'Tên tệp tin không hợp lệ';
        } elseif (!$this->filemanager->save($p['fullPath'] . '/'. $fn, $request->content)) {
            $errors['content'] = 'Nội dung file chưa được lưu';
        }
        if ($errors) {
            return redirect()->back()->withErrors($errors)->withInput();
        }
        return redirect()->route('filemanager.editor', ['p' => $request->path . '/' . $fn])->with('success', 'Đã lưu nội dung file thành công!');
    }

    public function installPackage(Request $request)
    {
        extract($this->apiDefaultData);
        if (!in_array($p = strtolower($request->package), ['laravel', 'wordpress-vi', 'wordpress-en'])) {
            $message = 'Gói không hợp lệ';
        } elseif (!($api = new Api()) || $api->get(env('HOSTING_MANAGER_API') . '/hosting/install?secret_id=' . $request->user()->secret_key.'&package='.$p)->getBody()->getContents() != '1') {
            $message = 'Cài đặt gói không thành công';
        }else{
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function command(Request $request)
    {
        extract($this->apiDefaultData);
        if (!($cmds = get_hosting_commands()) || !$request->command || !array_key_exists($request->command,$cmds)) {
            $message = 'Command not found';
        } elseif (!($cmd = $cmds[$request->command]) || ($cmd[1] && !$request->parameters) || ($request->parameters && preg_match('/[^A-z0-9\/\-_=\s]/si', $request->parameters))) {
            $message = 'Parameter is invalid';
        }elseif (!($api = new Api()) || ($rs = $api->get(env('HOSTING_MANAGER_API') . '/hosting/command?secret_id=' . $request->user()->secret_key.'&command='.$request->command .'&parameters='.urlencode($request->parameters))->getBody()->getContents()) == '0') {
            $message = 'Error';
        }else{
            $data = [
                'result' => $rs
            ];
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
}
