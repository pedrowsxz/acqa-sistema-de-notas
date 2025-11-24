<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="/login">
        <label>Email: <input type="email" name="email" required></label><br><br>
        <label>Senha: <input type="password" name="password" required></label><br><br>
        <button type="submit">Entrar</button>
    </form>
    <p>Não tem conta? <a href="/register">Registrar</a></p>
</body>
</html>
