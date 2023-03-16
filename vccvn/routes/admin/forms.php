<?php
use Illuminate\Support\Facades\Route;

$controller = 'General\FormController@';
$route = 'forms';

$listRoute = ['index', 'list','trash', 'create', 'update', 'save', 'move-to-trash', 'restore', 'delete'];

add_web_module_routes($controller, $listRoute, $route, 'admin');
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('/get-slug',                      $controller.'getSlug'                  )->name($route.'data');
