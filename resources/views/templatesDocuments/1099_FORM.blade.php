
<<<<<<< HEAD
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
            <p style="text-align: center; font-size: 10px;"><strong>ETF AND CHECK</strong></p>
            <table style="border-collapse: collapse; width: 100%; height: 36px;" border="1">
                <tbody>
                    <tr style="height: 18px;">
                        <td style="width: 33.3333%; height: 36px; font-size: 10px;" rowspan="2"><strong>DATE PERIOD:</strong></td>
                        <td style="width: 33.3333%; height: 18px; font-size: 10px;"><strong>START</strong></td>
                        <td style="width: 33.3333%; height: 18px; font-size: 10px;"><strong>END</strong></td>
                    </tr>
                    <tr style="height: 18px;">
                        <td style="width: 33.3333%; height: 18px;">{{ $desde }}</td>
                        <td style="width: 33.3333%; height: 18px;">{{ $hasta }}</td>
                    </tr>
                </tbody>
            </table>
            <p style=" font-size: 10px;"><strong>VENDOR CODE:</strong> {{ $vendorCode }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <strong>DATE PAY:</strong> {{ $datePai }}</p>
            <p style=" font-size: 10px;"><strong>EFT OR CHECK:</strong> {{ $eftorCheck }}</p>
            <p style="text-align: center; font-size: 10px;"><br /><strong>VENDOR / PAYEE INFORMATION</strong></p>
            <p style=" font-size: 10px;"><strong>NANE:</strong> {{ strtoupper($fullName) }}.</p>
            <p style=" font-size: 10px;"><strong>BUSINESS NAME:</strong> {{ strtoupper($fullNameCompani) }}.</p>
            <p style=" font-size: 10px;"><strong>ADDRESS:</strong> {{ strtoupper($addres) }}</p>
            <p style="text-align: center; font-size: 10px;"><strong>INVOICE INFORMATION</strong></p>
            <p style="text-align: left; font-size: 10px;">INVOICE NUMBER: {{ $invoiceNumber }}</p>
            <table style="border-collapse: collapse; width: 100%;" border="1">
                <thead>
                    <tr>
                        <td style="width: 5.12391%; font-size: 10px;"><strong>N#</strong></td>
                        <td style="width: 22.083%; font-size: 10px;"><strong>CURRENT SERVICE</strong></td>
                        <td style="width: 17.5995%; font-size: 10px;"><strong>CLIENTE NAME</strong></td>
                        <td style="width: 14.0908%; font-size: 10px;"><strong>RATE</strong></td>
                        <td style="width: 13.506%; font-size: 10px;"><strong>UNITS</strong></td>
                        <td style="width: 13.311%; font-size: 10px;"><strong>HOURS</strong></td>
                        <td style="width: 14.2857%; font-size: 10px;"><strong>AMOUNT</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataPagos as $key => $value)
                        <tr id="{{ $key }}">
                            <td style="width: 5.12391%; font-size: 10px;">{{ $key + 1 }}</td>
                            <td style="width: 22.083%; font-size: 10px;">{{ $value['service_and_sub_service'] ? $value['service_and_sub_service'] : 'N/A' }}</td>
                            <td style="width: 17.5995%; font-size: 10px;">{{ $value['patiente_full_name'] ? $value['patiente_full_name'] : 'N/A'}}</td>
                            <td style="width: 14.0908%; font-size: 10px;">{{ $value['unidad_time_worker'] ? $value['unidad_time_worker'] : 'N/A' }} {{ $value['unidad_type_worker'] ? $value['unidad_type_worker'] : 'N/A' }} = {{ $value['unit_value_worker'] ? $value['unit_value_worker'] : '' }} $ (USD)</td>
                            <td style="width: 13.506%; font-size: 10px;">{{ $value['unid_pay_worker'] ? $value['unid_pay_worker'] : 'N/A' }}</td>
                            <td style="width: 13.311%; font-size: 10px;">{{ $value['time_attention'] ? $value['time_attention'] : 'N/A'}}</td>
                            <td style="width: 14.2857%; font-size: 10px;">{{ $value['mont_pay'] ? $value['mont_pay'] : 'N/A' }} $ (USD)</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="text-align: right; font-size: 10px;">Total: {{ number_format((float)$montoTotal, 2, '.', '') }} $ (USD)</p>
        </body>
    </html>
        
=======
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                
                <title>1099 FORM</title>
            </head>
            <body style="margin-top: -25px !important;">
<<<<<<< HEAD
        <p>&nbsp;</p>
<p>&nbsp;</p>
<p></p>
<p style="text-align: center;">1099 CONTRACTOR BALANCE DETAIL REPORT</p>
<p style="text-align: center;">ETF AND CHECK</p>
<table style="border-collapse: collapse; width: 100%; height: 36px;" border="1">
=======
        <div>&nbsp;</div>
<div><br />@foreach($dataPagos as $key => $value)@endforeach
<table style="border-collapse: collapse; width: 58.1174%; height: 378px;" border="1">
>>>>>>> 553ab6732 (correcciones de JP a los docs)
<tbody>
<tr style="height: 18px;">
<td style="width: 33.3333%; height: 36px;" rowspan="2">DATE PERIOD:</td>
<td style="width: 33.3333%; height: 18px;">START</td>
<td style="width: 33.3333%; height: 18px;">END</td>
</tr>
<tr style="height: 18px;">
<<<<<<< HEAD
<td style="width: 33.3333%; height: 18px;">{{ $desde }}</td>
<td style="width: 33.3333%; height: 18px;">{{ $hasta }}</td>
=======
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">&nbsp;</td>
<td style="width: 5.11075%; height: 18px;">&nbsp;</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 36px;">
<td style="width: 4.37269%; height: 36px;">&nbsp;</td>
<td style="width: 25.1844%; height: 36px; text-align: center;" colspan="5">1099 CONTRACTOR BALANCE DETAIL REPORT</td>
<td style="width: 1.5674%; height: 36px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">&nbsp;</td>
<td style="width: 5.11075%; height: 18px;">&nbsp;</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 25.1844%; height: 18px; text-align: center;" colspan="5">ETF AND CHECK</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">&nbsp;</td>
<td style="width: 5.11075%; height: 18px;">&nbsp;</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;DATE PAY:</td>
<td style="width: 1.5674%; height: 18px;">{{ $datePai }}</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">&nbsp;</td>
<td style="width: 5.11075%; height: 18px;">START</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">END</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">DATE PERIOD:</td>
<td style="width: 5.11075%; height: 18px;">{{ $desde }}</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">{{ $hasta }}</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">VENDOR CODE:</td>
<td style="width: 5.11075%; height: 18px;">{{ $vendorCode }}</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">EFT OR CHECK:</td>
<td style="width: 5.11075%; height: 18px;">{{ $eftorCheck }}</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">&nbsp;</td>
<td style="width: 5.11075%; height: 18px;">&nbsp;</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 25.1844%; height: 18px; text-align: center;" colspan="5">VENDOR / PAYEE INFORMATION</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr>
<td style="width: 4.37269%;">&nbsp;</td>
<td style="width: 10.2767%;">Name:</td>
<td style="width: 5.11075%;">{{ $fullName }}.</td>
<td style="width: 7.14017%;">&nbsp;</td>
<td style="width: 1.5873%;">&nbsp;</td>
<td style="width: 1.06951%;">&nbsp;</td>
<td style="width: 1.5674%;">&nbsp;</td>
</tr>
<tr>
<td style="width: 4.37269%;">&nbsp;</td>
<td style="width: 10.2767%;">BUSSINES NAME:</td>
<td style="width: 5.11075%;">{{ $fullNameCompani }}.</td>
<td style="width: 7.14017%;">&nbsp;</td>
<td style="width: 1.5873%;">&nbsp;</td>
<td style="width: 1.06951%;">&nbsp;</td>
<td style="width: 1.5674%;">&nbsp;</td>
</tr>
<tr>
<td style="width: 4.37269%;">&nbsp;</td>
<td style="width: 10.2767%;">ADDRES:</td>
<td style="width: 15.3875%;">{{ $addres }}</td>
<td style="width: 1.5873%;">&nbsp;</td>
<td style="width: 1.06951%;">&nbsp;</td>
<td style="width: 1.5674%;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">&nbsp;</td>
<td style="width: 5.11075%; height: 18px;">&nbsp;</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 25.1844%; height: 18px; text-align: center;" colspan="5">INVOICE INFORMATION</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">INVOICE NUMBER:</td>
<td style="width: 5.11075%; height: 18px;">{{ $invoiceNumber }}</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">&nbsp;</td>
<td style="width: 5.11075%; height: 18px;">&nbsp;</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">Current Service</td>
<td style="width: 5.11075%; height: 18px;">Client Name</td>
<td style="width: 7.14017%; height: 18px;">Rate</td>
<td style="width: 1.5873%; height: 18px;">Units</td>
<td style="width: 1.06951%; height: 18px;">Hours</td>
<td style="width: 1.5674%; height: 18px;">Amount</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">{{ $key + 1 }}</td>
<td style="width: 10.2767%; height: 18px;">{{ $value['service_and_sub_service'] }}</td>
<td style="width: 5.11075%; height: 18px;">{{ $value['patiente_full_name'] }}</td>
<td style="width: 7.14017%; height: 18px;">{{ $value['unidad_time_worker'] }} {{ $value['unidad_type_worker'] }} = {{ $value['unit_value_worker'] }} $ (USD)</td>
<td style="width: 1.5873%; height: 18px;">{{ $value['unid_pay_worker'] }}</td>
<td style="width: 1.06951%; height: 18px;">{{ $value['time_attention']}}</td>
<td style="width: 1.5674%; height: 18px;">{{ $value['mont_pay'] }} $ (USD)</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">&nbsp;</td>
<td style="width: 5.11075%; height: 18px;">&nbsp;</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">&nbsp;</td>
<td style="width: 5.11075%; height: 18px;">&nbsp;</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">&nbsp;</td>
<td style="width: 1.5674%; height: 18px;">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 4.37269%; height: 18px;">&nbsp;</td>
<td style="width: 10.2767%; height: 18px;">&nbsp;</td>
<td style="width: 5.11075%; height: 18px;">&nbsp;</td>
<td style="width: 7.14017%; height: 18px;">&nbsp;</td>
<td style="width: 1.5873%; height: 18px;">&nbsp;</td>
<td style="width: 1.06951%; height: 18px;">TOTAL</td>
<td style="width: 1.5674%; height: 18px;">{{ $montoTotal }}</td>
>>>>>>> 553ab6732 (correcciones de JP a los docs)
</tr>
</tbody>
</table>
<p>VENDOR CODE: {{ $vendorCode }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; DATE PAY: {{ $datePai }}</p>
<p>EFT OR CHECK: {{ $eftorCheck }}</p>
<p style="text-align: center;"><br />VENDOR / PAYEE INFORMATION</p>
<p>NANE: {{ $fullName }}.</p>
<p>BUSINESS NAME: {{ $fullNameCompani }}.</p>
<p>ADDRESS: {{ $addres }}</p>
<p style="text-align: center;"><br />INVOICE INFORMATION</p>
<p style="text-align: left;">INVOICE NUMBER: {{ $invoiceNumber }}</p>
<p>@foreach($dataPagos as $key => $value)@endforeach</p>
<table style="border-collapse: collapse; width: 100%;" border="1">
<thead>
<tr>
<td style="width: 5.12391%;">N#</td>
<td style="width: 22.083%;">Current Service</td>
<td style="width: 17.5995%;">Client Name</td>
<td style="width: 14.0908%;">Rate</td>
<td style="width: 13.506%;">Units</td>
<td style="width: 13.311%;">Hours</td>
<td style="width: 14.2857%;">Amount</td>
</tr>
</thead>
<tbody>
<tr id="{{ $key }}">
<td style="width: 5.12391%;">{{ $key + 1 }}</td>
<td style="width: 22.083%;">{{ $value['service_and_sub_service'] }}</td>
<td style="width: 17.5995%;">{{ $value['patiente_full_name'] }}</td>
<td style="width: 14.0908%;">{{ $value['unidad_time_worker'] }} {{ $value['unidad_type_worker'] }} = {{ $value['unit_value_worker'] }} $ (USD)</td>
<td style="width: 13.506%;">{{ $value['unid_pay_worker'] }}</td>
<td style="width: 13.311%;">{{ $value['time_attention']}}</td>
<td style="width: 14.2857%;">{{ $value['mont_pay'] }} $ (USD)</td>
</tr>
</tbody>
</table>
<p style="text-align: right;">Total: {{ $montoTotal[0] }} $ (USD)</p>
            </body>
        </html>
>>>>>>> 832294359 (correcciones de JP a los docs)
