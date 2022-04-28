
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                
                <style>
                    @page {
                        margin-top: 1.3in;
                        margin-left: 0.8in;
                        margin-right: 0.8in;
                        margin-bottom: 1in;
                    }
                    body {
                        background-color: rgba(0,0,0,0);
                    }
                    body:before {
                        display: block;
                        position: fixed;
                        top: -1in; right: -1in; bottom: -1in; left: -1in;
                        background-image: url(filesUsers/Background_Plain.jpg);
                        background-size: 100% 100%;
                        background-repeat: no-repeat;
                        margin: -20px 15px 15px 10px !important;
                        content: "";
                        z-index: -1000;
                    }
                </style>
                <title>Independent Contractor Resume</title>
            </head>
            <body>
        <p style="text-align: center;"><span style="font-size: 12pt; font-family: 'book antiqua', palatino, serif;">INDEPENDENT CONTRACTOR INFORMATION</span></p>
<table style="border-collapse: collapse; width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 100%; text-align: center;"><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">PERSONAL INFORMATION</span></td>
</tr>
</tbody>
</table>
<p><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">FULL NAME: {{ $worker->first_name }} {{ isset($worker->mi) ? $worker->mi : "" }} {{ $worker->last_name }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">ADDRESS: {{ $worker->street_addres }}, APARTMENT/UNIT: {{ $worker->apartment_unit }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">CITY: {{ $worker->city }}, STATE: {{ $worker->state }}, ZIP CODE: {{ $worker->zip_code }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">HOME PHONE: {{ $worker->home_phone }}, ALTERNATE PHONE: {{ isset($worker->alternate_phone) ? $worker->alternate_phone : "" }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">SSN: {{ $worker->ssn }} BIRTH DATE: {{ $worker->birth_date }} MARITAL STATUS: {{ $maritalStatus->name_marital_status }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">EMAIL: {{ $worker->email }}</span></p>
<table style="border-collapse: collapse; width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 100%; text-align: center;"><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">EMERGENCY CONTACT INFORMATION</span></td>
</tr>
</tbody>
</table>
<p><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">FULL NAME: {{ $contact_emergency->first_name }} {{ isset($contact_emergency->mi) ? $contact_emergency->mi : "" }} {{ $contact_emergency->last_name }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">ADDRESS: {{ $contact_emergency->street_addres }}, APARTMENT/UNIT: {{ $contact_emergency->apartment_unit }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">CITY: {{ $contact_emergency->city }}, STATE: {{ $contact_emergency->state }}, ZIP CODE: {{ $contact_emergency->zip_code }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">HOME PHONE: {{ $contact_emergency->home_phone }}, ALTERNATE PHONE: {{ isset($contact_emergency->alternate_phone) ? $contact_emergency->alternate_phone : "" }}</span></p>
<table style="border-collapse: collapse; width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 100%; text-align: center;"><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">JOB INFORMATION</span></td>
</tr>
</tbody>
</table>
<p><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">TITLE: {{ $job_information->title }}.&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; SALARY: @foreach($services as $key => $service) @foreach($salaryServices as $keySalary => $salaryService) @if($service->id == $salaryService->service_id) {{ $salaryService->salary }}{{ $salaryService->type_salary == 0 ? "$ Monthly" : "$ Per Hour"}} @endif @endforeach @endforeach</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">SUPERVISOR: {{ $supervisor->first_name }} {{ $supervisor->last_name }} </span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">WORK NAME AND LOCATION: {{ $location->name_location }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">WORK PHONE: {{ $job_information->work_phone }}</span></p>
<table style="border-collapse: collapse; width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 100%; text-align: center;"><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">EDUCATION</span></td>
</tr>
</tbody>
</table>
<p><span style="font-family: 'book antiqua', palatino, serif; font-size: 10pt;">HIGH SCHOOL: {{ $education->high_school }}</span><br /><span style="font-family: 'book antiqua', palatino, serif; font-size: 10pt;">COLLEGE/UNIVERSITY: {{ isset($education->college_university) ? $education->college_university : "" }}</span></p>
<table style="border-collapse: collapse; width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 100%; text-align: center;"><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">REFERENCES</span></td>
</tr>
</tbody>
</table>
<p><span style="font-family: 'book antiqua', palatino, serif; font-size: 10pt;">NAME: {{ $reference_personal_one->name_job }}</span><br /><span style="font-family: 'book antiqua', palatino, serif; font-size: 10pt;">ADDRESS: {{ $reference_personal_one->address }}</span><br /><span style="font-family: 'book antiqua', palatino, serif; font-size: 10pt;">TELEPHONE: {{ $reference_personal_one->phone }}, OCCUPATION: {{ $reference_personal_one->ocupation }}, YEARS KNOWN: {{ $reference_personal_one->time }}</span></p>
<p><span style="font-family: 'book antiqua', palatino, serif; font-size: 10pt;">NAME: {{ $reference_personal_two->name_job }}</span><br /><span style="font-family: 'book antiqua', palatino, serif; font-size: 10pt;">ADDRESS: {{ $reference_personal_two->address }}</span><br /><span style="font-family: 'book antiqua', palatino, serif; font-size: 10pt;">TELEPHONE: {{ $reference_personal_two->phone }}, OCCUPATION: {{ $reference_personal_two->ocupation }}, YEARS KNOWN: {{ $reference_personal_two->time }}</span></p>
<table style="border-collapse: collapse; width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 100%; text-align: center;"><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">EMPLOYMENT</span></td>
</tr>
</tbody>
</table>
<p><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">EMPLOYER NAME AND ADDRESS: {{ isset($reference_job_one->name_and_address) ? $reference_job_one->name_and_address : "" }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">POSITION TITLE/DUTIES SKILLS: {{ isset($reference_job_one->position) ? $reference_job_one->position : "" }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">SUPERVISOR&rsquo;S NAME: {{ isset($reference_job_one->supervisor) ? $reference_job_one->supervisor : "" }}, TELEPHONE: {{ isset($reference_job_one->phone_supervisor) ? $reference_job_one->phone_supervisor : "" }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">DATES EMPLOYED FROM: {{ isset($reference_job_one->dates_employed) ? $reference_job_one->dates_employed : "" }} TO: {{ isset($reference_job_one->to_dates_employed) ? $reference_job_one->to_dates_employed : "" }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">REASON FOR LEAVING: {{ isset($reference_job_one->reason_leaving) ? $reference_job_one->reason_leaving : "" }}</span></p>
<p><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">EMPLOYER NAME AND ADDRESS: {{ isset($reference_job_two->name_and_address) ? $reference_job_two->name_and_address : "" }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">POSITION TITLE/DUTIES SKILLS: {{ isset($reference_job_two->position) ? $reference_job_two->position : "" }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">SUPERVISOR&rsquo;S NAME: {{ isset($reference_job_two->supervisor) ? $reference_job_two->supervisor : "" }}, TELEPHONE: {{ isset($reference_job_two->phone_supervisor) ? $reference_job_two->phone_supervisor : "" }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">DATES EMPLOYED FROM: {{ isset($reference_job_two->dates_employed) ? $reference_job_two->dates_employed : "" }}, TO: {{ isset($reference_job_two->to_dates_employed) ? $reference_job_two->to_dates_employed : "" }}</span><br /><span style="font-size: 10pt; font-family: 'book antiqua', palatino, serif;">REASON FOR LEAVING: {{ isset($reference_job_two->reason_leaving) ? $reference_job_two->reason_leaving : "" }}</span></p>
<p><span style="font-family: 'book antiqua', palatino, serif;"><span style="font-size: 10pt;">INDEPENDENT CONTRACTOR SIGNATURE:</span><span style="font-size: 10pt;">_____________________________________________</span></span></p>
            </body>
        </html>
        