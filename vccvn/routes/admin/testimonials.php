<?php
use Illuminate\Support\Facades\Route;
$controller = 'General\TestimonialController@';

$route = 'admin.testimonials';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

$listRoute = ['list', 'index', 'create', 'update', 'save', 'delete'];

add_web_module_routes($controller, $listRoute, 'testimonials', 'admin');
