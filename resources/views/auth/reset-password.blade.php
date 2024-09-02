<!-- resources/views/auth/reset-password.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <h1>Reset Password</h1>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Nova Senha:</label>
        <input type="password" id="password" name="password" required>
        <label for="password_confirmation">Confirme a Nova Senha:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <button type="submit">Redefinir Senha</button>
    </form>
</body>
</html>
