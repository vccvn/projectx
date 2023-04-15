<?php
$route = 'admin.settings.';

$s = 'General\SettingController@';
$d = 'General\DomainController@';
// manager_routes($s, $route, true);

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::post('/update',                        $s.'handle'                            )->name($route.'handle');

Route::get('/domains.html',                   $d.'getDomainForm'                     )->name($route.'domains');
Route::post('/domains/save',                  $d.'handle'                            )->name($route.'domains.save');


Route::get('/{group}.html',                   $s.'getSettingForm'                    )->name($route.'group.form');
Route::post('/{group}/save',                  $s.'handle'                            )->name($route.'group.save');
Route::post('/{group}/items/save',            $s.'saveSettingItem'                   )->name($route.'item.save');

Route::get('{group}/detail-item/{id?}',       $s.'detailItem'                        )->name($route.'item.detail');
Route::get('{group}/sort.html',               $s.'getSortForm'                       )->name($route.'sort.form');
Route::post('{group}/sort',                   $s.'sortItems'                         )->name($route.'sort.save');
Route::post('{group}/delete',                 $s.'deleteItem'                        )->name($route.'item.delete');
