<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Blog\PostController;

Route::prefix('blog')->group(function () {
    Route::apiResource('posts', PostController::class)
        ->names('blog.posts');
});

//Адмінка
$groupData = [
    'namespace' => 'App\Http\Controllers\Api\Blog\Admin',
    'prefix' => 'admin/blog',
];
Route::group($groupData, function () {
    //BlogCategory
    $methods = ['index','store','update'];
    Route::apiResource('categories', \App\Http\Controllers\Api\Blog\Admin\CategoryController::class)
        ->only($methods)
        ->names('blog.admin.categories');
    //BlogPost
    Route::apiResource('posts', \App\Http\Controllers\Api\Blog\Admin\PostController::class)
        ->except(['show'])
        ->names('blog.admin.posts');
});
