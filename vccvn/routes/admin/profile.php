<?php
use Illuminate\Support\Facades\Route;
$controller = 'Personal\ProfileController@';

$route = 'admin.profile';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/',                               $controller.'getProfileForm'            )->name($route);$route.='.';
Route::get('/general.html',                   $controller.'getProfileForm'            )->name($route.'general');
Route::post('/general-handle',                $controller.'handle'                    )->name($route.'general.handle');

// skill
$skill = 'Personal\ProfileSkillController@';
$r = $route.'skills';
Route::get('/skills.html',                    $skill.'showSkills'                     )->name($r); $r.='.';
Route::get('/skills/detail',                  $skill.'getResourceDetail'              )->name($r.'detail');
Route::post('/skills/save',                   $skill.'ajaxSave'                       )->name($r.'save');
Route::post('/skills/add',                    $skill.'ajaxSave'                       )->name($r.'add');
Route::post('/skills/create',                 $skill.'ajaxSave'                       )->name($r.'create');
Route::post('/skills/update',                 $skill.'ajaxSave'                       )->name($r.'update');
Route::post('/skills/sort',                   $skill.'sortItems'                      )->name($r.'sort');
Route::delete('/skills/delete',               $skill.'delete'                         )->name($r.'delete');

// kinh nghiem
$experience = 'Personal\WorkExperienceController@';
$exp = $route.'experiences';
Route::get('/experiences.html',               $experience.'showExperiences'           )->name($exp); $exp.='.';
Route::get('/experiences/detail',             $experience.'getResourceDetail'         )->name($exp.'detail');
Route::post('/experiences/save',              $experience.'ajaxSave'                  )->name($exp.'save');
Route::post('/experiences/add',               $experience.'ajaxSave'                  )->name($exp.'add');
Route::post('/experiences/create',            $experience.'ajaxSave'                  )->name($exp.'create');
Route::post('/experiences/update',            $experience.'ajaxSave'                  )->name($exp.'update');
Route::post('/experiences/sort',              $experience.'sortItems'                 )->name($exp.'sort');
Route::delete('/experiences/delete',          $experience.'delete'                    )->name($exp.'delete');

// hoc van
$experience = 'Personal\ProfileEducationController@';
$exp = $route.'education';
Route::get('/education.html',                 $experience.'showEducation'             )->name($exp); $exp.='.';
Route::get('/education/detail',               $experience.'getResourceDetail'         )->name($exp.'detail');
Route::post('/education/save',                $experience.'ajaxSave'                  )->name($exp.'save');
Route::post('/education/add',                 $experience.'ajaxSave'                  )->name($exp.'add');
Route::post('/education/create',              $experience.'ajaxSave'                  )->name($exp.'create');
Route::post('/education/update',              $experience.'ajaxSave'                  )->name($exp.'update');
Route::post('/education/sort',                $experience.'sortItems'                 )->name($exp.'sort');
Route::delete('/education/delete',            $experience.'delete'                    )->name($exp.'delete');
