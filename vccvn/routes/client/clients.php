<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$route = 'client.';


$c = 'SearchController@';
// $route = 'client.posts.';
/**
 * ---------------------------------------------------------------------------------------------------------
 *  Method | URI                                   | Controller @ Nethod         | Route Name               
 * ---------------------------------------------------------------------------------------------------------
 */
Route::get('tim-kiem',                              $c.'search'                  )->name($route.'search');


// comments
$c = 'CommentController@';
Route::post('ajax-comment',                         $c.'ajaxSave'                )->name($route.'comments.ajax');
Route::post('post-comment',                         $c.'create'                  )->name($route.'comments.post');


// contact
$c = 'ContactController@';
Route::get('lien-he.html',                          $c.'showForm'                )->name($route.'contacts.form');
Route::post('gui-lien-he',                          $c.'sendContact'             )->name($route.'contacts.send');
Route::post('gui-lien-he-bang-ajax',                $c.'ajaxSend'                )->name($route.'contacts.ajax-send');

// contact
$c = 'SubcribeController@';
Route::post('dang-ky-theo-doi',                     $c.'save'                    )->name($route.'subcribe');
Route::post('subcribe',                             $c.'ajaxSave'                )->name($route.'ajax-subcribe');

$c = 'ThemeController@';
Route::get('themes/preview',                        $c.'preview'                 )->name($route.'themes.preview');
Route::get('themes/reset',                          $c.'reset'                   )->name($route.'themes.preview');




Route::get('crawler',                               'CrawlerController@test'    )->name($route.'crawler.test');


$c = 'LocationController@';
Route::get('location/region-options',               $c.'getRegionOptions'       )->name($route.'location.regions.options');
Route::get('location/district-options',             $c.'getDistrictOptions'     )->name($route.'location.districts.options');
Route::get('location/ward-options',                 $c.'getWardOptions'         )->name($route.'location.wards.options');




$c = 'VisitorController@';
Route::get('check-visitor',                         $c.'checkVisitor'           )->name($route.'visitors.check');
Route::post('check-visitor',                        $c.'checkVisitor'           );

Route::get('manifest.json',                         'PWAController@showManifest')->name($route . 'manifest');
Route::get('service-worker.js',                     'PWAController@showSWjs')->name($route . 'SW.js');

Route::any('redirect','HomeController@redirect');

