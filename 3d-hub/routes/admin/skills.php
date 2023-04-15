<?php
$controller = 'Personal\SkillController@';
$route = 'admin.skills';

$route.='.';

/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                    URI                    |       Controller @ method       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('/options',                       $controller.'getSelectOptions'          )->name($route.'select-options');
Route::post('/add',                          $controller.'add'                       )->name($route.'add');