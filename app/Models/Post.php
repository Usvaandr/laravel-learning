<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function find($slug)
    {
        return self::all()->firstWhere('slug', $slug);
    }

    public static function all()
    {
        //added cache to post.all
        return cache()->rememberForever('post.all', function () {
            $files = File::files(resource_path("posts/"));

            return collect($files)
                ->map(function ($file) {
                    return YamlFrontMatter::parseFile($file);
                })
                ->map(function ($document) {
                    return new Post(
                        $document->title,
                        $document->excerpt,
                        $document->date,
                        $document->body(),
                        $document->slug
                    );
                })
                ->sortByDesc('date');
        });
    }
}
