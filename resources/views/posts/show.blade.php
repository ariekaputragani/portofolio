@extends('layouts.app', ['title' => $post->title . ' - '])

@section('content')
<div class="lamcn app-serif">
    <section id="ads">
        <div class="container p-5">
            <div class="ads-1">
                <a id="ads-b" href="#" class="ads-2"><img src="{{ asset('images/ads1.jpg') }}" alt="" class="img-fluid"></a>
                <a id="ads-bx" href="javascript:void(0)" onclick="closeAd1()" class="ads-3"></a>
                <div id="ads-ba" class="ads-4 justify-content-center">
                    <div class="ads-5 align-self-center">
                        <div id="ads-s1" class="spinner-border text-info"></div>
                        <span id="ads-c1">Iklan ditutup oleh Googol. <a href="#" style="color:#0000ff">Kenapa?</a></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="news-detail" data-stellar-background-ratio="0.5">
        <div class="container pb-5">
            <div class="row justify-content-between">
                <div class="col-md-7 article p-4">
                    <h1>{{ $post->title }}</h1>
                    <hr>
                    <p>Oleh <a href="{{ route('users.show', $post->user->username) }}">{{ $post->user->name }}</a> - {{ $post->created_at->format("d F Y") }}</p>
                    <img src="{{ $post->takeImage }}" class="w-100" alt="">
                    <p class="mt-2">{!! nl2br($post->body) !!}</p>
                    <blockquote>
                        <h6>Postingan Direkomendasikan</h6>
                        @foreach($posts_2 as $postr)
                            <hr>
                            <a href="{{ route('posts.show', $postr->slug) }}">{{ $postr->title }}</a>
                        @endforeach
                    </blockquote>
                    <div class="share">
                        <h1 class="wow fadeInLeft" data-wow-delay="0.1s">Bagikan artikel</h1>
                        <ul class="social">
                            <li><a href="#" class="fa fa-facebook-square sh-fb wow fadeInUp" data-wow-delay="0.2s"></a></li>
                            <li><a href="#" class="fa fa-reddit-alien sh-r wow fadeInUp" data-wow-delay="0.4s"></a></li>
                            <li><a href="#" class="fa fa-twitter sh-t wow fadeInUp" data-wow-delay="0.6s"></a></li>
                        </ul>
                    </div>
                    <h2 class="wow fadeInLeft mb-2" data-wow-delay="0.1s">Postingan Direkomendasikan</h2>
                    <div class="row">
                        @foreach($posts_3 as $postr)
                            <div class="col-4">
                                <a href="{{ route('posts.show', $postr->slug) }}">
                                    @if($postr->thumbnail)
                                        <img src="{{ $postr->takeImage }}" class="img-fluid wow fadeInLeft thumb" alt="" data-wow-delay="0.4s">
                                    @else
                                        <div class="thumb"></div>
                                    @endif
                                </a>
                                <div class="rc-text wow fadeInUp" data-wow-delay="0.2s"><a href="{{ route('posts.show', $postr->slug) }}">{{ $postr->title }}</a></div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4 bg-right p-2">
                    <h1 class="pt-3 px-3" style="background: #75b04c">Postingan Terbaru<hr class="pb-2"></h1>
                    @foreach($posts as $postr)
                    <div class="row rn-p mb-2">
                        <div class="col-md-4 ms-md-2">
                            <a href="{{ route('posts.show', $postr->slug) }}">
                                @if($postr->thumbnail)
                                    <img src="{{ $postr->takeImage }}" class="img-fluid thumb" alt="">
                                @else
                                    <div class="thumb"></div>
                                @endif
                            </a>
                        </div>
                        <div class="col md-8">
                            <span>{{ $postr->created_at->diffForHumans() }} - </span>
                            <a href="{{ route('posts.show', $postr->slug) }}">{{ $postr->title }}</a>
                        </div>
                    </div>
                    @endforeach
                    <h1 class="pt-3 px-3" style="background: #ff2424">Kategori<hr class="pb-2"></h1>
                    <div class="rn-ct">
                        <li><a href="{{ route('categories.show', $post->category->slug) }}"><i class="fa fa-angle-right"></i> {{ $post->category->name }}</a></li>
                    </div>
                    <div class="ads-1" style="margin-bottom: 30px">
                        <a id="ads-sd" href="#" class="ads-2"><img src="{{ asset('images/ads2.jpg') }}" alt="" class="img-fluid"></a>
                        <a id="ads-sdx" href="javascript:void(0)" onclick="closeAd2()" class="fa fa-close ads-6"></a>
                        <div id="ads-sda" class="ads-4 justify-content-center">
                            <div class="ads-5 ads-7 align-self-center">
                                <div id="ads-s2" class="spinner-border spinner-border-sm text-info"></div>
                                <span id="ads-c2">Iklan ditutup oleh Googol. <a href="#" style="color:#0000ff">Kenapa?</a></span>
                            </div>
                        </div>
                    </div>
                    <h1 class="pt-3 px-3" style="background: #58bbf8">Tag<hr class="pb-2"></h1>
                    <div class="rn-tg ms-2">
                    @foreach($post->tags as $tag)
                        <li><a href="{{ route('tags.show', $tag->slug) }}">{{ $tag->name }}</a></li>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection