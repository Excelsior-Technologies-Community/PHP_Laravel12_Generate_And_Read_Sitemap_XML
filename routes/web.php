<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

// Post Routes
Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');

// Sitemap Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/sitemap-static.xml', [SitemapController::class, 'generateFile']);
Route::get('/sitemap-clear-cache', [SitemapController::class, 'clearCache']);
Route::get('/sitemap-status', [SitemapController::class, 'status']);

// Admin Dashboard (Simple)
Route::get('/admin/sitemap', function () {
    return view('admin.sitemap');
});