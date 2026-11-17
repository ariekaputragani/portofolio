<?php

namespace App\Http\Controllers;

class ProjectController extends Controller
{
    /**
     * Projects listing / detail via index.
     */
    public function index(?string $slug = null)
    {
        if ($slug) {
            return $this->show($slug);
        }

        return redirect('/#projects');
    }

    /**
     * Single project detail.
     */
    public function show(string $slug)
    {
        $project = collect(config('projects'))->firstWhere('slug', $slug);

        abort_unless($project, 404);

        return view('proyek-show', ['project' => $project]);
    }

    /**
     * Aliases for backward compatibility.
     */
    public function projects()
    {
        return $this->index();
    }

    public function projectShow(string $slug)
    {
        return $this->show($slug);
    }
}