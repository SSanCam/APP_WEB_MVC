<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.include-styles')
    <title>Welcome to Temugram</title>
</head>

<body>
    <!-- HEADER -->
    @include('partials.header')

    <main>

        <div class="botones">
            <a href="{{ route('user.login') }}" class="btn btn-primary">Iniciar sesión</a>
            <a href="{{ route('user.register') }}" class="btn btn-primary">Registrarse</a>
        </div>

    </main>

    <!-- FOOTER -->
    @include('partials.footer')
</body>

</html>