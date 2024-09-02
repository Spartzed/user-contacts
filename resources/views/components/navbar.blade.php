<div class="navbar">
    <a href="{{ url('/contacts') }}">Home</a>
    @auth
        <a href="{{ route('logout') }}" class="right"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <a href="#" class="right" id="delete-account-btn">
            Excluir Conta
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @else
        <a href="{{ route('login') }}" class="right">Login</a>
    @endauth
</div>
