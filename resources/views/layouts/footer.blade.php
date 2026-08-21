<footer data-stellar-background-ratio="6">
    <div class="container p-5">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <h4 class="wow fadeInUp" data-wow-delay="0.4s">{{ config('portfolio.name') }}</h4>
                <hr>
                <p data-t="footer.tagline">Portofolio pribadi: proyek, artikel, dan layanan pengembangan web.</p>
                <p><i class="fa-solid fa-envelope ct"></i> <a href="mailto:{{ config('portfolio.email') }}">{{ config('portfolio.email') }}</a></p>
            </div>
            <div class="col-md-6 col-sm-8" style="line-height:18px">
                <h4 class="wow fadeInUp" data-wow-delay="0.4s" data-t="footer.navigasi">Navigasi</h4>
                <hr>
                <ul class="list-unstyled">
                    @foreach(config('portfolio.nav') as $item)
                        <li>
                            <a href="{{ url($item['href']) }}" data-t="nav.{{ strtolower($item['label']) }}">{{ $item['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
                <ul class="social">
                    <li><a href="{{ config('portfolio.socials.facebook') ?? '#' }}" class="fa-brands fa-square-facebook"></a></li>
                    <li><a href="{{ config('portfolio.socials.reddit') ?? '#' }}" class="fa-brands fa-reddit-alien"></a></li>
                    <li><a href="{{ config('portfolio.socials.instagram') }}" class="fa-brands fa-instagram"></a></li>
                    <li><a href="{{ config('portfolio.socials.twitter') }}" class="fa-brands fa-twitter"></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="background:#f0f0f0">
        <div class="container p-5">
            <div class="row">
                <div class="col-md-4 col-sm-6 copyright">
                    <p>Copyright &copy {{ date('Y') }} {{ config('portfolio.name') }}</p>
                </div>
                <div class="col-md-6 col-sm-6 copyright">
                    <a href="{{ url('/proyek') }}" data-t="nav.proyek">Proyek</a>
                    <a href="{{ url('/layanan') }}" data-t="nav.layanan">Layanan</a>
                    <a href="{{ url('/blog') }}" data-t="nav.blog">Blog</a>
                    <a href="{{ url('/kontak') }}" data-t="nav.kontak">Kontak</a>
                </div>
                <div class="col-md-2 col-sm-2 text-align-center">
                    <div class="aubtn">
                        <a href="#top" class="smoothScroll wow fadeInUp" data-wow-delay="1.5s"><i class="fa-solid fa-angle-up"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>