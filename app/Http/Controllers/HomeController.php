<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard (portfolio home).
     */
    public function index()
    {
        // Carousel home: maksimal 3 projek utama (featured)
        $projects = collect(config('projects'))->where('featured', true)->take(3)->values();
        $services = config('portfolio.services');
        $posts = collect(config('posts'))->sortByDesc('date')->take(3);
        $technologies = config('portfolio.technologies');

        return view('home', compact('projects', 'services', 'posts', 'technologies'));
    }
}