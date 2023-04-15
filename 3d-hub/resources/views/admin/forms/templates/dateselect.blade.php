<?php
use Crazy\Helpers\Arr;
$input->type = "dateselect";
$input->prepareCrazyInput();

$inpName = $input->name;

$list = ['day', 'month', 'year'];
$data = [];
$lang = 'vi';
$current = date('Y');
$inputParams = new Arr($input->hiddenData('params'));
$defaultParams = [
    'year' => ($yearParams = $input->hiddenData('year-params')) ? $yearParams : ['vi', $current+5, -50],
    'month' => ['vi'],
    'day' => ['vi'],
];
$inputValues = new Arr($input->defVal());
foreach ($list as $key) {
    $f = 'get_'.$key.'_options';
    $params = is_array($p = $inputParams->get($key))?$p:$defaultParams[$key];
    $d = [
        'type' => 'crazyselect',
        'name' => $inpName ? $inpName. '['.$key.']' : $key,
        'id' => $inpName ? $inpName. '-'.$key: $key,
        'data' => call_user_func_array($f, $params),
        '@change' => $input->data('on-'.$key.'-change')??$input->data('on-change'),
        '@select-type' => 'static',
        '@disable-search' => $key == 'year'?'':'true'
    ];
    $old = old($inpName ? $inpName. '.'.$key : $key, $inputValues->get($key));
    if(!is_null($old)){
        $d['value'] = $old;
    }
    $data[$key] = $__env->make('admin.forms.templates.crazyselect', [
        'input' => html_input($d)
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
}
$listDate = $list;
if($sortOrder = $input->hiddenData('sort-order')){
    if(!is_array($sortOrder)){
        $sortOrder = array_map('trim', explode(',', $sortOrder));
    }
    if(array_contains($sortOrder, $list)){
        $a = [];
        foreach ($sortOrder as $key) {
            if(in_array($key, $list)){
                $a[] = $key;
            }
        }
        $listDate = $a;
    }
}

$input->tagName = 'div';
$input->type = null;
$input->name = null;
$input->value = null;
$input->addClass('date-select');
$input->removeClass('form-control m-input');
?>

<div {!! $input->attrsToStr() !!}>
    @foreach ($listDate as $key)
        <div class="date-select-item item-{{$key}}">
            {!! $data[$key] !!}
        </div>
    @endforeach
</div>

