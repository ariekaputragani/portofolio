<ul class="nav-2 flex-column sticky-top s-a">
    <li class="nav-item">
        <a href="{{ route('profile') }}" class="nav-link{{ request()->is('profile') ? ' active' : '' }}">Profil</a>
    </li>
    <li class="nav-item">
        <a href="/posts" class="nav-link{{ request()->is('posts') ? ' active' : '' }}">Post</a>
    </li>
    <li class="nav-item">
        <a href="/doctors" class="nav-link{{ request()->is('doctors') ? ' active' : '' }}">Dokter</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('appointments.index') }}" class="nav-link{{ request()->is('appointments') ? ' active' : '' }}">Data Janji</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('messages.index') }}" class="nav-link{{ request()->is('messages') ? ' active' : '' }}">Pesan</a>
    </li>
</ul>