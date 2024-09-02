<!DOCTYPE html>
<html>
<head>
    <title>Esqueceu sua senha</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <h2>Esqueceu sua senha</h2>
    <form method="POST" action="{{ route('forgot-password') }}">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <button type="submit">Resetar Senha</button>
    </form>
    <a href="{{ route('login') }}">Login</a>
</body>
</html>
