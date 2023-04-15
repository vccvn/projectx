<?php
// su dung thu vien
use Crazy\Helpers\Arr;
use Crazy\Html\HTML;
use Crazy\Html\Form;
use Crazy\Html\Input;
$cfg = new Arr(isset($config)?$config:[]);
$data = new Arr($data);
array_unshift($inputs,[
	'namespace' => 'hidden_id',
	'name' => 'id',
	'id' => 'input-hidden-id',
	'type' => 'hidden',
	'value' => $data->id
]);
$args = [
	'inputs' => $inputs,
	'data' => $data,
	'errors' => $errors
];

$input_options = ['className'=>'form-control m-input'];
$form = new Form($args, $input_options);
$form->query(['type' => ['radio', 'checkbox', 'crazyselect', 'file']])->map('removeClass', ['form-control', 'm-input']);
$form->query(['type' => 'checkbox'])->map('setOption', 'label_class', 'm-checkbox');
$form->query(['type' => 'radio'])->map('setOption', 'label_class', 'm-radio');
// dd($form);

?>

@include('admin.forms.master-inputs', [
    'list'=>$form->notInGroup(),
    'group' => new Arr()
])
