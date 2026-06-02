<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitemap Admin - Laravel Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-8">Sitemap Management Dashboard</h1>
        
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <!-- Generate Sitemap Card -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Generate Static Sitemap</h2>
                <p class="text-gray-600 mb-4">Create a static sitemap.xml file in public directory</p>
                <button onclick="generateSitemap()" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">
                    Generate Sitemap
                </button>
                <div id="generateResult" class="mt-4"></div>
            </div>
            
            <!-- Clear Cache Card -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Clear Sitemap Cache</h2>
                <p class="text-gray-600 mb-4">Clear cached sitemap data</p>
                <button onclick="clearCache()" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                    Clear Cache
                </button>
                <div id="clearResult" class="mt-4"></div>
            </div>
        </div>
        
        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Sitemap Status</h2>
            <div id="status" class="space-y-2">
                Loading...
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Quick Links</h2>
            <div class="space-y-2">
                <a href="/sitemap.xml" target="_blank" class="text-blue-500 hover:underline block">→ Dynamic Sitemap (XML)</a>
                <a href="/sitemap-static.xml" target="_blank" class="text-blue-500 hover:underline block">→ Static Sitemap (XML)</a>
                <a href="/sitemap-status" target="_blank" class="text-blue-500 hover:underline block">→ Status JSON</a>
            </div>
        </div>
    </div>
    
    <script>
        async function generateSitemap() {
            const resultDiv = document.getElementById('generateResult');
            resultDiv.innerHTML = '<span class="text-blue-500">Generating...</span>';
            
            try {
                const response = await fetch('/sitemap-static.xml');
                const data = await response.json();
                resultDiv.innerHTML = '<span class="text-green-500">✓ ' + data.message + '</span>';
                loadStatus();
            } catch (error) {
                resultDiv.innerHTML = '<span class="text-red-500">✗ Error generating sitemap</span>';
            }
        }
        
        async function clearCache() {
            const resultDiv = document.getElementById('clearResult');
            resultDiv.innerHTML = '<span class="text-blue-500">Clearing...</span>';
            
            try {
                const response = await fetch('/sitemap-clear-cache');
                const data = await response.json();
                resultDiv.innerHTML = '<span class="text-green-500">✓ ' + data.message + '</span>';
                loadStatus();
            } catch (error) {
                resultDiv.innerHTML = '<span class="text-red-500">✗ Error clearing cache</span>';
            }
        }
        
        async function loadStatus() {
            try {
                const response = await fetch('/sitemap-status');
                const data = await response.json();
                
                document.getElementById('status').innerHTML = `
                    <p><strong>Static File Exists:</strong> ${data.static_file_exists ? '✓ Yes' : '✗ No'}</p>
                    <p><strong>File Size:</strong> ${data.static_file_size_kb} KB</p>
                    <p><strong>Total Posts:</strong> ${data.post_count}</p>
                    <p><strong>Dynamic URL:</strong> <a href="${data.dynamic_url}" target="_blank" class="text-blue-500">${data.dynamic_url}</a></p>
                    <p><strong>Static URL:</strong> <a href="${data.static_url}" target="_blank" class="text-blue-500">${data.static_url}</a></p>
                `;
            } catch (error) {
                document.getElementById('status').innerHTML = '<p class="text-red-500">Error loading status</p>';
            }
        }
        
        loadStatus();
    </script>
</body>
</html>