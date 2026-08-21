@extends('layouts.app2', ['title2' => 'Post baru'])

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <p class="display-3"><a href="/posts" class="me-3"><i class="fa fa-chevron-left"></i></a>Post baru</p>
                </div>
                <div class="card-body">
                    <form action="/posts/store" method="post" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @include('posts.partials.form-control', ['submit' => 'Buat'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection