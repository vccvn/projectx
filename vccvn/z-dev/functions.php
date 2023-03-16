<?php

function base_path($path = null)
{
    return BASEDIR . ($path ? '/' .ltrim($path, '/'):'');
}


function getFields($table = null, $inline = false){
    $table = schema($table);
    if($inline){
        return "['".implode("', '", $table->getData())."']";
    }

    return $table;

}

function getResource($table = null){
    $fillable = schema($table)->getData();

    $a = "";
    foreach ($fillable as $field) {
        $a.= "\n            '$field' => \$this->$field,";
        // echo "\n$field:";
    }
    $a .= "\n";
    return $a;
}

function getRules($table = null){
    $fillable = schema($table)->getData();

    $a = "";
    foreach ($fillable as $field) {
        $a.= "\n            '$field' => 'mixed',";
        // echo "\n$field:";
    }
    $a .= "\n";
    return $a;
}
function getMessages($table = null){
    $fillable = schema($table)->getData();

    $a = "";
    foreach ($fillable as $field) {
        $a.= "\n            '$field.mixed' => '$field Không hợp lệ',";
        // echo "\n$field:";
    }
    $a .= "\n";
    return $a;
}


function defaultJson($table = null){
    $fields = schema($table)->getData();

    $a = [];
    foreach ($fields as $field) {
        $a[$field] = [
            'type' => 'text',
            'label' => '',
            'placeholder' => 'nhập '
        ];
    }
    return $a;
}


function show($data)
{
    if(is_array($data)) $data = json_encode($data);
    echo $data;
}

