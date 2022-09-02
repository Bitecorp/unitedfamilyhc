
<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>1099 FORM</title>
        </head>
        <body style="margin-top: -25px !important;">
            <p style="text-align: center; font-size: 12px;"><strong>1099 CONTRACTOR BALANCE DETAIL REPORT</strong></p>
            <p style="text-align: center; font-size: 12px;"><strong>ETF AND CHECK</strong></p>
            <table style="border-collapse: collapse; width: 100%; height: 36px;" border="1">
                <tbody>
                    <tr style="height: 18px;">
                        <td style="width: 33.3333%; height: 36px; font-size: 12px;" rowspan="2"><strong>DATE PERIOD:</strong></td>
                        <td style="width: 33.3333%; height: 18px; font-size: 12px;"><strong>START</strong></td>
                        <td style="width: 33.3333%; height: 18px; font-size: 12px;"><strong>END</strong></td>
                    </tr>
                    <tr style="height: 18px;">
                        <td style="width: 33.3333%; height: 18px;">{{ $desde }}</td>
                        <td style="width: 33.3333%; height: 18px;">{{ $hasta }}</td>
                    </tr>
                </tbody>
            </table>
            <p style=" font-size: 12px;"><strong>VENDOR CODE:</strong> {{ $vendorCode }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <strong>DATE PAY:</strong> {{ $datePai }}</p>
            <p style=" font-size: 12px;"><strong>EFT OR CHECK:</strong> {{ $eftorCheck }}</p>
            <p style="text-align: center; font-size: 12px;"><br /><strong>VENDOR / PAYEE INFORMATION</strong></p>
            <p style=" font-size: 12px;"><strong>NANE:</strong> {{ strtoupper($fullName) }}.</p>
            <p style=" font-size: 12px;"><strong>BUSINESS NAME:</strong> {{ strtoupper($fullNameCompani) }}.</p>
            <p style=" font-size: 12px;"><strong>ADDRESS:</strong> {{ strtoupper($addres) }}</p>
            <p style="text-align: center; font-size: 12px;"><strong>INVOICE INFORMATION</strong></p>
            <p style="text-align: left; font-size: 12px;">INVOICE NUMBER: {{ $invoiceNumber }}</p>
            <table style="border-collapse: collapse; width: 100%;" border="1">
                <thead>
                    <tr>
                        <td style="width: 5.12391%; font-size: 12px;"><strong>N#</strong></td>
                        <td style="width: 22.083%; font-size: 12px;"><strong>CURRENT SERVICE</strong></td>
                        <td style="width: 17.5995%; font-size: 12px;"><strong>CLIENTE NAME</strong></td>
                        <td style="width: 14.0908%; font-size: 12px;"><strong>RATE</strong></td>
                        <td style="width: 13.506%; font-size: 12px;"><strong>UNITS</strong></td>
                        <td style="width: 13.311%; font-size: 12px;"><strong>HOURS</strong></td>
                        <td style="width: 14.2857%; font-size: 12px;"><strong>AMOUNT</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataPagos as $key => $value)
                        <tr id="{{ $key }}">
                            <td style="width: 5.12391%; font-size: 12px;">{{ $key + 1 }}</td>
                            <td style="width: 22.083%; font-size: 12px;">{{ $value['service_and_sub_service'] ? $value['service_and_sub_service'] : 'N/A' }}</td>
                            <td style="width: 17.5995%; font-size: 12px;">{{ $value['patiente_full_name'] ? $value['patiente_full_name'] : 'N/A'}}</td>
                            <td style="width: 14.0908%; font-size: 12px;">{{ $value['unidad_time_worker'] ? $value['unidad_time_worker'] : 'N/A' }} {{ $value['unidad_type_worker'] ? $value['unidad_type_worker'] : 'N/A' }} = {{ $value['unit_value_worker'] ? $value['unit_value_worker'] : '' }} $ (USD)</td>
                            <td style="width: 13.506%; font-size: 12px;">{{ $value['unid_pay_worker'] ? $value['unid_pay_worker'] : 'N/A }}</td>
                            <td style="width: 13.311%; font-size: 12px;">{{ $value['time_attention'] ? $value['time_attention'] : 'N/A'}}</td>
                            <td style="width: 14.2857%; font-size: 12px;">{{ $value['mont_pay'] ? $value['mont_pay'] : 'N/A' }} $ (USD)</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="text-align: right; font-size: 12px;">Total: {{ number_format((float)$montoTotal, 2, '.', '') }} $ (USD)</p>
        </body>
    </html>
        