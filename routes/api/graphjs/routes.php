<?php

Route::group([
    'prefix' => 'api/graphjs',
    'as' => 'api_graphjs_',
    'middleware' => ['can:access-resource,"reportes"'],
], function(){
    require __DIR__ . '/reportes.php';
});