<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Restablecer Contraseña</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f2f7fa;
        margin: 0;
        padding: 0;
    }
    .email-container {
        max-width: 500px;
        margin: 50px auto;
        background-color: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .email-header {
        background: linear-gradient(to right, #0d6efd, #6610f2);
        color: #fff;
        text-align: center;
        padding: 2rem 1rem;
        font-size: 1.5rem;
        font-weight: 600;
    }
    .email-logo {
        width: 80px;
        margin-bottom: 1rem;
    }
    .email-body {
        padding: 2rem;
        color: #333;
        line-height: 1.6;
    }
    .btn-primary {
        display: inline-block;
        background: linear-gradient(to right, #0d6efd, #6610f2);
        color: #fff !important;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        transition: all 0.2s;
    }
    .btn-primary:hover {
        opacity: 0.95;
        transform: translateY(-2px);
    }
    .footer {
        text-align: center;
        font-size: 0.85rem;
        color: #777;
        padding: 1rem 2rem;
        border-top: 1px solid #eee;
    }
    @media (max-width: 480px) {
        .email-body { padding: 1.5rem 1rem; }
        .email-header { padding: 1.5rem 1rem; font-size: 1.3rem; }
    }
</style>
</head>
<body>

<div class="email-container">
    <div class="email-header">
        <!-- Logo opcional -->
        <!-- <img src="https://tuapp.com/logo.png" alt="Logo" class="email-logo"> -->
        Restablecer Contraseña
    </div>

    <div class="email-body">
        <p>¡Hola!</p>
        <p>Recibiste este correo porque solicitaste restablecer tu contraseña del <strong>Sistema Clínico</strong>.</p>

        <p style="text-align:center; margin:2rem 0;">
            <a href="{{ $url }}" class="btn-primary">Restablecer Contraseña</a>
        </p>

        <p>Este enlace expirará en 60 minutos.</p>
        <p>Si no solicitaste este cambio, puedes ignorar este mensaje de forma segura.</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Sistema Clínico. 
    </div>
</div>

</body>
</html>
