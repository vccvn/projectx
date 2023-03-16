<?php
use Illuminate\Support\Facades\Route;

$controller = 'General\SliderController@';

$route = 'sliders';

admin_routes($controller, $route, true);

$route = 'admin.'.$route.'.';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('options',                        $controller.'getSelectOptions'          )->name($route.'select-options');
Route::post('change-status',                 $controller.'changeStatus'              )->name($route.'change-status');

Route::get('sort.html',                      $controller.'getSortForm'               )->name($route.'sort.form');
Route::post('sort',                          $controller.'sortSliders'               )->name($route.'sort.save');

Route::middleware(['slider.item'])->group(function () {
    $item = 'General\SliderItemController@';
    $r = 'admin.sliders.items';
    Route::get('/{slider}/items.html',       $item.'getIndex'                        )->name($r); $r.='.';
    Route::get('/{slider}/items/list.html',  $item.'getList'                         )->name($r.'list');
    Route::get('/{slider}/items/sort.html',  $item.'getSortForm'                     )->name($r.'sort.form');
    Route::post('/{slider}/items/sort',      $item.'sortItems'                       )->name($r.'sort.save');
    
    Route::get('/{slider}/items/create.html',$item.'getCreateForm'                   )->name($r.'create');
    Route::get('/{slider}/items/update/{id}.html',$item.'getUpdateForm'              )->name($r.'update');
    Route::post('/{slider}/items/save',      $item.'save'                            )->name($r.'save');
    Route::post('/{slider}/items/delete',    $item.'delete'                          )->name($r.'delete');
});