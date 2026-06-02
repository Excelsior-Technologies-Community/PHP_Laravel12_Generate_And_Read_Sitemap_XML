<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {--ping : Ping search engines after generation}';
    protected $description = 'Generate sitemap.xml file';

    public function handle()
    {
        $this->info('Generating sitemap...');
        
        $posts = Post::latest()->get();
        $xml = view('sitemap.index', compact('posts'))->render();
        
        file_put_contents(public_path('sitemap.xml'), $xml);
        
        $this->info('✓ Sitemap generated successfully!');
        $this->info("  - Posts included: {$posts->count()}");
        $this->info("  - File size: " . round(filesize(public_path('sitemap.xml')) / 1024, 2) . " KB");
        $this->info("  - Location: " . public_path('sitemap.xml'));
        
        if ($this->option('ping')) {
            $this->call('sitemap:ping');
        }
        
        Cache::forget('sitemap_posts');
        
        return Command::SUCCESS;
    }
}