
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                
               
                <title>Independent Contractor Personal Information List</title>
            </head>
            <body style="margin-top: -25px !important;">
        <h1 style="text-align: center;"><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;">INDEPENDENT CONTRACTOR INFORMATION</span></h1>
<p>&nbsp;</p>
<table style="border-collapse: collapse; width: 100%; height: 34px;" border="1">
<tbody>
<tr style="height: 34px;">
<td style="width: 100%; text-align: center; height: 34px;">
<div><span style="font-size: 12pt;"><strong><span style="font-family: 'book antiqua', palatino, serif;">PERSONAL INFORMATION</span></strong></span></div>
</td>
</tr>
</tbody>
</table>
<p><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>FULL NAME:</strong> {{ $worker->first_name }} {{ isset($worker->mi) ? $worker->mi : "" }} {{ $worker->last_name }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>ADDRESS:</strong> {{ $worker->street_addres }}, <strong>APARTMENT/UNIT:</strong> {{ $worker->apartment_unit }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>CITY:</strong> {{ $worker->city }}, <strong>STATE:</strong> {{ $worker->state }}, <strong>ZIP CODE:</strong> {{ $worker->zip_code }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>HOME PHONE:</strong> {{ $worker->home_phone }}, <strong>ALTERNATE PHONE:</strong> {{ isset($worker->alternate_phone) ? $worker->alternate_phone : "" }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>SSN:</strong> {{ $worker->ssn }} <strong>BIRTH DATE:</strong> {{ $worker->birth_date }}<strong> MARITAL STATUS:</strong> {{ $maritalStatus->name_marital_status }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>EMAIL:</strong> {{ $worker->email }}</span></p>
<p>&nbsp;</p>
<table style="border-collapse: collapse; width: 100%; height: 31px;" border="1">
<tbody>
<tr style="height: 31px;">
<td style="width: 100%; text-align: center; height: 31px;">
<div><span style="font-size: 12pt;"><strong><span style="font-family: 'book antiqua', palatino, serif;">EMERGENCY CONTACT INFORMATION</span></strong></span></div>
</td>
</tr>
</tbody>
</table>
<p><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>FULL NAME:</strong> {{ $contact_emergency->first_name }} {{ isset($contact_emergency->mi) ? $contact_emergency->mi : "" }} {{ $contact_emergency->last_name }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>ADDRESS:</strong> {{ $contact_emergency->street_addres }}, <strong>APARTMENT/UNIT:</strong> {{ $contact_emergency->apartment_unit }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>CITY:</strong> {{ $contact_emergency->city }}, <strong>STATE:</strong> {{ $contact_emergency->state }}, <strong>ZIP CODE:</strong> {{ $contact_emergency->zip_code }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>HOME PHONE:</strong> {{ $contact_emergency->home_phone }}, <strong>ALTERNATE PHONE:</strong> {{ isset($contact_emergency->alternate_phone) ? $contact_emergency->alternate_phone : "" }}</span></p>
<p>&nbsp;</p>
<table style="border-collapse: collapse; width: 100%; height: 33px;" border="1">
<tbody>
<tr style="height: 33px;">
<td style="width: 100%; text-align: center; height: 33px;">
<div><span style="font-size: 12pt;"><strong><span style="font-family: 'book antiqua', palatino, serif;">JOB INFORMATION</span></strong></span></div>
</td>
</tr>
</tbody>
</table>
<p><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>TITLE:</strong> {{ $job_information->title }}.&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <strong>SALARY:</strong> @foreach($services as $key => $service) @foreach($salaryServices as $keySalary => $salaryService) @if($service->id == $salaryService->service_id) {{ $salaryService->salary }}{{ $salaryService->type_salary == 0 ? "$ Monthly" : "$ Per Hour"}} @endif @endforeach @endforeach</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>SUPERVISOR:</strong> {{ $supervisor->first_name }} {{ $supervisor->last_name }} </span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>WORK NAME AND LOCATION:</strong> {{ $location->name_location }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>WORK PHONE:</strong> {{ $job_information->work_phone }}</span></p>
<p>&nbsp;</p>
<table style="border-collapse: collapse; width: 100%; height: 30px;" border="1">
<tbody>
<tr style="height: 30px;">
<td style="width: 100%; text-align: center; height: 30px;">
<div><span style="font-size: 12pt;"><strong><span style="font-family: 'book antiqua', palatino, serif;">EDUCATION</span></strong></span></div>
</td>
</tr>
</tbody>
</table>
<p><span style="font-family: 'book antiqua', palatino, serif; font-size: 12pt;"><strong>HIGH SCHOOL:</strong> {{ $education->high_school }}</span><br /><span style="font-family: 'book antiqua', palatino, serif; font-size: 12pt;"><strong>COLLEGE/UNIVERSITY:</strong> {{ isset($education->college_university) ? $education->college_university : "" }}</span></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table style="border-collapse: collapse; width: 100%; height: 35px;" border="1">
<tbody>
<tr style="height: 35px;">
<td style="width: 100%; text-align: center; height: 35px;">
<div><span style="font-size: 12pt;"><strong><span style="font-family: 'book antiqua', palatino, serif;">REFERENCES</span></strong></span></div>
</td>
</tr>
</tbody>
</table>
<p><span style="font-family: 'book antiqua', palatino, serif; font-size: 12pt;"><strong>NAME:</strong> {{ $reference_personal_one->name_job }}</span><br /><span style="font-family: 'book antiqua', palatino, serif; font-size: 12pt;"><strong>ADDRESS:</strong> {{ $reference_personal_one->address }}</span><br /><span style="font-family: 'book antiqua', palatino, serif; font-size: 12pt;"><strong>TELEPHONE:</strong> {{ $reference_personal_one->phone }}, <strong>OCCUPATION:</strong> {{ $reference_personal_one->ocupation }}, <strong>YEARS KNOWN:</strong> {{ $reference_personal_one->time }}</span></p>
<p><span style="font-family: 'book antiqua', palatino, serif; font-size: 12pt;"><strong>NAME:</strong> {{ $reference_personal_two->name_job }}</span><br /><span style="font-family: 'book antiqua', palatino, serif; font-size: 12pt;"><strong>ADDRESS:</strong> {{ $reference_personal_two->address }}</span><br /><span style="font-family: 'book antiqua', palatino, serif; font-size: 12pt;"><strong>TELEPHONE:</strong> {{ $reference_personal_two->phone }}, <strong>OCCUPATION:</strong> {{ $reference_personal_two->ocupation }}, <strong>YEARS KNOWN:</strong> {{ $reference_personal_two->time }}</span></p>
<p>&nbsp;</p>
<table style="border-collapse: collapse; width: 100%; height: 37px;" border="1">
<tbody>
<tr style="height: 37px;">
<td style="width: 100%; text-align: center; height: 37px;">
<div><span style="font-size: 12pt;"><strong><span style="font-family: 'book antiqua', palatino, serif;">EMPLOYMENT</span></strong></span></div>
</td>
</tr>
</tbody>
</table>
<p><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>EMPLOYER NAME AND ADDRESS:</strong> {{ isset($reference_job_one->name_and_address) ? $reference_job_one->name_and_address : "" }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>POSITION TITLE/DUTIES SKILLS:</strong> {{ isset($reference_job_one->position) ? $reference_job_one->position : "" }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>SUPERVISOR&rsquo;S NAME:</strong> {{ isset($reference_job_one->supervisor) ? $reference_job_one->supervisor : "" }},<strong> TELEPHONE:</strong> {{ isset($reference_job_one->phone_supervisor) ? $reference_job_one->phone_supervisor : "" }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>DATES EMPLOYED FROM:</strong> {{ isset($reference_job_one->dates_employed) ? $reference_job_one->dates_employed : "" }} <strong>TO:</strong> {{ isset($reference_job_one->to_dates_employed) ? $reference_job_one->to_dates_employed : "" }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>REASON FOR LEAVING:</strong> {{ isset($reference_job_one->reason_leaving) ? $reference_job_one->reason_leaving : "" }}</span></p>
<p><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>EMPLOYER NAME AND ADDRESS:</strong> {{ isset($reference_job_two->name_and_address) ? $reference_job_two->name_and_address : "" }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>POSITION TITLE/DUTIES SKILLS:</strong> {{ isset($reference_job_two->position) ? $reference_job_two->position : "" }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>SUPERVISOR&rsquo;S NAME:</strong> {{ isset($reference_job_two->supervisor) ? $reference_job_two->supervisor : "" }}, <strong>TELEPHONE:</strong> {{ isset($reference_job_two->phone_supervisor) ? $reference_job_two->phone_supervisor : "" }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>DATES EMPLOYED FROM:</strong> {{ isset($reference_job_two->dates_employed) ? $reference_job_two->dates_employed : "" }}, <strong>TO:</strong> {{ isset($reference_job_two->to_dates_employed) ? $reference_job_two->to_dates_employed : "" }}</span><br /><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;"><strong>REASON FOR LEAVING:</strong> {{ isset($reference_job_two->reason_leaving) ? $reference_job_two->reason_leaving : "" }}</span></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><span style="font-family: 'book antiqua', palatino, serif; font-size: 12pt;">_____________________________________________</span></p>
<p><span style="font-family: 'book antiqua', palatino, serif; font-size: 12pt;">INDEPENDENT CONTRACTOR SIGNATURE</span></p>
<p>&nbsp;</p>
            </body>
        </html>
        