<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Laravel Sitemap Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto py-12 px-4">
        <a href="/" class="text-blue-500 hover:underline mb-4 inline-block">← Back to Home</a>
        
        <article class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
            <div class="text-gray-500 mb-6">
                Published: {{ $post->created_at->format('F j, Y') }} | 
                Updated: {{ $post->updated_at->format('F j, Y') }}
            </div>
            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed">{{ $post->body }}</p>
            </div>
        </article>
        
        <div class="mt-8 text-center text-sm text-gray-500">
            <a href="/sitemap.xml" class="text-blue-500 hover:underline">View Sitemap</a>
        </div>
    </div>
</body>
</html>