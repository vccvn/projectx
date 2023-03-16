<?php

use Illuminate\Support\Facades\Route;

$r = 'client.bookings.';

/**
 * -------------------------------------------------------------------------------------------------------------------------------
 *  Method | URI                                           | Controller @ Nethod         | Route Name
 * -------------------------------------------------------------------------------------------------------------------------------
 */


// contact
$c = 'BookingController@';
Route::post('dat-lich',                                    $c.'ajaxSend'                )->name($r.'ajax-submit');
