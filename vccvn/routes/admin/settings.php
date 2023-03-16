<?php

use App\Http\Controllers\Admin\General\UrlSettingController;
use Illuminate\Support\Facades\Route;
$route = 'admin.settings.';

$s = 'General\SettingController@';
$d = 'General\DomainController@';





Route::prefix('urls')->group(function(){
    $route = 'admin.settings.urls';

    $s = UrlSettingController::class;
    $c = 'General\\UrlSettingController@';
    // manager_routes($s, $route, true);

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */

    Route::get('/',                               $c.'getUrlSettingForm'                 )->name($route); $route.='.';
    Route::get('/{group}.html',                   $c.'getUrlSettingForm'                 )->name($route.'group');
    Route::post('/{group}/save',                  $c.'saveSettings'                      )->name($route.'group.save');
    

});






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
