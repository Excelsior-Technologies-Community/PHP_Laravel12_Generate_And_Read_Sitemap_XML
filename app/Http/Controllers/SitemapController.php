<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Cache::remember('sitemap_posts', 60, function () {
            return Post::orderBy('updated_at', 'DESC')->get();
        });

        return response()->view('sitemap.index', compact('posts'))
                         ->header('Content-Type', 'application/xml');
    }

    public function generateFile()
    {
        $posts = Post::latest()->get();

        $xml = view('sitemap.index', compact('posts'))->render();

        file_put_contents(public_path('sitemap.xml'), $xml);

        $sitemapUrl = url('/sitemap.xml');
        Http::get("https://www.google.com/ping?sitemap={$sitemapUrl}");

        Cache::forget('sitemap_posts');

        return response()->json([
            'status' => true,
            'message' => 'Sitemap file generated and Google pinged successfully!'
        ]);
    }

    public function clearCache()
    {
        Cache::forget('sitemap_posts');

        return response()->json([
            'status' => true,
            'message' => 'Sitemap cache cleared successfully!'
        ]);
    }
}