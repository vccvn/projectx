<?php

use Illuminate\Support\Facades\Route;

$c = "ServicePromoController@";

$r = 'client.services.promos.';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
// url: /users/add
Route::post('/check-promo-code',                   $c.'checkPromoCode'                    )->name($r.'check-code');