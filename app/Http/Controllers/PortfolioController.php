<?php

namespace App\Http\Controllers;

class PortfolioController extends Controller
{
    /**
     * Projects listing.
     */
    public function projects()
    {
        return view('proyek', ['projects' => collect(config('projects'))]);
    }

    /**
     * Single project.
     */
    public function projectShow(string $slug)
    {
        $project = collect(config('projects'))->firstWhere('slug', $slug);

        abort_unless($project, 404);

        return view('proyek-show', ['project' => $project]);
    }

    /**
     * Services listing (layanan = benefit).
     */
    public function services()
    {
        return view('benefit', ['services' => collect(config('portfolio.services'))]);
    }

    /**
     * Blog listing.
     */
    public function blog()
    {
        return view('berita', ['posts' => collect(config('posts'))->sortByDesc('date')]);
    }

    /**
     * Single blog post.
     */
    public function blogShow(string $slug)
    {
        $post = collect(config('posts'))->firstWhere('slug', $slug);

        abort_unless($post, 404);

        return view('blog-show', ['post' => $post]);
    }

    /**
     * Contact page.
     */
    public function contact()
    {
        return view('kontak');
    }
}