<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Registrar</title>
</head>
<body>
    <h2>Registrar</h2>
    <form method="post" action="/register">
        <label>Nome: <input type="text" name="name"></label><br><br>
        <label>Email: <input type="email" name="email" required></label><br><br>
        <label>Senha: <input type="password" name="password" required></label><br><br>
        <button type="submit">Registrar</button>
    </form>
    <p>Já tem conta? <a href="/login">Entrar</a></p>
</body>
</html>
