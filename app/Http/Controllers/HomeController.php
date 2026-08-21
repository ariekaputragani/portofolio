<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard (portfolio home).
     */
    public function index()
    {
        $projects = collect(config('projects'));
        $services = config('portfolio.services');
        $posts = collect(config('posts'))->sortByDesc('date')->take(3);
        $technologies = config('portfolio.technologies');

        return view('home', compact('projects', 'services', 'posts', 'technologies'));
    }
}