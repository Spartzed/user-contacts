<div class="navbar">
    <a href="{{ url('/contacts') }}">
        <img src="{{ asset('images/left.svg') }}" alt="Retornar">
        Home
    </a>
    @auth
        <a href="{{ route('logout') }}" class="right"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           Logout
           <img src="{{ asset('images/logout.svg') }}" alt="Sair">
        </a>
        <a href="#" class="delete-btn right" id="delete-account-btn">
            Excluir Conta
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @else
        <a href="{{ route('login') }}" class="right">Login</a>
    @endauth
</div>
