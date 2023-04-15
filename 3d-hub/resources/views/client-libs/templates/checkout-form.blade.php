<?php

// cac bien
// form config
$cfg = new Arr($config??[]);
$args = [
	'inputs' => $inputs??[],
	'data' => $data??[],
	'errors' => $errors
];
$input_options = (isset($options) && $options)?$options:[];
$form = html_form($args, $input_options, $attrs??[]);
$form->query(['type' => ['radio', 'checkbox', 'crazyselect', 'file']])->map('removeClass', ['form-control', 'm-input']);
$form->query(['type' => 'checkbox'])->map('setOption', 'label_class');
$form->query(['type' => 'radio'])->map('setOption', 'label_class', 'm-radio');
set_web_data('__cart__form__', $form);
?>