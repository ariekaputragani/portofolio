@extends('layouts.app', ['title' => 'Post - '])

@section('content')
@include('layouts.banner')
<div class="container py-5 huruf-serif">
    <div class="row">
        <div class="col-3">
            @include('layouts.nav')
        </div>
        <div class="col-9">
            <h4>Semua Post</h4>
            <hr>
            <div class="row">
                <div class="col-post">   
                    @forelse ($posts as $post)
                        <div class="card mb-4">
                            @if($post->thumbnail)
                            <a href="{{ route('posts.show', $post->slug) }}">
                                <img class="card-img-top thumb" src="{{ $post->takeImage }}">
                            </a>
                            @endif
                            <div class="card-body">
                                <a href="{{ route('categories.show', $post->category->slug) }}" class="text-secondary">
                                    <small>{{ $post->category->name }}</small>
                                </a>
                                <small> - </small>
                                @foreach($post->tags as $tag)
                                    <a href="{{ route('tags.show', $tag->slug) }}" class="text-secondary">
                                        <small>{{ $tag->name }}</small>
                                    </a>
                                @endforeach
                                <h5>
                                    <a href="{{ route('posts.show', $post->slug) }}" class="card-title text-dark">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                <div class="text-secondary my-3">
                                    {{ Str::limit($post->body, 200) }}
                                </div>

                                <div class="d-flex justify-content-between">
                                    
                                    <div>
                                        {{ $post->user->name }}
                                    </div>
                                    <div class="text-secondary">
                                        <small>
                                            Published on {{ $post->created_at->format("d F Y") }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex">
                                <div class="ms-auto">
                                    <a href="/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-warning">Edit</a>
                                </div>
                                <div class="ms-2">
                                    <a href="/posts/{{ $post->slug }}/delete" class="btn btn-sm btn-danger" data-confirm-delete="true">Hapus</a>
                                </div>
                            </div>
                        </div>   
                    @empty
                        <div class="alert alert-info">
                            Tidak ada postingan.
                        </div>
                    @endforelse
                    {{ $posts->links() }}
                </div>   
            </div>
        </div>
    </div>
</div>
@endsection