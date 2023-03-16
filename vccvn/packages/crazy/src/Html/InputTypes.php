<?php
namespace Crazy\Html;
use Crazy\Laravel\Router;
use Crazy\Files\Filemanager;
use Crazy\Helpers\Arr;

trait InputTypes{
    /**
     * @var boolean
     */
    protected $isPrepare = false;


    /**
     * input-templaste
     *
     * @var array
     */
    protected static $inputTemplates = [
        'switch',  'checklist', 'options', 'crazyslug', 'daterange', 'touchspin', 'cubeselect',
        'deepselect', 'crazyselect', 'crazytag', 'multiselect', 'select2', 'cropit', 'crazyprop','specification',
        'tinymce','gallery', 'attribute','product', 'variant-attribute', 'colorpicker', 'area',
        'dateselect','media',
        'inputgroup', 'seo'

    ];
    protected $d = null;

    /**
     * @var array $typeList
     */
    protected $crazyInputMethods = [
        'crazyselect'            => 'prepareCrazySelectData',
        'dateselect'             => 'prepareDateSelectData',
        'crazytag'               => 'prepareCrazyTagData',
        'crazyslug'              => 'prepareCrazySlugData',
        'crazyprop'              => 'prepareCrazyPropData',
        'specification'          => 'prepareCrazySpecificationData',
        'crazyswitch'            => 'prepareCrazySwitchProp',
        'inputgallery'           => 'prepareCrazyGalleryData',
        'galleryinput'           => 'prepareCrazyGalleryData',
        'crazygallery'           => 'prepareCrazyGalleryData',
        'gallery'                => 'prepareCrazyGalleryData',

        'inputmedia'             => 'prepareCrazyMediaData',
        'mediainput'             => 'prepareCrazyMediaData',
        'crazymedia'             => 'prepareCrazyMediaData',
        'media'                  => 'prepareCrazyMediaData',

        'colorpicker'            => 'prepareCrazyColorPicker',
        'iconpicker'             => 'prepareCrazyIconPicker',
        'attribute'              => 'prepareCrazyAttributeData',
        'variant-attribute'      => 'prepareCrazyVariantAttributeData',
        'product'                => 'prepareCrazyProductData',
        'checkmultilevel'        => 'prepareCheckMultiLevelData',
        'area'                   => 'prepareAreaData',
        'checklist'              => 'prepareChecklistData',
        'colorselect'            => 'prepareColorSelectData',
        'inputgroup'             => 'prepareInputGroup',
        'package'                => 'preparePackage',
        'frontend'               => 'prepareFrontendData',

        'seo'                    => 'prepareSEOData',
    ];

    protected $typeTemplates = [
        'switch'             => 'checkbox',
        'date'               => 'date',
        'time'               => 'time',
        'crazyslug'          => 'text',
        'daterange'          => 'date',
        'touchspin'          => 'number',
        'deepselect'         => 'select',
        'crazyselect'        => 'select',
        'dateselect'         => 'date',
        'crazytag'           => 'select',
        'multiselect'        => 'select',
        'select2'            => 'select',
        'cropit'             => 'file',
        'crazyprop'          => 'textarea',
        'specification'      => 'textarea',
        'tinymce'            => 'textarea',
        'gallery'            => 'file',
        'media'              => 'file',
        'colorpicker'        => 'text',
        'colorselect'        => 'radio'
    ];

    public function checkDefaultValueDynamic()
    {
        if(!is_array($db = $this->hiddenData('defaultBy'))) return;
        $b = new Arr($db);
        $cf = null;
        if($a = $b->get('action')){
            $cf = $a;
        }
        elseif($c = $b->get('call')){
            $cf = $c;
        }elseif($f = $b->get('func')){
            $cf = $f;

        }
        $vl = null;

        if(is_callable($cf)){

            if($p = $b->get('params')){
                // dd($p);
                $params = [];
                if(!is_array($p)) $p = [$p];


                foreach ($p as $param) {


                    if(is_string($param)){

                        $params[] = $this->getParamFromString($param);
                    }elseif (is_array($param)) {
                        $arg = [];
                        foreach ($param as $kn => $par) {
                            $arg[$kn] = $this->getParamFromString($par);
                        }
                        $params[] = $arg;
                    }else{
                        $params[] = $param;
                    }
                }
                $vl = call_user_func_array($cf,$params);
            }else{
                $vl = call_user_func($cf);
            }
        }
        $this->_data['default'] = $vl;
        return $vl;
    }

    /**
     * chuan bị cho cac the loai crazy input
     * @return void
     */
    public function prepareCrazyInput()
    {
        if($this->isPrepare) return false;
        if(array_key_exists($this->type, static::$inputTemplates)) $this->template = $this->type;
        $this->d = new Arr($this->hiddenData());
        // if(($this->defVal() == null) && $v = request($this->name)) $this->value = old($this->name, $v);
        if(array_key_exists($this->type, $this->crazyInputMethods)){
            call_user_func_array([$this, $this->crazyInputMethods[$this->type]], []);
            $this->isPrepare = true;
        }
        else{
            $this->parseTypeTemplate();
        }
    }

    public function parseTypeTemplate()
    {
        if(array_key_exists($this->type, $this->typeTemplates)){
            $this->template = $this->type;
            $this->isPrepare = true;
        }
    }

    /**
     * convert sang crazy select
     *
     */
    public function prepareCrazySelectData()
    {

        $this->template = 'crazyselect';
        $this->id = $this->id?$this->id:$this->name;
        $this->data('id', $this->id);
        // nếu có search url trực tiếp
        $this->parseRouteUrl('search');
        if($sf = $this->d->get('search-field')){
            $this->data('search-field', $sf);
        }else{
            $this->data('search-field', 'search');
        }
        $this->parseDataEvent('change');

        if($sp = $this->d->get('search-params')){
            $this->data('search-params', $sp);
        }


        if($this->parseRouteUrl('add')){
            if($af = $this->d->get('add-field')){
                $this->data('add-field', $af);
            }else{
                $this->data('add-field', 'name');
            }

            if($add_params = $this->d->get('add-params')){
                $arr = [];
                if($params = $this->parseInputParams($add_params)){
                    $this->data('add-params', $params);
                }
            }
        }
        if(in_array(strtolower($type = $this->d->get('select-type')), ['dynamic','search'])){
            $this->data('select-type', $type);
            $this->data('advance-click', $this->d->get('advance-click'));
            if($at = $this->d->get('advance-text')){
                $this->data('advance-text', $at);
            }else{
                $this->data('advance-text', 'Thêm');
            }

        }else{
            $this->data('select-type', 'static');
        }

        if(in_array(strtolower($typ = $this->d->get('label-type')), ['header','value','label'])){
            $this->data('label-type', $typ);
        }else{
            $this->data('label-type', 'label');
        }

        if($cc = $this->d->get('confirm-change')){
            $this->data('confirm-change', $cc);
        }
        if($dis = $this->d->get('disable-search')){
            $this->data('disable-search', 'true');
        }

    }




    public function prepareCheckMultiLevelData()
    {

        $this->template = 'checkmultilevel';
        $this->data('id', $this->id);
        $this->parseDataEvent('check');

        if(in_array(strtolower($typ = $this->d->get('label-type')), ['header','value','label'])){
            $this->data('label-type', $typ);
        }else{
            $this->data('label-type', 'label');
        }

        if($cc = $this->d->get('confirm-change')){
            $this->data('confirm-change', $cc);
        }

    }

    public function prepareColorSelectData()
    {

        $this->template = 'colorselect';
        $this->data('id', $this->id);
        $this->parseDataEvent('check');

        if(!$this->data){
            if($colors = $this->hiddenData('colors')){
                $this->data = $colors;
            }
        }

    }

    public function prepareDateSelectData()
    {

        $this->template = 'dateselect';
        $this->data('id', $this->id);
        $this->parseDataEvent('change');
        $this->parseDataEvent('day-change');
        $this->parseDataEvent('year-change');
        $this->parseDataEvent('month-change');
        if($sortType = $this->d->get('sort-type')){
            $st = strtolower($sortType) == 'en' ? 'en' : 'vi';
            $this->data('sort-type', $st);
        }
        if($dis = $this->d->get('disable-search')){
            $this->data('disable-search', 'true');
        }

        if($val = $this->defVal()){
            if(is_string($val)){
                $this->val(strtodate($val));
            }
        }


    }


    public function prepareAreaData()
    {

        $this->template = 'area';
        $this->data('id', $this->id);
    }

    public function prepareChecklistData()
    {

        $this->template = 'checklist';
        $this->data('id', $this->id);
    }



    /**
     * convert sang crazy tag
     *
     */
    public function prepareCrazyTagData()
    {
        $this->data('id', $this->id);
        $this->data('name', $this->name);
        $this->addClass('crazy-tag');
        // nếu có search url trực tiếp
        $this->parseRouteUrl('search');

        if($sf = $this->d->get('search-field')){
            $this->data('search-field', $sf);
        }else{
            $this->data('search-field', 'search');
        }
        if($searchParams = $this->d->get('search-params')){
            $this->data('search-params', $searchParams);
        }

        $this->parseDataEvent('add');
        $this->parseDataEvent('remove');
        $this->parseDataEvent('create');




        if($this->parseRouteUrl('create')){
            if($af = $this->d->get('create-field')){
                $this->data('create-field', $af);
            }else{
                $this->data('create-field', 'name');
            }

            if($create_params = $this->d->get('create-params')){
                $arr = [];
                if($params = $this->parseInputParams($create_params)){
                    $this->data('create-params', $params);
                }
            }
        }

        if(in_array(strtolower($type = $this->d->get('type')), ['dynamic','search', 'default'])){
            $this->data('type', $type);
        }else{
            $this->data('type', 'default');
        }

        $this->data('value-key', $this->d->get('value-key')??'id');
        $this->data('text-key', $this->d->get('text-key')??'name');

        $this->addClass($this->data('type'));
    }



    /**
     * convert sang crazy tag
     *
     */
    public function prepareCrazyAttributeData()
    {
        $this->data('id', str_slug($this->id??$this->name, '-'));
        $this->data('name', $this->name);
        $this->addClass('crazy-attribute');
        $this->parseRouteUrl('load');
        $this->data('load-param-selectors', $this->d->get('load-param-selectors'));

        $this->parseRouteUrl('add-value');
        $this->parseRouteUrl('detail');


        $this->parseDataEvent('add');
        $this->parseDataEvent('remove');
    }
    /**
     * convert sang crazy tag
     *
     */
    public function prepareCrazyVariantAttributeData()
    {
        $this->data('id', str_slug($this->id??$this->name, '-'));
        $this->data('name', $this->name);
        $this->addClass('crazy-attribute');
        $this->parseRouteUrl('load');
        $this->data('load-param-selectors', $this->d->get('load-param-selectors'));

        $this->parseRouteUrl('add-value');
        $this->parseRouteUrl('detail');

        $this->parseDataEvent('add');
        $this->parseDataEvent('remove');
    }



    /**
     * convert sang crazy tag
     *
     */
    public function prepareCrazyProductData()
    {
        $this->data('id', str_slug($this->id??$this->name, '-'));
        $this->data('name', $this->name);
        $this->addClass('crazy-products');

        $this->parseRouteUrl('add');
        $this->data('add-param-selectors', $this->d->get('add-param-selectors'));

        $this->parseDataEvent('add');
        $this->parseDataEvent('remove');
    }





    /**
     * convert sang crazy tag
     *
     */
    public function prepareCrazyPropData()
    {
        $this->data('id', $this->id);
        $this->data('name', $this->name);
        $this->addClass('crazy-prop');
    }
    /**
     * convert sang crazy tag
     *
     */
    public function prepareCrazySpecificationData()
    {
        $this->data('id', $this->id);
        $this->data('name', $this->name);
        $this->addClass('crazy-specification');
    }
    /**
     * convert sang crazy tag
     *
     */
    public function prepareCrazyGalleryData()
    {
        $this->data('id', $this->id);
        $this->data('name', $this->name);
        $this->addClass('crazy-gallery input-gallery');
    }

    /**
     * convert sang crazy tag
     *
     */
    public function prepareCrazyMediaData()
    {
        $this->data('id', $this->id);
        $this->template = 'media';
        $this->data('name', $this->name);
        $this->addClass('crazy-library input-library');
    }



    /**
     * convert sang crazy tag
     *
     */
    public function prepareCrazySlugData()
    {

        $this->data('id', $this->id);
        $this->data('name', $this->name);
        $this->addClass('crazy-slug');
        $this->data('check-field', $this->d->get('check-field')??'custom_slug');

        $this->parseDataEvent('check');
        $this->data('extension', $this->d->get('extension'));
        $this->data('slug-field', $this->d->get('slug-field')??'slug');
        $this->data('source-id', $this->d->get('source-id'));
        $this->data('ajax-param-selectors', $this->d->get('ajax-param-selectors'));
        $this->data('ajax-get-name', $this->d->get('ajax-get-name'));
        $this->data('ajax-check-name', $this->d->get('ajax-check-name'));
        foreach (['get-slug', 'check-slug'] as $key) {
            if($this->parseRouteUrl($key)){
                if($slug_params = $this->d->get($key.'-params')){
                    if($params = $this->parseInputParams($slug_params)){
                        $this->data($key.'-params',$params);
                    }
                }
            }
        }
    }


    /**
     * convert sang crazy tag
     *
     */
    public function prepareCrazySwitchProp()
    {

        $this->data('id', str_slug($this->id??$this->name, '-'));
        $this->data('name', $this->name);
        $this->addClass('crazy-switch');
        $this->parseDataEvent('check');
        $this->parseDataEvent('uncheck');
        $this->parseDataEvent('change');
    }


    public function prepareCrazyColorPicker()
    {
        $this->template = 'colorpicker';
    }

    public function prepareCrazyIconPicker()
    {
        $this->template = 'iconpicker';
    }



    /**
     * fill route url
     * @param string $key
     * @param string
     */
    public function parseRouteUrl(string $key)
    {
        $url = null;

        // nếu có search url trực tiếp
        if($a = $this->d->get($key.'-url')){
            $url = $a;
        }
        // nếu dùng route
        elseif ($ar = $this->d->get($key.'-route')) {
            if(Router::getByName($ar)){
                if($arp = $this->d->get($key.'-route-params')){
                    if(is_array($arp)){
                        $url = route($ar, $arp);
                    }else{
                        $url = route($ar, $this->parseRouteParams($arp));
                    }
                }else{
                    $url = route($ar, $arp);
                }
            }
        }
        elseif ($get_url = $this->d->get('get-'.$key.'-url')) {
            if(is_callable($get_url)){
                if($gp = $this->d->get('get-'.$key.'-url-param')){
                    $url = $get_url($this->getInputDataFromString($gp));
                }elseif ($gps = $this->d->get('get-'.$key.'-url-params')) {
                    if($gpsx = $this->parseInputParams($gps)){
                        if(Arr::isNumericKeys($gpsx)){
                            $url = $get_url(...$gpsx);
                        }else{
                            $url = $get_url($gpsx);
                        }
                    }else{
                        $url = $get_url();
                    }
                }else{
                    $url = $get_url();
                }
            }
        }

        if($url){
            $this->data($key.'-url', $url);
        }
        return $url;
    }




    /**
     * them event data
     * @param string $key
     * @return mixed
     */
    public function parseDataEvent($key)
    {
        foreach ([$key, 'on'.ucfirst($key), 'on-'.$key, rtrim($key, 'e').'ed', $key.'-callback'] as $k) {
            if($c = $this->d->get($k)){
                $this->data('on-'.$key, $c);
                return true;
            }
        }
        return false;

    }





    /**
     * taich lấy param
     * @param mixed $raw
     * @return array
     */
    public function parseRouteParams($raw = null)
    {
        $data = [];
        if(is_array($raw)){
            $data = $raw;
        }elseif (is_callable($raw)) {
            $data = $raw();
        }elseif (in_array($s = substr($raw,0,1), ['@', ':'])) {
            if($s == '@' && $this->parent){
                $inp = substr($raw,1);
                $prop = null;
                if(count($ip = explode(':', $inp))==2){
                    $inp = $ip[0];
                    $prop = $ip[1];
                }
                if($this->parent->{$inp}){
                    if($prop) $val = $this->parent->{$inp}->{$prop};
                    else $val = $this->parent->{$inp}->defVal();
                    $data[$inp] = $val;
                }
            }elseif ($s==':') {
                $prop = substr($raw,1);
                $data[$prop] = $prop;
            }
        }

        return $data;
    }


    /**
     * taich lấy param
     * @param mixed $raw
     * @return array
     */
    public function parseInputParams($raw = null)
    {
        $data = [];
        if(is_array($raw)){
            foreach ($raw as $key => $value) {
                $data[$key] = $this->getInputDataFromString($value);
            }
        }elseif (is_callable($raw)) {
            $data = $raw();
        }elseif ($raw) {
            $data = $this->getInputDataFromString($raw);
        }
        return $data;
    }

    public function getInputDataFromString($raw)
    {
        if (in_array($s = substr($raw,0,1), ['#', ':', '@'])) {
            $nsp = substr($raw,1);
            if($s == '#' && $this->parent){
                $prop = null;
                $inp = $nsp;
                if(count($ip = explode(':', $nsp))==2){
                    $inp = $ip[0];
                    $prop = $ip[1];
                }
                if($this->parent->{$inp}){
                    if($prop) $val = $this->parent->{$inp}->{$prop};
                    else $val = $this->parent->{$inp}->defVal();
                    return $val;
                }
            }elseif ($s==':') {
                if($nsp == 'defval'){
                    $prop = $this->defVal();
                }
                else{
                    $prop = $this->{$nsp};
                }
                return $prop;
            }elseif(is_callable($nsp)){
                return $nsp();
            }
        }
        elseif(is_array($raw)){
            $data = [];
            foreach ($raw as $key => $value) {
                $data[$key] = $this->getInputDataFromString($value);
            }
            return $data;
        }

        return $raw;
    }

    public function prepareInputGroup()
    {
        # code...
    }


    public function prepareFrontendData()
    {
        $this->template = 'frontend';
    }
    public function preparePackage()
    {
        $this->template = 'package';
    }

    
    public function prepareSEOData()
    {
        $this->template = 'seo';
        
    }
}
