<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <h1>Bienvenido de nuevo</h1>
    <form method="post" action="/api/v2/usuario/validar">
    @csrf
        <input name="username" type="text">
        <input name="password" type="password">
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>