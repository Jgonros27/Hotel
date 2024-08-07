<!DOCTYPE html>
<html lang="{{ __('mail.language') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('mail.actualizar1') }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #aeadad; /* Fondo blanco */
            color: #ffffff; /* Texto principal */
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #474242; /* Fondo blanco */
            border: 2px solid #F5DEB3; /* Borde con color principal */
            border-radius: 8px;
            box-shadow: 30px 30px 30px 0px #F5DEB3;
        }

        h1 {
            color: #F5DEB3; /* Texto principal */
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 200px;
            height: auto;
        }

        p {
            color: #ffffff;
            margin-bottom: 10px;
        }

        b {
            font-weight: bold;
        }

        .contact-info {
            margin-top: 20px;
        }

        .signature {
            margin-top: 20px;
            font-style: italic;
            color: #F5DEB3; /* Texto principal */
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ __('mail.confirmacion2') }} {{ __('menu.hotel') }} {{ __('mail.actualizar3') }}</h1>
        <div class="logo">
            <img src="{{ asset('images/logos/logoFenecCirculo.jpg') }}" alt="Logo">
        </div>
        <p>
            {{ __('mail.hola') }} <b>{{ $data['nombre'] }}</b>,
            {{ __('mail.gracias') }} {{ __('menu.hotel') }}. {{ __('mail.recibirte2') }}
        </p>
        <p><b>{{ __('mail.tipoCabana') }}:</b> {{ $data['tipoCabana'] }}</p>
        <p><b>{{ __('mail.nCabana') }}:</b> {{ $data['nCabana'] }}</p>
        <p><b>{{ __('mail.fechaEntrada') }}:</b> {{ \Carbon\Carbon::parse($data['fechaEntrada'])->format('d/m/Y') }}</p>
        <p><b>{{ __('mail.fechaSalida') }}:</b> {{ \Carbon\Carbon::parse($data['fechaSalida'])->format('d/m/Y') }}</p>
        <p><b>{{ __('mail.adjunto') }}.</b></p>
        <br>
        <p><b>{{ __('mail.cancelacion1') }} {{ $data['diasCancelacion'] }} {{ __('mail.cancelacion2') }}.</b></p>
        <div class="contact-info">
            <p>{{ __('mail.asistencia1') }} <b>{{ getEnv('PHONE_NUMBER') }}</b> {{ __('mail.asistencia2') }} <b>{{ getEnv('MAIL_FROM_ADDRESS') }}</b>.</p>
        </div>
        <p class="signature">{{ __('mail.atentamente') }},</p>
        <p class="signature">{{ __('menu.hotel') }}</p>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
