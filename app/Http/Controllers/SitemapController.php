<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class SitemapController extends Controller
{
    // Display dynamic sitemap.xml
    public function index()
    {
        $posts = Cache::remember('sitemap_posts', 60, function () {
            return Post::orderBy('updated_at', 'DESC')->get();
        });

        return response()->view('sitemap.index', compact('posts'))
                         ->header('Content-Type', 'application/xml');
    }

    // Generate static XML file
    public function generateFile()
    {
        $posts = Post::latest()->get();
        
        $xml = view('sitemap.index', compact('posts'))->render();
        
        // Save to public directory
        file_put_contents(public_path('sitemap.xml'), $xml);
        
        // Also save to storage for backup
        file_put_contents(storage_path('app/sitemap_backup.xml'), $xml);
        
        // Ping search engines
        $this->pingSearchEngines();
        
        // Clear cache
        Cache::forget('sitemap_posts');
        
        return response()->json([
            'success' => true,
            'message' => 'Sitemap generated successfully!',
            'url' => url('/sitemap.xml'),
            'post_count' => $posts->count()
        ]);
    }

    // Ping search engines
    private function pingSearchEngines()
    {
        $sitemapUrl = url('/sitemap.xml');
        $encodedSitemap = urlencode($sitemapUrl);
        
        $searchEngines = [
            'Google' => "https://www.google.com/ping?sitemap={$encodedSitemap}",
            'Bing' => "https://www.bing.com/ping?sitemap={$encodedSitemap}",
            'Yandex' => "https://webmaster.yandex.com/ping?sitemap={$encodedSitemap}"
        ];
        
        foreach ($searchEngines as $name => $url) {
            try {
                Http::timeout(5)->get($url);
                \Log::info("Pinged {$name} successfully");
            } catch (\Exception $e) {
                \Log::error("Failed to ping {$name}: " . $e->getMessage());
            }
        }
    }

    // Clear sitemap cache
    public function clearCache()
    {
        Cache::forget('sitemap_posts');
        
        return response()->json([
            'success' => true,
            'message' => 'Sitemap cache cleared successfully!'
        ]);
    }

    // Check sitemap status
    public function status()
    {
        $staticExists = File::exists(public_path('sitemap.xml'));
        $staticSize = $staticExists ? File::size(public_path('sitemap.xml')) : 0;
        $postCount = Post::count();
        
        return response()->json([
            'static_file_exists' => $staticExists,
            'static_file_size_kb' => round($staticSize / 1024, 2),
            'post_count' => $postCount,
            'dynamic_url' => url('/sitemap.xml'),
            'static_url' => url('/sitemap-static.xml')
        ]);
    }
}