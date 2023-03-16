<?php

function get_args_params($args = [])
{
    $data = [
        'args' => [],
        'params' => []
    ];
    if(is_array($args)){
        foreach ($args as $key => $param) {
            if(substr($param, 0, 2) == '--'){
                $pc = explode('=', substr($param, 2));
                $f = array_shift($pc);
                if(count($pc) >0){
                    $data['params'][$f] = implode('=', $pc);
                }else{
                    $data['params'][$f] = true;
                }
            }else{
                $data['args'][] = $param;
            }
        }
    }
    return $data;
}

function make_command($args = [], $command = null, ...$params)
{
    if(!$command){
        echo "Tham so:\n\t\$command -- leng65 lệnh\n\t...\$params -- danh sách tham số\n\n";
        return null;
    }
    
    if(!preg_match('/^[A-z_]+[A-z0-9_]*$/', $command)){
        echo 'Command không được chứa ký tự đặt biệt';
        return null;
    }
    if(function_exists($command)){
        echo 'Command Đã tồn tại';
        return null;
    }
    $args = array_map(function($value){
        return '$'.str_replace('/[^A-z0-9_\=\'\"\s\[\]]/i', '_', trim($value));
    }, $params);
    $find = ['Command', '$args'];
    $replace = [$command, implode(', ', $args)];
    $template = file_get_contents(DEVPATH.'/templates/command.php');
    $code = str_replace($find, $replace, $template);
    $filemanager = new Filemanager();
    $filemanager->setDir((DEVPATH.'/commands/'));
    if($a = $filemanager->save($command.'.php', $code, 'php')){
        echo "Tạo $command thành công!\nBạn có thể sửa file theo dường dẫn sau: \n$a->path \n";
    }else{
        echo "Lỗi không xác định\n";
    }
}


if(!function_exists('make_controller')){
    /**
     * make_controller
     * 
     */
    function make_controller($args = [], $type = 'client', $name=null, $repo=null, $title=null, $module=null)
    {
        if(!$name){
            echo "Tham so:\n\t\$type -- loai controller (client, admin, manager, api, custom)\n\t\$name -- Ten controller\n\t\$repo -- ten class Repository/Model\n\t\$title -- ten/tieu de\n\t\$module -- js module && route module\n\n";
            return null;
        }
        $folders = [
            'client' => 'Clients',
            'admin' => 'Admin',
            'account' => 'Accounts',
            'manager' => 'Manager',
            'branch' => 'Branch',
            'cpanel' => 'CPanel',
            'api' => 'Apis',
            'custom' => null
        ];
        $ac = explode('/', str_replace("\\", "/", $name));
        $name = array_pop($ac);
        if(!array_key_exists($t = strtolower($type), $folders) || !$name) return null;
        $s = implode('/', array_map('ucfirst', $ac));
        $folder = $folders[$t] . ($s?'/'.$s:'');
        $master = ucfirst($t);
        $prectr = $master;
        if($master){
            $prectr = $folders[$t]."\\".$master;
        }
        $sub = null;
        if($folder){
            $folder = '/'.trim($folder, '/');
            $sub = str_replace("/", "\\", $folder);
        }
        if(!$repo) $repo = $name;
        $repos = explode('/', str_replace("\\", "/", $repo));
        $repo = ucfirst(array_pop($repos));
        $repf = count($repos) ? implode('/', array_map('ucfirst', $repos)) : ucfirst(Str::plural($repo));

        if(!$title) $title = $name;
        if(!$module) $module = strtolower(Str::plural($name));
        
        $find = ['NAME', 'MASTER', 'SUB', 'REPO', 'REPF', 'MODULE', 'TITLE', 'PRECTRL'];
        $replace = [$name, $master, $sub, $repo, $repf, $module, $title, $prectr];

        $template = file_get_contents(DEVPATH.'/templates/controller.php');
        $code = str_replace($find, $replace, $template);
        $filemanager = new Filemanager();
        $filemanager->setDir((BASEDIR.'/app/Http/Controllers'.$folder.'/'));
        if($a = $filemanager->save($name.'Controller.php', $code, 'php')){
            echo "Tạo {$name}Controller thành công!\nBạn có thể sửa file theo dường dẫn sau: \n$a->path \n";
        }else{
            echo "Lỗi không xác định\n";
        }
    }
}


function make_repository($args = [], $name = null, $model = null)
{
    if(!$name){
        echo "Tham so:\n\$name -- Ten Repository\n\$model -- Tên model\n";
        return null;
    }
    $names = explode('/', str_replace("\\", "/", $name));
    $name = ucfirst(array_pop($names));
    $folder = count($names) ? implode('/', array_map('ucfirst', $names)) : ucfirst(Str::plural($name));
    
    if(!$model) $model = $name;
    $find = ['NAME', 'MODEL', 'FOLDER'];
    $replace = [$name, $model, $folder];
    $filemanager = new Filemanager();
    $template = file_get_contents(DEVPATH.'/templates/repository.php');
    $filemanager->setDir(base_path('app/Repositories/'.$folder.'/'));
    $code = str_replace($find, $replace, $template);
    if($a = $filemanager->save($name.'Repository.php', $code, 'php')){
        echo "Tạo {$name}Repository thành công!\nBạn có thể sửa file theo dường dẫn sau: \n$a->path \n";
    }else{
        echo "Lỗi không xác định\n";
    }
}

function make_validator($args = [], $name = null, $table = null)
{
    if(!$name){
        echo "Tham so:\n\$name -- Ten Validator\n\$table -- Tên bảng";
        return null;
    }
    $names = explode('/', str_replace("\\", "/", $name));
    $name = ucfirst(array_pop($names));
    $folder = count($names) ? implode('/', array_map('ucfirst', $names)) : ucfirst(Str::plural($name));
    
    if(!$table) $table = Str::tableName($name);
    
    $find = ['NAME', 'FOLDER','$RULES', '$MESSAGES'];
    $replace = [$name, $folder, getRules($table), getMessages($table)];
    $filemanager = new Filemanager();
    $template = file_get_contents(DEVPATH.'/templates/validator.php');
    $filemanager->setDir(base_path('app/Validators/'.$folder.'/'));
    $code = str_replace($find, $replace, $template);
    if($a = $filemanager->save($name.'Validator.php', $code, 'php')){
        echo "Tạo {$name}Validator thành công!\nBạn có thể sửa file theo dường dẫn sau: \n$a->path \n";
    }else{
        echo "Lỗi không xác định\n";
    }
}



function make_engine($args = [], $name = null)
{
    if(!$name){
        echo "Tham so:\n\$name -- Ten Engine";
        return null;
    }
    $filemanager = new Filemanager();
    $template = file_get_contents(DEVPATH.'/templates/engine.php');
    $filemanager->setDir(base_path('app/Engines/'));
    $find = ['NAME'];
    $replace = [$name];
    $code = str_replace($find, $replace, $template);
    if($a = $filemanager->save($name.'Engine.php', $code, 'php')){
        echo "Tạo {$name}Engine thành công!\nBạn có thể sửa file theo dường dẫn sau: \n$a->path \n";
    }else{
        echo "Lỗi không xác định\n";
    }
}


function make_model($args = [], $name = null, $table = null)
{
    if(!$name){
        echo "Tham so:\n\$name -- Ten Model\n\$table -- Tên bảng\n...\$args -- tham số\n";
        return null;
    }
    if(!$table) $table = Str::tableName($name);

    $find = ['NAME','TABLE', 'FILLABLE', '//PROPS'];
    $props = [];


    $params = $args;
    if(isset($params['softdelete'])){
        $props[] = "protected \$deleteMode = 'soft';";
    }


    $replace = [$name, $table, getFields($table, true), implode("\n    ", $props)];
    $filemanager = new Filemanager();
    $template = file_get_contents(DEVPATH.'/templates/model.php');
    $filemanager->setDir(base_path('app/Models/'));
    $code = str_replace($find, $replace, $template);
    if($a = $filemanager->save($name.'.php', $code, 'php')){
        echo "Tạo {$name} thành công!\nBạn có thể sửa file theo dường dẫn sau: \n$a->path \n";
    }else{
        echo "Lỗi không xác định\n";
    }
}

function make_resource($args = [], $name = null, $table = null)
{
    if(!$name){
        echo "Tham so:\n\$name -- Ten resource\n\$table -- Tên bảng\n";
        return null;
    }
    if(!$table) $table = Str::tableName($name);

    $find = ['NAME', '$ELEMENTS'];
    $replace = [$name, getResource($table)];
    $filemanager = new Filemanager();
    $template = file_get_contents(DEVPATH.'/templates/resource.php');
    $filemanager->setDir(base_path('app/Http/Resources'));
    $code = str_replace($find, $replace, $template);
    if($a = $filemanager->save($name.'Resource.php', $code, 'php')){
        echo "Tạo {$name}Resource thành công!\nBạn có thể sửa file theo dường dẫn sau: \n$a->path \n";
        $template = file_get_contents(DEVPATH.'/templates/resource-item.php');
        $code = str_replace($find, $replace, $template);
        $na = $name.'Item';
        if($a = $filemanager->save($na.'.php', $code, 'php')){
            echo "Tạo $na thành công!\nBạn có thể sửa file theo dường dẫn sau: \n$a->path \n";
        }else{
            echo "Lỗi không xác định\n";
        }

        $template = file_get_contents(DEVPATH.'/templates/resource-collection.php');
        $code = str_replace($find, $replace, $template);
        $na = $name.'Collection';
        if($a = $filemanager->save($na.'.php', $code, 'php')){
            echo "Tạo $na thành công!\nBạn có thể sửa file theo dường dẫn sau: \n$a->path \n";
        }else{
            echo "Lỗi không xác định\n";
        }
    }else{
        echo "Lỗi không xác định\n";
    }
}



function make_modules($args = [], $make_list = null, $name = null, $table=null)
{
    if(!$make_list){
        echo "";
    }
    $supported = 'model,repository,validator,resource,controller';
    if(strtolower($make_list) == 'all' || $make_list == '*' || !$make_list) $make_list = $supported;
    $sp = explode(',', $supported);
    $ml = array_filter(
        array_map(
            function($val){
                return trim(strtolower($val));
            }, 
            explode(',', $make_list)
        ), 
        function($value) use($sp){
            return in_array($value, $sp);
        }
    );
    if(!$ml){
        echo $make_list . 'không được hỗ trợ';
        return null;
    }
    if(!$name) $name = 'Test';
    $names = explode('/', str_replace("\\", "/", $name));
    $name = ucfirst(array_pop($names));
    $folder = count($names) ? implode('/', array_map('ucfirst', $names)) : ucfirst(Str::plural($name));
    $table = $table??Str::tableName($name);
    if($make_list){
        foreach($ml as $item){
            // 
            switch ($item) {
                case 'model':
                case 'resource':
                case 'validator':
                    call_user_func_array('make_'.$item, [$args, $name, $table, $folder]);
                    break;
                
                case 'repository':
                    # code...
                    call_user_func_array('make_'.$item, [$args, $name, $name, $folder]);
                    break;
                
                case 'controller':
                    # code...
                    break;
                
                default:
                    # code...
                    break;
            }
        }
    }
}

function make_json($args = [], $table, $filename){
    $filemanager = new Filemanager(base_path('json'));
    if($file = $filemanager->save($filename, Str::jsonVi(json_encode(defaultJson($table))), 'json')){
        echo "Đã tạo file thành công!\n Bạn có thể chỉnh sửa file theo dường dẫn sau:\n$file->path\n";
    }
}


function make_json_module($args = [], $module=null, $table=null, $path = null){
    if(!$module){
        echo "Tham so:\n\t\$module -- Ten thư mục\n\t\$table -- Tên bảng\n\t\$path -- duong dan tu thu muc /json/";
        return null;
    }
    $names = explode('/', str_replace("\\", "/", $module));
    $name = ucfirst(array_pop($names));
    
    if(!$table) $table = Str::tableName($name);

    $filemanager = new Filemanager(base_path('json/'.ltrim($path, '/')));
    if($file = $filemanager->save($module .'/form.json', Str::jsonVi(json_encode(defaultJson($table))), 'json')){
        echo "create form success\nPath: $file->path\n";
    }
    $fields = schema($table)->getData();
    $json = ["name" => "[module]","package"=> "customers","use_trash" => true,
        "titles" => ["default" => "Danh sách [module]","trash" => "Danh sách [module] đã xóa"],
        "data" => [],"filter" => ["search_columns" => [],"sort_columns" => []],
        "table" => ["class"=> "header-center","columns"=> []],
        "resources" => ["js_data"=>[],"js"=>[],"css"=>[]]
    ];
    $json['package'] = $table;
    $columns = [];
    foreach($fields as $col){
        $columns[] = [
            'title' => '',
            'class' => '',
            'text' => ':'.$col
        ];
    }
    $json['table']['columns'] = $columns;
    if($file = $filemanager->save($module .'/list.json', Str::jsonVi(json_encode($json)), 'json')){
        echo "create list success\nPath: $file->path\n";
    }
    
}




if(!function_exists('make_mask')){
    /**
     * make_mask
     * 
     */
    function make_mask($args = [], $name=null, $model=null, $make_collection = null)
    {
        if(!$name){
            echo "Tham so:\n\t\$name (required): Ten mask (nên sử dụng [Folder]/[name])\n\t\$model (option): Tên Model\n\t\$make_collection (option): có tạo collection hay ko";
            return null;
        }

        $names = explode('/', str_replace("\\", "/", $name));
        $name = ucfirst(array_pop($names));
        if(!$model){
            $model = $name;
        }
        $folder = count($names) ? implode('/', array_map('ucfirst', $names)) : ucfirst(Str::plural($name));
        $sub = null;
        if($folder){
            $folder = '/'.trim($folder, '/');
            $sub = str_replace("/", "\\", $folder);
        }

        
        $find = ['NAME', 'MODEL', '$model', 'SUB'];
        $replace = [$name, $model, '$'.strtolower(substr($model, 0, 1)).substr($model, 1), $sub];

        $template = file_get_contents(DEVPATH.'/templates/mask.php');
        $code = str_replace($find, $replace, $template);
        $filemanager = new Filemanager();
        $filemanager->setDir((BASEDIR.'/app/Masks'.$folder.'/'));
        if($a = $filemanager->save($name.'Mask.php', $code, 'php')){
            echo "Tạo {$name}Mask thành công!\nBạn có thể sửa file theo dường dẫn sau: \n$a->path \n";
        }else{
            echo "Lỗi không xác định\n";
        }
        if(!in_array($make_collection, ['-n', '--n', '-no', 'no', 'k', 'khong', 'đéo'])){
            $find[] = 'MASK';
            $replace[] = $name;
            make_mask_collection_file($name, $folder, $find, $replace);
        }
    }
}


if(!function_exists('make_mask_collection')){
    /**
     * make_mask
     * 
     */
    function make_mask_collection($name=null, $mask=null)
    {
        if(!$name){
            echo "Tham so:\n\t\$name (required): Tên collection (nên sử dụng [Folder]/[name])\n\t\$mask (option): Tên mask";
            return null;
        }

        $names = explode('/', str_replace("\\", "/", $name));
        $name = ucfirst(array_pop($names));
        if(!$mask){
            $mask = $name;
        }
        $folder = count($names) ? implode('/', array_map('ucfirst', $names)) : ucfirst(Str::plural($name));
        $sub = null;
        if($folder){
            $folder = '/'.trim($folder, '/');
            $sub = str_replace("/", "\\", $folder);
        }

        
        $find = ['NAME', 'MASK', 'SUB'];
        $replace = [$name, $mask, $sub];

        make_mask_collection_file($name, $folder, $find, $replace);
    }
}


if(!function_exists('make_mask_collection_file')){
    /**
     * make_mask
     * 
     */
    function make_mask_collection_file($name, $folder, $find, $replace)
    {
        $template = file_get_contents(DEVPATH.'/templates/mask-collection.php');
        $code = str_replace($find, $replace, $template);
        $filemanager = new Filemanager();
        $filemanager->setDir((BASEDIR.'/app/Masks'.$folder.'/'));
        if($a = $filemanager->save($name.'Collection.php', $code, 'php')){
            echo "Tạo {$name}Collection thành công!\nBạn có thể sửa file theo dường dẫn sau: \n$a->path \n";
        }else{
            echo "Lỗi không xác định\n";
        }
    }
}





function update_storage_data(){
    if(convert_json_to_php(base_path('json'), base_path('storage/crazy/data'))){
        echo 'Cạp nhập file thành công';
    }else{
        echo 'Lỗi ko xác định';
    }
}

function convert_json_to_php($json_path, $php_path){
    $filemanager = new Filemanager($json_path);
    $status = false;
    if($list = $filemanager->getList()){
        foreach ($list as $file) {
            if($file->type == 'folder'){
                if(convert_json_to_php($json_path.'/'.$file->name, $php_path.'/'.$file->name)) $status = true;;
            }elseif($file->extension == 'json'){
                $filemanager->convertJsonToPhp($file->name, $php_path.'/'.preg_replace('/\.json$/i', '.php', $file->name));
                $status = true;
            }
        }
    }
    return $status;
}


function make($object, ...$params){
    $p = get_args_params($params);
    if($object == 'modules' || $object == 'module'){
        make_modules($p['params'], ...$p['args']);
    }elseif(is_callable('make_'.$object)){
        $args = array_merge([$p['params']], $p['args']);
        call_user_func_array('make_'.$object, $args);
    }
    
    else make_modules($object, $p['params'], ...$p['args']);
}
