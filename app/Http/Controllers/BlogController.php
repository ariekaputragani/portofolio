<?php

namespace App\Http\Controllers;

class BlogController extends Controller
{
    /**
     * Blog listing / detail via index.
     */
    public function index(?string $slug = null)
    {
        if ($slug) {
            return $this->show($slug);
        }

        return view('berita', ['posts' => collect(config('posts'))->sortByDesc('date')]);
    }

    /**
     * Single blog post.
     */
    public function show(string $slug)
    {
        $post = collect(config('posts'))->firstWhere('slug', $slug);

        abort_unless($post, 404);

        return view('blog-show', ['post' => $post]);
    }

    /**
     * Aliases for backward compatibility.
     */
    public function blog()
    {
        return $this->index();
    }

    public function blogShow(string $slug)
    {
        return $this->show($slug);
    }
}