<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PingSitemap extends Command
{
    protected $signature = 'sitemap:ping';
    protected $description = 'Ping search engines with sitemap URL';

    public function handle()
    {
        $sitemapUrl = url('/sitemap.xml');
        $encoded = urlencode($sitemapUrl);
        
        $this->info("Pinging search engines with: {$sitemapUrl}");
        
        $engines = [
            'Google' => "https://www.google.com/ping?sitemap={$encoded}",
            'Bing' => "https://www.bing.com/ping?sitemap={$encoded}",
        ];
        
        foreach ($engines as $name => $url) {
            try {
                $response = Http::timeout(5)->get($url);
                $this->info("✓ Pinged {$name}: HTTP " . $response->status());
            } catch (\Exception $e) {
                $this->error("✗ Failed to ping {$name}: " . $e->getMessage());
            }
        }
        
        return Command::SUCCESS;
    }
}