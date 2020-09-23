<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($files as $file)
    <url>
        <loc>{{ $file }}</loc>
        <priority>0.8</priority>
    </url>
    @endforeach
</urlset>
