<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        // Fetch posts from DB
        $posts = Post::orderBy('updated_at','DESC')->get();

        // Show sitemap view
        return response()->view('sitemap.index', compact('posts'))
                         ->header('Content-Type', 'application/xml');
                        
    }
}
