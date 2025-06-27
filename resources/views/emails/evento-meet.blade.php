<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reunión agendada</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f6f9fc; font-family: Arial, sans-serif;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; background-color: #ffffff; margin: 40px auto; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">
        <tr>
            <td style="padding: 30px 40px;">
                <h2 style="margin-top: 0; color: #2c3e50;">Hola, {{ $user_name }}</h2>

                <p style="font-size: 16px; line-height: 1.6; color: #333333;">
                    Tu reunión ha sido <strong>agendada exitosamente</strong>.
                </p>

                <p style="font-size: 16px; line-height: 1.6; color: #333333;">
                    Para unirte a la reunión por Google Meet, haz clic en el siguiente enlace:
                </p>

                <p style="margin: 20px 0;">
                    <a href="{{ $meetLink }}"
                        style="background-color: #1a73e8; color: #ffffff; padding: 12px 20px; text-decoration: none; border-radius: 4px; display: inline-block;">
                        Unirme a la reunión
                    </a>
                </p>

                <p style="font-size: 14px; color: #555555; word-break: break-all;">
                    O copia y pega el siguiente enlace en tu navegador:<br>
                    <a href="{{ $meetLink }}" style="color: #1a73e8;">{{ $meetLink }}</a>
                </p>

                <p style="font-size: 16px; color: #333333;">
                    Saludos cordiales,<br>
                    El equipo de Soporte
                </p>
            </td>
        </tr>

        <tr>
            <td style="background-color: #f1f1f1; padding: 20px; text-align: center; font-size: 12px; color: #888888;">
                Este correo fue generado automáticamente. No respondas a este mensaje.<br>
                &copy; {{ date('Y') }} TuEmpresa. Todos los derechos reservados.
            </td>
        </tr>
    </table>
</body>

</html>