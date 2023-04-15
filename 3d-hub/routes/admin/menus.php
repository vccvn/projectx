<?php

$controller = 'General\MenuController@';

$route = 'menus';

$listRoute = ['index', 'create', 'update', 'save', 'delete'];

add_web_module_routes($controller, $listRoute, $route, 'admin');

$route = 'admin.'.$route.'.';


/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('options',                        $controller.'getSelectOptions'          )->name($route.'select-options');
Route::post('change-status',                 $controller.'changeStatus'              )->name($route.'change-status');

Route::get('sort.html',                      $controller.'getSortForm'               )->name($route.'sort.form');
Route::post('sort',                          $controller.'sortMenus'                 )->name($route.'sort.save');


Route::get('list.html',                      $controller.'getMenus'                  )->name($route.'list');


Route::middleware(['menu.item'])->group(function () {
    $item = 'General\MenuItemController@';
    $r = 'admin.menus.items';
    Route::get('/{menu_id}/items.html',       $item.'getItems'                       )->name($r); $r.='.';
    Route::get('/{menu_id}/items/list.html',  $item.'getList'                        )->name($r.'list');
    Route::get('/{menu_id}/items/detail/{id?}',$item.'getResourceDetail'              )->name($r.'detail');
    
    Route::post('/{menu_id}/items/sort',      $item.'sortItems'                      )->name($r.'sort');
    Route::post('/{menu_id}/items/save',      $item.'save'                           )->name($r.'save');
    Route::post('/{menu_id}/items/ajax-save', $item.'ajaxSave'                       )->name($r.'ajax-save');
    Route::post('/{menu_id}/items/delete',    $item.'delete'                         )->name($r.'delete');
});