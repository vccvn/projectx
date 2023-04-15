<?php

namespace App\Http\Controllers\Traits;

use Crazy\Helpers\Arr;
use Crazy\Laravel\Router;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * các thuộc tính và phương thức của form sẽ được triển trong ManagerController
 * @method void prepareGetForm($request, $config, $attrs, $vars)
 * @method void prepareGetCrudForm($request, $config, $attrs, $vars)
 * @method void prepareGetCreateForm($request, $config, $attrs, $vars)
 * @method void prepareGetUpdateForm($request, $config, $attrs, $vars)
 * 
 * @method void beforeGetForm($request, $config, $inputs, $data, $attrs)
 * @method void beforeGetCrudForm($request, $config, $inputs, $data, $attrs)
 * @method void beforeGetCreateForm($request, $config, $inputs, $data, $attrs)
 * @method void beforeGetUpdateForm($request, $config, $inputs, $data, $attrs)
 * 
 * 
 */
trait FormMethods
{
    /**
     * @var string dường dãn thư mục chứa form
     */
    protected $formDir = null;



    /**
     * @var string $jsonFormDir
     */
    protected $jsonFormDir = null;

    /**
     * @var string $phpFormDir
     */
    protected $phpFormDir = null;


    /**
     * @var string form realpath
     */
    protected $realFormDir = null;

    /**
     * các action dc ho tro
     * @var array
     */
    protected $crudActions = ['create', 'update'];

    /**
     * @var string $createFormTitle tiêu đề form tạo dử liệu mới
     */
    protected $createFormTitle = '';

    /**
     * @var string $createSubmitRoute route để gửi form tạo mới
     */
    protected $createSubmitRoute = '';

    /**
     * @var array $createSubmitRouteParams tham số route để gửi form tạo mới
     */
    protected $createSubmitParams = [];

    /**
     * @var string $createSubmitUrl url để gửi form tạo mới
     */
    protected $createSubmitUrl = '';

    /**
     * @var string $createFormView đường dãn tính từ manager. ví dụ user.form
     */
    protected $createFormView = '';

    /**
     * @var string $createButtonText Chữ hiển thị trong nút tạo mới dữ liệu
     */
    protected $createButtonText = 'Thêm mới';

    /**
     * @var string $createFormJson tên file hoặc đừng dẫn json form tính từ json/manager/forms
     */
    protected $createFormJson = '';

    /**
     * @var string $createFormConfigJson tên file hoặc đừng dẫn json form tính từ json/manager/forms
     */
    protected $createFormConfigJson = '';

    /**
     * @var string $updateFormTitle tiêu đề form cập nhật dử liệu mới
     */
    protected $updateFormTitle = '';

    /**
     * @var string $updateSubmitRoute route để gửi form cập nhật
     */
    protected $updateSubmitRoute = '';
    /**
     * @var string $updateSubmitUrl url để gửi form cập nhật
     */
    protected $updateSubmitUrl = '';

    /**
     * @var array $updateSubmitRouteParams tham số
     */
    protected $updateSubmitParams = [];

    /**
     * @var string $updateFormView đường dãn tính từ manager. ví dụ user.form
     */
    protected $updateFormView = '';

    /**
     * @var string $createButtonText Chữ hiển thị trong nút tạo mới dữ liệu
     */
    protected $updateButtonText = '';

    /**
     * @var string $updateFormJson tên file hoặc đừng dẫn json form tính từ json/manager/forms
     */
    protected $updateFormJson = '';

    /**
     * @var string $updateFormConfigJson tên file hoặc đừng dẫn json form tính từ json/manager/forms
     */
    protected $updateFormConfigJson = '';

    /**
     * @var string $cancelButtonText
     */
    protected $cancelButtonText = '';

    /**
     * @var string $cancelButtonUrl
     */
    protected $cancelButtonUrl = '';


    /**
     * @var array $crudJS danh sach link js sẽ dc include
     */
    protected $crudJS = [];

    /**
     * @var array $crudCSS danh sách link css
     */
    protected $crudCSS = [];

    /**
     * @var boolean $hasConfigFile
     */
    protected $hasConfigFile = false;


    /**
     * @var string $formLayout
     */
    protected $formLayout = 'forms.master';



    /**
     * @var string $formTitle
     */
    protected $formTitle = '';

    /**
     * @var string 
     */
    protected $submitRoute = '';
    /**
     * @var string 
     */
    protected $submitUrl = '';

    /**
     * @var array 
     */
    protected $submitRouteParams = [];

    /**
     * @var string $formView View mặc định
     */
    protected $formView = '';


    /**
     * @var string
     */
    protected $btnSubmitEext = 'Xong';




    /**
     * thiet lap thong so
     * @return void
     */
    public function formInit()
    {
        $this->updateFormDir();
    }

    /**
     * cập nhật dường dẫn form
     * @return void
     */

    public function updateFormDir()
    {
        $this->jsonFormDir = json_path($this->formDir);
        $this->phpFormDir = storage_path('crazy/' . ltrim($this->formDir, '/'));
        $this->realFormDir = $this->jsonFormDir;
    }

    /**
     * lấy dường dẫn thư mục form
     * @return string
     */
    public function getJsonFormDir()
    {
        return $this->jsonFormDir;
    }

    /**
     * lấy dường dẫn thư mục form
     * @return string
     */
    public function getPhpFormDir()
    {
        return $this->phpFormDir;
    }

    /**
     * lấy dường dẫn thư mục form
     * @return string
     */
    public function getFormDir()
    {
        return $this->realFormDir;
    }

    /**
     * set form dir
     * @param string $jsondir
     */
    public function setFormDir($jsondir = null)
    {
        if ($jsondir) {
            $this->formDir = $jsondir;
            $this->updateFormDir();
        }
    }

    /**
     * gọi hàm sự kiện
     * @param string $event
     * @param array ...$params
     */
    public function callFormEvent($event = null, ...$params)
    {
        if ($event && method_exists($this, $event))
            return call_user_func_array([$this, $event], $params);
        return false;
    }

    /**
     * trả về filemanager đã dược set dường dẩn thu mục chứa form
     * @return Filemanager 
     */
    public function getJsonManager()
    {
        return $this->filemanager->setDir($this->realFormDir);
    }

    /**
     * lấy dữ liệu form
     * @param Arr $config
     * 
     */
    public function getFormData(Arr $config)
    {
        // nếu sử dụng flash mode
        if ($this->flashMode) {
            $file = $this->modulePath . '/' . ($config->file ? $config->file : 'form');
            $data = $this->getJsonFormInputs($file);
        } else {
            // sử dụng form json
            $json = null;
            // duoc set trong content
            if ($config->input_type == 'json' && ($config->file || $config->json)) {
                if ($config->file) {
                    $json = $config->file;
                } else {
                    $json = $config->json;
                }
            } else {
                // nếu ko dc set thi dung mac dinh
                $json = $this->getFormJson($config->action);
            }
            $json = $this->formDir . '/' . $json;
            $jscfg = $config->json_config ? $this->formDir . '/' . $config->json_config : ($json ? $json . '.config' : $this->formDir . '/' . $this->getFormConfigJson($config->action));
            $data = $this->getJsonFormInputs($json, $jscfg);
        }
        return $data;
    }






    /**
     * kiểm tra xem có full thong tin form trong một file hay không
     * @param array $args
     * 
     * @return array
     */
    public function checkFullFormModule(array $args = [])
    {
        $data = [
            'form_inputs' => [],
            'layout_type' => 'single',
            'form_groups' => [],
            'form_assets' => [],

        ];

        if (array_key_exists('@inputs', $args)) {
            $data['form_inputs'] = $this->parseInputArr($args['@inputs'], $this->module);
            if (array_key_exists('@config', $args)) {
                $data = array_merge($data, $this->getConfigDataArray($args['@config']));
            }
            if (array_key_exists('@assets', $args)) {
                $data['form_assets'] = is_array($args['@assets']) ? $args['@assets'] : [];
            }
            return $data;
        } elseif (array_key_exists('inputs', $args) && (($t = count($args)) == 1 || $hasCf = array_key_exists('config', $args))) {
            $data['form_inputs'] = $this->parseInputArr($args['inputs'], $this->module);
            $data['form_assets'] = array_key_exists('assets', $args) && is_array($args['assets']) ? $args['assets'] : [];
            if ($t > 1 && $hasCf) {
                $data = array_merge($data, $this->getConfigDataArray($args['config']));
            }
            return $data;
        }
        return [];
    }


    /**
     * lấy thông tin config form
     * @param array $config
     * @return array
     */
    public function getConfigDataArray($config = [])
    {
        $layout_type = 'single';
        $form_groups = [];
        $array_config = [];

        $config = new Arr($config);
        $this->hasConfigFile = true;
        // layout co trong danh sách
        if ($config->layout_type && in_array($clt = strtolower($config->layout_type), ['single', 'columns', 'column', 'tabs', 'tab'])) {
            $layout_type = $clt;
            // nếu la column
            if (in_array($clt, ['column', 'columns'])) {
                $layout_type = 'column';
                // nếu là array
                if (is_array($config->custom_form_groups)) {
                    $form_groups = $config->custom_form_groups;
                } elseif (is_array($config->form_groups)) {
                    $form_groups = $config->form_groups;
                }
            }
        }
        $config->remove('layout_type', 'form_groups');
        $array_config = $config->all();
        return array_merge($array_config, compact('form_groups', 'layout_type'));
    }





    /**
     * lấy thông tinm form
     * @return array
     */
    public function getJsonFormInputs($filename, $configfile = null)
    {
        $data = [
            'form_inputs' => [],
            'layout_type' => 'single',
            'form_groups' => []
        ];
        // nếu có thông tin input
        if ($inputs = $this->getJsonData($filename)) {
            if ($form_data = $this->checkFullFormModule($inputs)) {
                return $form_data;
            }
            // chuẩn hóa thong tin input để generate ra view
            $data['form_inputs'] = $this->parseInputArr($inputs, $this->module);
            $cfgfile = $configfile ? $configfile : $filename . '.config';
            // lấy thông tin config
            $data = array_merge($data, $this->getConfigDataArray($this->getJsonData($cfgfile, true)));
        }



        return $data;
    }


    /**
     * lấy thông tin input, layout type, column
     * @param string $filename
     * 
     * @return array
     */
    public function getStorageFormInputs($filename, $configfile = null)
    {
        $data = [
            'form_inputs' => [],
            'layout_type' => 'single',
            'form_groups' => []
        ];
        if ($inputs = $this->getStorageData($filename)) {
            if ($form_data = $this->checkFullFormModule($inputs)) {
                return $form_data;
            }
            // chuẩn hóa thong tin input để generate ra view
            $data['form_inputs'] = $this->parseInputArr($inputs, $filename);
            $cfgfile = $configfile ? $configfile : $filename . '.config';
            $data = array_merge($data, $this->getConfigDataArray($this->getStorageData($cfgfile)));
        }
        return $data;
    }



    /**
     * hiển thị crud form
     * @param Request $request
     * @param array $config
     * @param array|object $data
     * @param array $attrs
     * @param array $vars
     * 
     * @return View
     */
    public function getCrudForm($request, array $config = [], $data = null, array $attrs = [], array $vars = [])
    {

        // doi tuong noi dung forn
        $c = new Arr($config);
        $a = new Arr($attrs);
        $v = new Arr($vars);
        // can thiep vao cac thong so config
        $this->callFormEvent('prepareGetCrudForm', $request, $c, $a, $v);
        $action = ucfirst($c->type);
        if ($c->type == 'create') $this->callFormEvent('prepareGetCreateForm', $request, $c, $a, $v);
        elseif ($c->type == 'update') {


            $this->activeMenu($this->moduleMenuKey . '.list');
            $this->callFormEvent('prepareGetUpdateForm', $request, $c, $a, $v);
        }

        extract($this->getFormConfigData($c, $a, $v, $data));
        // dd($form_inputs);
        // 


        $fg = new Arr($form_config);
        $fa = new Arr($form_attrs);
        $fd = new Arr($form_data);
        $fi = new Arr($form_inputs);


        // goi ham su kien
        $this->callFormEvent('beforeGetCrudForm', $request, $fg, $fi, $fd, $fa);
        if ($c->type == 'create') $this->callFormEvent('beforeGetCreateForm', $request, $fg, $fi, $fd, $fa);
        elseif ($c->type == 'update') $this->callFormEvent('beforeGetUpdateForm', $request, $fg, $fi, $fd, $fa);

        $form_config = $fg->all();
        $form_inputs = $fi->all();
        $form_data = $fd->all();
        $form_attrs = $fa->all();

        $data = array_merge($vars, compact('form_config', 'form_attrs', 'form_data', 'form_inputs'));
        return $this->view($blade, $data);
    }


    /**
     * hiển thị crud form
     * @param Request $request
     * @param array $config
     * @param array|object $data
     * @param array $attrs
     * @param array $vars
     * 
     * @return View
     */
    public function getForm($request, array $config = [], $data = null, array $attrs = [], array $vars = [])
    {

        // doi tuong noi dung forn
        $c = new Arr($config);
        $a = new Arr($attrs);
        $v = new Arr($vars);
        // can thiep vao cac thong so config
        $this->callFormEvent('prepareGetForm', $request, $c, $a, $v);


        extract($this->getFormConfigData($c, $a, $v, $data));


        // 
        $fg = new Arr($form_config);
        $fa = new Arr($form_attrs);
        $fd = new Arr($form_data);
        $fi = new Arr($form_inputs);


        // goi ham su kien
        $this->callFormEvent('beforeGetForm', $request, $fg, $fi, $fd, $fa);

        $form_config = $fg->all();
        $form_inputs = $fi->all();
        $form_data = $fd->all();
        $form_attrs = $fa->all();

        return $this->view($blade, array_merge(
            $vars,
            compact(
                'form_config',
                'form_attrs',
                'form_data',
                'form_inputs'
            )
        ));
    }

    /**
     * lấy dữ liệu cấu hình form
     */
    public function getFormConfigData($c, $a, $v, $data)
    {
        $attrs = $a->all();
        $vars = $v->all();
        $action = $c->type ? $c->type : 'free';
        $nsp = Str::slug(str_replace('.', '-', $this->module), '-');
        // thuộc tính form mặc định
        $form_attrs = array_merge([
            'method' => 'post', // phương thức của form
            // 'action' => $this->getFormSubmitUrl($action),
            'id' => $nsp . '-' . $action,
            'class' => $nsp . '-' . $action,
        ], $attrs);

        // nếu không được thiết lập action thì sẽ được set mặc định
        if (!$a->action) {
            $form_attrs['action'] = $this->getFormSubmitUrl($action);
        }
        // form_inputa
        $form_inputs = [];
        // form layout
        $layout_type = null;
        // chia cột và danh sach input theo cot
        $form_groups = [];

        // mang config
        $array_config = [];
        // dd($c);
        // nếu danh sach input là array
        if ($c->input_type == 'list' && is_array($c->inputs)) {
            $form_inputs = $this->parseInputArr($c->inputs, $this->module);
            if ($c->form_config) {
                $cf = new Arr($c->form_config);

                if ($cf->layout_type && in_array($lt = $cf->layout_type, ['single', 'column', 'columns'])) {
                    $layout_type = $lt;
                    if (in_array($lt, ['column', 'columns'])) {
                        $layout_type = 'column';
                        if (is_array($cf->form_groups)) {
                            $form_groups = $cf->form_groups;
                        }
                    }
                }
                $cf->remove('layout_type', 'form_groups');
                $array_config = $cf->all();
            }
        } else {
            // lay thong tin danh sach input tu file json
            $cfg = $this->getFormData($c);
            if ($cfg['form_inputs']) {
                $form_inputs = $cfg['form_inputs'];
                if (!$layout_type && $cfg['layout_type']) {
                    $layout_type = $cfg['layout_type'];
                    if (!$form_groups) {
                        if (isset($cfg['custom_form_groups'])) {
                            $form_groups = $cfg['custom_form_groups'];
                        } elseif ($cfg['form_groups']) {
                            $form_groups = $cfg['form_groups'];
                        }
                    }
                }
                unset($cfg['form_inputs'], $cfg['layout_type'], $cfg['form_groups']);
                $array_config = $cfg;
            }
        }


        // js va css
        $js = [];
        $css = [];

        // duoc set trong con troller
        if ($this->crudJS) {
            if (is_array($this->crudJS)) {
                $js = $this->crudJS;
            } else {
                $js[] = $this->crudJS;
            }
        }

        if ($this->crudCSS) {
            if (is_array($this->crudCSS)) {
                $css = $this->crudCSS;
            } else {
                $css[] = $this->crudCSS;
            }
        }

        if (isset($array_config['assets']) && is_array($array_config['assets'])) {
            $ac = $array_config['assets'];
            if (isset($ac['js']) && $ac['js']) {
                if (is_array($ac['js'])) {
                    $js = array_merge($js, $ac['js']);
                } else {
                    $js[] = $ac['js'];
                }
            }
            if (isset($ac['css']) && $ac['css']) {
                if (is_array($ac['css'])) {
                    $css = array_merge($css, $ac['css']);
                } else {
                    $css[] = $ac['css'];
                }
            }
        }
        if (isset($array_config['form_assets']) && is_array($array_config['form_assets'])) {
            $ac = $array_config['form_assets'];
            if (isset($ac['js']) && $ac['js']) {
                if (is_array($ac['js'])) {
                    $js = array_merge($js, $ac['js']);
                } else {
                    $js[] = $ac['js'];
                }
            }
            if (isset($ac['css']) && $ac['css']) {
                if (is_array($ac['css'])) {
                    $css = array_merge($css, $ac['css']);
                } else {
                    $css[] = $ac['css'];
                }
            }
        }
        // duoc set trong khi goi ham
        if ($c->js) {
            if (is_array($c->js)) {
                $js = array_merge($js, $c->js);
            } else {
                $js[] = $c->js;
            }
        }

        if ($c->css) {
            if (is_array($c->css)) {
                $css = array_merge($js, $c->css);
            } else {
                $css[] = $c->jcss;
            }
        }

        // xoa cac
        $c->remove('input_type', 'inputs', 'file', 'json', 'layout', 'columns', 'data', 'js', 'css', 'form_config');

        $form_config = array_merge([
            'title' => $this->getFormTitle($action),
            'can_edit_form_config' => ($this->hasConfigFile && !get_owner_id()),
            'save_button_text' => $this->getSaveButtonText($action),
            'cancel_button_text' => $this->getCancelButtonText(),
            'cancel_button_url' => $this->getCancelButtonUrl(),
            'components' => [], // danh sach blade se duoc include bo xung tu thu muc _components
            'templates' => [], // danh sach blade se duoc include bo xung tu thu muc _templates
            'includes' => [], // danh sach blade se duoc include bo xung
            'js_vars' => [],
            'js' => $js,
            'css' => $css
        ], $array_config, $c->all(), compact('layout_type', 'form_groups'));

        if ($this->hasConfigFile && !get_owner_id()) {
            if (Router::getByName($this->routeNamePrefix . $this->module . '.form.config.edit')) {
                $form_config['edit_form_config_url'] = route($this->routeNamePrefix . $this->module . '.form.config.edit');
            } else {
                $form_config['can_edit_form_config_url'] = false;
            }
        }


        // file view
        if ($c->view) {
            $blade = $c->view;
        } else {
            $blade = $this->getFormBlade($action);
        }

        // noi voi mang form data

        $form_data = [];

        // neu la mang
        if (is_array($data)) {
            $form_data = $data;
        }
        // nếu là object
        elseif (is_object($data)) {

            if (method_exists($data, 'toFormData')) {
                $form_data = $data->toFormData();
            }
            // neu là model va ho tro ham toArray
            elseif (method_exists($data, 'toArray')) {
                $form_data = $data->toArray();
            }
            // đưa về mảng
            elseif (is_array($fdata = Arr::parse($data))) {
                $form_data = $fdata;
            }
        }
        $return = compact(
            'form_config',
            'js',
            'css',
            'array_config',
            'form_groups',
            'layout_type',
            'form_inputs',
            'form_attrs',
            'vars',
            'attrs',
            'action',
            'blade',
            'form_data'
        );
        return $return;
    }



    /**
     * hiển thị crud form
     * @param array $config
     * @return View
     */
    public function getViewConfigForm(array $config = [])
    {

        // doi tuong noi dung forn
        $c = new Arr($config);

        $action = $c->type ? $c->type : 'create';



        $form_config = $this->getFormData($c);
        $form_inputs = $form_config['form_inputs'];
        unset($form_config['form_inputs']);

        // file view
        if ($c->view) {
            $blade = $c->view;
        } else {
            $blade = 'forms._setting';
        }
        // dd(compact('form_config', 'form_inputs'));

        if ($c->submit_url) {
            $submit_url = $c->submit_url;
        } else {
            $submit_url = $this->getRouteUrl($this->moduleRoute . '.form.config.save');
        }

        return $this->view($blade, compact('form_config', 'form_inputs', 'submit_url'));
    }

    /**
     * get config form
     * @param Request $request
     * @param string $action
     * 
     * @return View
     */
    public function getConfigForm(Request $request, $action = null)
    {
        $config = new Arr();
        if (method_exists($this, 'beforeGetConfigData')) {
            $this->beforeGetConfigData($request, $config);
        }
        return $this->getViewConfigForm($config->all());
    }



    public function saveConfigForm(Request $request)
    {
        extract($this->apiDefaultData);
        $json = $this->getFormJson($request->action);
        $jscfg = $this->getConfigFilename($json, $request->action);
        $fileMng = $this->getJsonManager();
        if ($fileMng->exists($jscfg, 'json') && $config = $fileMng->getJson($jscfg)) {
            $config['custom_form_groups'] = $request->form_groups;
        } else {
            $config = [
                'title' => $this->moduleName,
                'layout_type' => 'column',
                'custom_form_groups' => $request->form_groups
            ];
        }
        if ($file = $fileMng->saveJson($jscfg, $config)) {
            $status = true;
            $message = 'Cập nhật cấu hình form thành công';
        } else {
            $message = 'Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát';
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    /**
     * hiển thị crud form
     */
    public function getConfigFilename($json = null, $action = null)
    {

        $jscfg = $json ? $json . '.config' : $this->getFormConfigJson($action);
        return $jscfg;
    }


    /**
     * lấy thông tin form từ json
     * @param string $filename
     *
     * @return array
     */
    public function getJsonInputs($filename = null)
    {
        if (!$filename) {
            $filename = 'test';
        }

        $this->filemanager->setDir($this->realFormDir);
        return $this->filemanager->getJson($filename);
    }

    /**
     * lấy thông tin form từ json
     * @param string $filename
     *
     * @return array
     */
    public function getFormJsonConfig($filename = null)
    {
        if (!$filename) {
            $filename = 'test';
        }

        $this->filemanager->setDir($this->realFormDir);
        return $this->filemanager->getJson($filename);
    }


    /**
     * chuẩn hóa input
     * @param array
     * @param string
     * @return array
     */
    public final function parseInputArr($inputs, $prefix = null)
    {
        if (!is_array($inputs) || !count($inputs)) return [];
        $data = [];
        $p = str_slug($prefix ? $prefix : $this->module, '_');
        foreach ($inputs as $name => $props) {
            $attrs = new Arr($props);
            // nếu chưa được set tên thì lấy key làm tên
            if (!$attrs->name) {
                if (is_numeric($name)) $attrs->name = $p . "[$name]";
                else $attrs->name = $name;
            }
            if (!$attrs->text) {
                $attrs->text = $attrs->name;
            }
            // neu chua co nhan
            if (!$attrs->label) {
                $attrs->label = $attrs->text;
            }

            // lam gi do

            $data[$name] = $attrs->all();
        }
        return $data;
    }

    /**
     * lấy tiêu đề form
     * @param string $action vi du: create / update
     * @return string
     */
    public final function getFormTitle($action = 'create')
    {
        // nếu không phải các form cho trước thì trả về tên module
        if (!in_array($act = strtolower($action), $this->crudActions)) {
            if (isset($this->formTitle) && $this->formTitle) return $this->formTitle;
            return $this->moduleName;
        }

        // nếu đã được set title thì trả về luôn
        if ($this->{$act . 'FormTitle'}) {
            return $this->{$act . 'FormTitle'};
        }

        // mảng title theo tên moduke
        $titles = [
            'create' => 'Thêm ' . $this->moduleName . ' mới',
            'update' => 'Cập nhật thông tin ' . $this->moduleName,
        ];
        return $titles[$act];
        return vnucfirst(vntolower($titles[$act]));
    }

    /**
     * lấy dường dẫn để submit form
     * @param string $action vi du: create / update
     * @return string
     */
    public final function getFormSubmitUrl($action = 'create')
    {
        // nếu không phải các form cho trước thì trả về rỗng
        if (!in_array($act = strtolower($action), $this->crudActions)) {
            if ($action == 'free') {
                if ($this->submitUrl) {
                    return $this->submitUrl;
                }

                // nếu được set route
                if ($this->submitRoute) {
                    return route($this->submitRoute, $this->submitRouteParams);
                }
            }
            return '';
        }

        // nếu đã được set url thì trả về luôn
        if ($this->{$act . 'SubmitUrl'}) {
            return $this->{$act . 'SubmitUrl'};
        }

        // nếu được set route
        if ($this->{$act . 'SubmitRoute'}) {
            return route($this->{$act . 'SubmitRoute'}, $this->{$act . 'SubmitRouteParams'});
        }

        // nếu route mặc định được set
        if ($route = $this->getModuleRoute('save')) {
            return $route;
        }

        // nếu không có gì trả vè rỗng hahaha
        if ($this->submitRoute && Router::checkName($this->submitRoute)) {
            $params = [];
            if (is_array($this->submitRouteParams)) {
                $params = $this->submitRouteParams;
            }
            return route($this->submitRoute, $params);
        }
        return '';
    }

    /**
     * lấy blade path
     * @param string $action vi du: create / update
     * @return string
     */
    public final function getFormBlade($action = 'create')
    {
        // nếu không phải các form cho trước thì trả về blade mặc định
        if (!in_array($act = strtolower($action), $this->crudActions)) {
            if ($this->formView) return $this->formView;
            return $this->formLayout;
        }

        // nếu đã được set json thì trả về luôn
        if ($this->{$act . 'FormView'}) {
            return $this->{$act . 'FormView'};
        }

        // nếu ko có gì thì trả về form master
        return $this->formLayout;
    }

    /**
     * lấy text để chèn vào nút lưu dữ liệu
     * @param string $action vi du: create / update
     * @return string
     */
    public final function getSaveButtonText($action = 'create')
    {
        // nếu không phải các form cho trước thì trả về blade mặc định
        if (!in_array($act = strtolower($action), $this->crudActions)) {
            if ($this->btnSubmitEext) return $this->btnSubmitEext;
            return 'Lưu';
        }

        // nếu đã được set title thì trả về luôn
        if ($this->{$act . 'ButtonText'}) {
            return $this->{$act . 'ButtonText'};
        }

        // mảng title theo tên moduke
        $titles = [
            'create' => 'Thêm mới',
            'update' => 'Cập nhật',
        ];
        return $titles[$act];
    }

    /**
     * lấy text để chèn vào nút hủy bỏ chỉnh sửa hoặc tạo mới
     * @return string
     */
    public final function getCancelButtonText()
    {
        return $this->cancelButtonText ? $this->cancelButtonText : 'Hủy bỏ';
    }

    /**
     * lấy đừng dẫn cho nút hủy chỉnh sửa
     * @return string
     */
    public final function getCancelButtonUrl()
    {
        // nếu không phải các form cho trước thì trả về blade mặc định
        $back = request()->back;



        return $back ? $back : ($this->cancelButtonUrl ? $this->cancelButtonUrl : (
                ($route = $this->getModuleRoute('list')) ? $route : 'javascript:history.back();'));
    }

    /**
     * lấy json path
     * @param string $action vi du: create / update
     * @return string
     */
    public final function getFormJson($action = 'create')
    {
        // nếu không phải các form cho trước thì trả về file test
        if (!in_array($act = strtolower($action), $this->crudActions)) {
            return $this->module;
        }

        // nếu đã được set json thì trả về luôn
        if ($this->{$act . 'FormJson'}) {
            return $this->{$act . 'FormJson'};
        }

        // Nếu không có gì trả về module
        return $this->module;
    }


    /**
     * lấy config json path
     * @param string $action vi du: create / update
     * @return string
     */
    public final function getFormConfigJson($action = 'create')
    {
        // nếu không phải các form cho trước thì trả về file test
        if (!in_array($act = strtolower($action), $this->crudActions)) {
            return $this->module . '.config';
        }

        // nếu đã được set json thì trả về luôn
        if ($this->{$act . 'FormConfigJson'}) {
            return $this->{$act . 'FormConfigJson'};
        }

        // Nếu không có gì trả về module
        return $this->module . '.config';
    }
}
