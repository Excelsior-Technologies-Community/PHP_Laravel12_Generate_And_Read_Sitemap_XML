<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Illuminate\Support\Facades\Http;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap and ping search engines';

    public function handle()
    {
        $posts = Post::latest()->get();

        $xml = view('sitemap.index', compact('posts'))->render();

        file_put_contents(public_path('sitemap.xml'), $xml);

        $sitemapUrl = url('/sitemap.xml');
        Http::get("https://www.google.com/ping?sitemap={$sitemapUrl}");

        $this->info('Sitemap generated and Google pinged successfully.');
    }
}