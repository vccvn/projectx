<?php


// controller

use Illuminate\Support\Facades\Route;

$c = 'TestController@';
$r = 'manager.test';
/*
|-------------------------------------------------------------------------------------------------------------------
|                         URL                         |           CONTROLLER            |           NAME
|-------------------------------------------------------------------------------------------------------------------
*/    
Route::get('/',                                        $c.'index'                        )->name($r); 
$r.='.';
Route::get('/form-settings.html',                      $c.'testForm'                     )->name($r.'form-setting');
Route::post('save-/form-settings',                     $c.'saveFormConfig'               )->name($r.'save-setting');

$c = 'LocationController@';
Route::get('/create-location',                         $c.'createLocations'              )->name($r.'create-location');
Route::get('/get-regions',                             $c.'getRegions'                   )->name($r.'get-regions');
Route::get('/get-districts',                           $c.'getDistricts'                 )->name($r.'get-districts');
Route::get('/get-wards',                               $c.'getWards'                     )->name($r.'get-wards');
