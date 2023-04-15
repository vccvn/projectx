<?php

$c = 'ProjectController@';
$r = 'client.projects';
/**
 * -------------------------------------------------------------------------------------------------------------------------------
 *  Method | URI                                           | Controller @ Nethod         | Route Name               
 * -------------------------------------------------------------------------------------------------------------------------------
 */

Route::get('/du-an/',                                       $c.'viewProjects'            )->name($r);$r.='.';
$prefix = '/danh-muc-du-an/';
Route::get($prefix,                                         $c.'viewProjects'            )->name($r.'categories.view-by-id');
Route::get($prefix.'{slug}.html',                           $c.'viewProjects'            )->name($r.'categories.view-simple');
Route::get($prefix.'{parent}/{child}.html',                 $c.'viewProjects'            )->name($r.'categories.view-child');
Route::get($prefix.'{first}/{second}/{third}.html',         $c.'viewProjects'            )->name($r.'categories.view-3-level');
Route::get($prefix.'{first}/{second}/{third}/{fourth}.html',$c.'viewProjects'            )->name($r.'categories.view-4-level');
Route::get('/du-an/{slug}.html',                            $c.'viewProjectDetail'       )->name($r.'detail');
Route::get('/du-an/{slug}.json',                            $c.'getProjectJsonData'      )->name($r.'json');
Route::get('/projects/detail/{id?}',                        $c.'getProjectJsonData'      )->name($r.'data');

