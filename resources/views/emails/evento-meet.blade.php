<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>Hola,{{ $user_name }}</p>

    <p>Tu reunión ha sido agendada exitosamente.</p>

    <p>Para unirte a la reunión por Google Meet, haz clic en este enlace:</p>

    <p><a href="{{ $meetLink }}">{{ $meetLink }}</a></p>

    <p>Saludos.</p>
</body>

</html>