<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Correo Electrónico</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f0ebe1;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="min-height: 100vh; background-color: #f0ebe1;">
        <tr>
            <td align="center" valign="top" style="padding: 20px;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="padding: 40px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="text-align: center; padding-bottom: 30px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#5d4037" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="4"></circle>
                                            <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8"></path>
                                        </svg>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1 style="color: #5d4037; font-size: 28px; margin: 0 0 20px 0; text-align: center; border-bottom: 2px solid #8d6e63; padding-bottom: 10px;">Verificación de Correo Electrónico</h1>
                                        <p style="color: #3e2723; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Estimado usuario,</p>
                                        <p style="color: #3e2723; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Gracias por registrarte. Tu correo <strong style="color: #5d4037;">{{$email}}</strong> necesita ser verificado.</p>
                                        <p style="color: #3e2723; font-size: 16px; line-height: 1.5; margin-bottom: 30px;">Por favor, haz clic en el siguiente botón para verificar tu dirección de correo electrónico:</p>
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 30px;">
                                            <tr>
                                                <td align="center">
                                                    <a href="{{ $url }}" style="background-color: #8d6e63; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-size: 18px; display: inline-block;">Verificar Correo Electrónico</a>
                                                </td>
                                            </tr>
                                        </table>
                                        <p style="color: #3e2723; font-size: 14px; line-height: 1.5; margin-top: 30px; text-align: center;">Si no has creado una cuenta, por favor ignora este correo o contacta con nuestro soporte técnico.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; background-color: #5d4037; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                            <p style="color: #d7ccc8; font-size: 14px; text-align: center; margin: 0;">&copy; {{ date('Y') }} Tu Empresa. Todos los derechos reservados.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>


