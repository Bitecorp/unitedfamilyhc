
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                
                <title>yy</title>
            </head>
            <body style="margin-top: -25px !important;">
        <table id="tableVariables" class="table table-striped table-bordered table-td-valign-middle dataTable no-footer" style="width: 456px;" aria-describedby="tableVariables_info">
<tbody>
<tr class="odd">
<td class="sorting_1" style="width: 145.562px;">Full Name Worker/Companie</td>
<td style="width: 294.438px;">{{ $fullName }}</td>
</tr>
<tr class="even">
<td class="sorting_1" style="width: 145.562px;">Worker / Alternate Phone</td>
<td style="width: 294.438px;">{{ isset($worker->alternate_phone) ? $worker->alternate_phone : "" }}</td>
</tr>
<tr class="odd">
<td class="sorting_1" style="width: 145.562px;">Worker / Apartment Unit</td>
<td style="width: 294.438px;">{{ $worker->apartment_unit }}</td>
</tr>
<tr class="even">
<td class="sorting_1" style="width: 145.562px;">Worker / Birth Date</td>
<td style="width: 294.438px;">{{ $worker->birth_date }}</td>
</tr>
<tr class="odd">
<td class="sorting_1" style="width: 145.562px;">Worker / City</td>
<td style="width: 294.438px;">{{ $worker->city }}</td>
</tr>
<tr class="even">
<td class="sorting_1" style="width: 145.562px;">Worker / Confirmation Independen / Companie / Alternate Phone</td>
<td style="width: 294.438px;">{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) && isset($companie->alternate_phone) ? $companie->alternate_phone : "" }}</td>
</tr>
<tr class="odd">
<td class="sorting_1" style="width: 145.562px;">Worker / Confirmation Independen / Companie / Apartment Unit</td>
<td style="width: 294.438px;">{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->apartment_unit : "" }}</td>
</tr>
<tr class="even">
<td class="sorting_1" style="width: 145.562px;">Worker / Confirmation Independen / Companie / City</td>
<td style="width: 294.438px;">{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->city : "" }}</td>
</tr>
<tr class="odd">
<td class="sorting_1" style="width: 145.562px;">Worker / Confirmation Independen / Companie / Email</td>
<td style="width: 294.438px;">{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->email : "" }}</td>
</tr>
<tr class="even">
<td class="sorting_1" style="width: 145.562px;">Worker / Confirmation Independen / Companie / Home Phone</td>
<td style="width: 294.438px;">{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->home_phone : "" }}</td>
</tr>
</tbody>
</table>
<table id="tableVariables" class="table table-striped table-bordered table-td-valign-middle dataTable no-footer" aria-describedby="tableVariables_info">
<tbody>
<tr class="odd">
<td class="sorting_1">Worker / Confirmation Independen / Companie / Name</td>
<td>{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $worker->last_name : "" }}</td>
</tr>
<tr class="even">
<td class="sorting_1">Worker / Confirmation Independen / Companie / SSN</td>
<td>{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->ssn : "" }}</td>
</tr>
<tr class="odd">
<td class="sorting_1">Worker / Confirmation Independen / Companie / State</td>
<td>{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->state : "" }}</td>
</tr>
<tr class="even">
<td class="sorting_1">Worker / Confirmation Independen / Companie / Street Addres</td>
<td>{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->street_addres : "" }}</td>
</tr>
<tr class="odd">
<td class="sorting_1">Worker / Confirmation Independen / Companie / Zip Code</td>
<td>{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->zip_code : "" }}</td>
</tr>
<tr class="even">
<td class="sorting_1">Worker / Confirmation Independent (options)</td>
<td>{{ $confirmation_independent->independent_contractor == 1 ? "Independent Contractor" : "W2 Worker" }}</td>
</tr>
<tr class="odd">
<td class="sorting_1">Worker / Contact Emergencys / Alternate Phone</td>
<td>{{ isset($contact_emergency->alternate_phone) ? $contact_emergency->alternate_phone : "" }}</td>
</tr>
<tr class="even">
<td class="sorting_1">Worker / Contact Emergencys / Apartment Unit</td>
<td>{{ $contact_emergency->apartment_unit }}</td>
</tr>
<tr class="odd">
<td class="sorting_1">Worker / Contact Emergencys / City</td>
<td>{{ $contact_emergency->city }}</td>
</tr>
<tr class="even">
<td class="sorting_1">Worker / Contact Emergencys / First Name</td>
<td>{{ $contact_emergency->first_name }}</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<p>@foreach($services as $key => $service) @if($service->id == 1)</p>
<p>{{ $service->name_service }}</p>
<p>@endif @endforeach</p>
            </body>
        </html>
        