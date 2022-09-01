
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                
                <title>1099 FORM</title>
            </head>
            <body style="margin-top: -25px !important;">
        <p>&nbsp;</p>
<p>&nbsp;</p>
<p></p>
<p style="text-align: center;">1099 CONTRACTOR BALANCE DETAIL REPORT</p>
<p style="text-align: center;">ETF AND CHECK</p>
<table style="border-collapse: collapse; width: 100%; height: 36px;" border="1">
<tbody>
<tr style="height: 18px;">
<td style="width: 33.3333%; height: 36px;" rowspan="2">DATE PERIOD:</td>
<td style="width: 33.3333%; height: 18px;">START</td>
<td style="width: 33.3333%; height: 18px;">END</td>
</tr>
<tr style="height: 18px;">
<td style="width: 33.3333%; height: 18px;">{{ $desde }}</td>
<td style="width: 33.3333%; height: 18px;">{{ $hasta }}</td>
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
        