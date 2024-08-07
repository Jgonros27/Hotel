<!DOCTYPE html>
<html lang="{{ __('pdf.language') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('pdf.title') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffffff;
        }

        .invoice-container {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            width: 100%;
            max-width: 794px;
            /* Ancho A4 en px */
            margin: 30px auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .invoice-header,
        .invoice-footer {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .invoice-header img {
            max-width: 200px;
            margin-bottom: 20px;
        }

        .invoice-header h1 {
            color: #333333;
        }

        .invoice-details {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #f8f9fa;
            padding: 10px 15px;
        }

        .invoice-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .invoice-table tfoot {
            font-weight: bold;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .invoice-container {
                margin: 0;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>

    <div class="container bg-white">

        <!-- Encabezado -->
        <div class="invoice-header text-center">
            <img src="{{ asset('images/logos/logoFenecCirculo.jpg') }}" class="img-fluid">
            <h1>{{ __('pdf.title') }}</h1>
            <p class="lead">{{ __('pdf.invoice_id') }}: <strong>{{ $reservaCabana->id }}</strong></p>
        </div>

        <!-- Datos del Hotel -->
        <div class="row mb-5">
            <div class="col-md-6">
                <h4>{{ __('pdf.hotel_name') }}</h4>
                <p class="invoice-details">{{ __('pdf.address') }}: <strong>{{ getEnv('ADDRESS') }}</strong></p>
                <p class="invoice-details">{{ __('pdf.phone') }}: <strong>{{ getEnv('PHONE_NUMBER') }}</strong></p>
                <p class="invoice-details">{{ __('pdf.email') }}: <strong>{{ getEnv('MAIL_FROM_ADDRESS') }}</strong>
                </p>
            </div>
            <div class="col-md-6 text-md-right">
                <p class="invoice-details">{{ __('pdf.date') }}:
                    <strong>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</strong></p>
            </div>
        </div>

        <!-- Datos del Cliente y Reserva -->
        <div class="row mb-5">
            <div class="col-md-6 mb-5">
                <h4>{{ __('pdf.customer_details') }}</h4>
                <p class="invoice-details">{{ __('pdf.customer_name') }}:
                    <strong>{{ $reservaCabana->usuario->name }}</strong></p>
                <p class="invoice-details">{{ __('pdf.customer_email') }}:
                    <strong>{{ $reservaCabana->usuario->email }}</strong></p>
            </div>
            <div class="col-md-6 mb-5">
                <h4>{{ __('pdf.reservation_details') }}</h4>
                <p class="invoice-details">{{ __('pdf.cabin_type') }}:
                    <strong>{{ $reservaCabana->cabana->tipoCabana->nombre }}</strong></p>
                <p class="invoice-details">{{ __('pdf.cabin_number') }}:
                    <strong>{{ $reservaCabana->id_cabana }}</strong></p>
                <p class="invoice-details">{{ __('pdf.reservation_date') }}:
                    <strong>{{ \Carbon\Carbon::parse($reservaCabana->created_at)->format('d/m/Y') }}</strong></p>
                <p class="invoice-details">{{ __('pdf.check_in_date') }}:
                    <strong>{{ \Carbon\Carbon::parse($reservaCabana->fecha_entrada)->format('d/m/Y') }}</strong></p>
                <p class="invoice-details">{{ __('pdf.check_out_date') }}:
                    <strong>{{ \Carbon\Carbon::parse($reservaCabana->fecha_salida)->format('d/m/Y') }}</strong></p>
                <p class="invoice-details">{{ __('pdf.guest_number') }}:
                    <strong>{{ $reservaCabana->n_huespedes }}</strong></p>
            </div>
        </div>

        <!-- Detalles de la Factura -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered invoice-table">
                    <thead>
                        <tr>
                            <th>{{ __('pdf.description') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('pdf.precio') }}</td>
                            <td>{{ $reservaCabana->precio_habitacion }}€</td>
                        </tr>
                        <tr>
                            <td>{{ __('pdf.total') }}</td>
                            <td>{{ $reservaCabana->precio_total }}€</td>
                        </tr>
                        <tr>
                            <td>{{ __('pdf.descuento') }}</td>
                            <td>{{ $reservaCabana->descuento }}€</td>
                        </tr>
                        <tr>
                            <td>{{ __('pdf.half_board') }}</td>
                            <td>{{ $reservaCabana->media_pension }}€</td>
                        </tr>
                    </tbody>
                    <tfoot style="background-color: ">
                        <tr>
                            <th>{{ __('pdf.final') }}</th>
                            <th>{{ $reservaCabana->precio_final }}€</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Pie de página -->
        <div class="invoice-footer text-center">
            <p>{{ __('pdf.thank_you') }}</p>
        </div>

    </div>

    <!-- Bootstrap JS, Popper.js, jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
