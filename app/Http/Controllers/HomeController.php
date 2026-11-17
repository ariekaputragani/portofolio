<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __invoke()
    {
        $projects = collect(config('projects') ?? config('portfolio.projects') ?? [])->where('featured', true)->take(3)->values();
        $posts = collect(config('posts') ?? config('portfolio.posts') ?? [])->sortByDesc('date')->take(3);
        $technologies = config('portfolio.technologies') ?? config('projects.technologies') ?? [];

        return view('home', compact('projects', 'posts', 'technologies'));
    }
}
