<?php
    $variables = [
        [
            'dato' => 'Full Name Worker/Companie',
            'llamado' => '{{ $fullName }}'
        ],
        [
            'dato' => 'Worker / First Name',
            'llamado' => '{{ $worker->first_name }}'
        ],
        [
            'dato' => 'Worker / Last Name',
            'llamado' => '{{ $worker->last_name }}'
        ],
        [
            'dato' => 'Worker / MI',
            'llamado' => '{{ isset($worker->mi) ? $worker->mi : "" }}'
        ],
        [
            'dato' => 'Worker / SSN',
            'llamado' => '{{ $worker->ssn }}'
        ],
        [
            'dato' => 'Worker / Street Addres',
            'llamado' => '{{ $worker->street_addres }}'
        ],
        [
            'dato' => 'Worker / Apartment Unit',
            'llamado' => '{{ $worker->apartment_unit }}'
        ],
        [
            'dato' => 'Worker / City',
            'llamado' => '{{ $worker->city }}'
        ],
        [
            'dato' => 'Worker / State',
            'llamado' => '{{ $worker->state }}'
        ],
        [
            'dato' => 'Worker / Zip Code',
            'llamado' => '{{ $worker->zip_code }}'
        ],
        [
            'dato' => 'Worker / Home Phone',
            'llamado' => '{{ $worker->home_phone }}'
        ],
        [
            'dato' => 'Worker / Alternate Phone',
            'llamado' => '{{ isset($worker->alternate_phone) ? $worker->alternate_phone : "" }}'
        ],
        [
            'dato' => 'Worker / Birth Date',
            'llamado' => '{{ $worker->birth_date }}'
        ],
        [
            'dato' => 'Worker / Marital Status',
            'llamado' => '{{ $maritalStatus->name_marital_status }}'
        ],
        [
            'dato' => 'Worker / Email',
            'llamado' => '{{ $worker->email }}'
        ],
        [
            'dato' => 'Worker / Role',
            'llamado' => '{{ $role->name_role }}'
        ],
        [
            'dato' => 'Worker / Contact Emergencys / First Name',
            'llamado' => '{{ $contact_emergency->first_name }}'
        ],
        [
            'dato' => 'Worker / Contact Emergencys / Last Name',
            'llamado' => '{{ $contact_emergency->last_name }}'
        ],
        [
            'dato' => 'Worker / Contact Emergencys / MI',
            'llamado' => '{{ isset($contact_emergency->mi) ? $contact_emergency->mi : "" }}'
        ],
        [
            'dato' => 'Worker / Contact Emergencys / Street Addres',
            'llamado' => '{{ $contact_emergency->street_addres }}'
        ],
        [
            'dato' => 'Worker / Contact Emergencys / Apartment Unit',
            'llamado' => '{{ $contact_emergency->apartment_unit }}'
        ],
        [
            'dato' => 'Worker / Contact Emergencys / City',
            'llamado' => '{{ $contact_emergency->city }}'
        ],
        [
            'dato' => 'Worker / Contact Emergencys / State',
            'llamado' => '{{ $contact_emergency->state }}'
        ],
        [
            'dato' => 'Worker / Contact Emergencys / Zip Code',
            'llamado' => '{{ $contact_emergency->zip_code }}'
        ],
        [
            'dato' => 'Worker / Contact Emergencys / Home Phone',
            'llamado' => '{{ $contact_emergency->home_phone }}'
        ],
        [
            'dato' => 'Worker / Contact Emergencys / Alternate Phone',
            'llamado' => '{{ isset($contact_emergency->alternate_phone) ? $contact_emergency->alternate_phone : "" }}'
        ],
        [
            'dato' => 'Worker / Job Information / Title',
            'llamado' => '{{ $job_information->title }}'
        ],
        [
            'dato' => 'Worker / Job Information / Supervisor ',
            'llamado' => '{{ $supervisor->first_name }} {{ $supervisor->last_name }}'
        ],
        [
            'dato' => 'Worker / Job Information / Work Name Location ',
            'llamado' => '{{ $location->name_location }}'
        ],
        [
            'dato' => 'Worker / Job Information / Work Phone ',
            'llamado' => '{{ $job_information->work_phone }}'
        ],
        [
            'dato' => 'Worker / Education / High School',
            'llamado' => '{{ $education->high_school }}'
        ],
        [
            'dato' => 'Worker / Education / College University',
            'llamado' => '{{ isset($education->college_university) ? $education->college_university : "" }}'
        ],
        [
            'dato' => 'Worker / Reference Personal N#1 / Name Job',
            'llamado' => '{{ $reference_personal_one->name_job }}'
        ],
        [
            'dato' => 'Worker / Reference Personal N#1 / Address',
            'llamado' => '{{ $reference_personal_one->address }}'
        ],
        [
            'dato' => 'Worker / Reference Personal N#1 / Phone',
            'llamado' => '{{ $reference_personal_one->phone }}'
        ],
        [
            'dato' => 'Worker / Reference Personal N#1 / Ocupation',
            'llamado' => '{{ $reference_personal_one->ocupation }}'
        ],
        [
            'dato' => 'Worker / Reference Personal N#1 / Time',
            'llamado' => '{{ $reference_personal_one->time }}'
        ],
        [
            'dato' => 'Worker / Reference Personal N#2 / Name Job',
            'llamado' => '{{ $reference_personal_two->name_job }}'
        ],
        [
            'dato' => 'Worker / Reference Personal N#2 / Address',
            'llamado' => '{{ $reference_personal_two->address }}'
        ],
        [
            'dato' => 'Worker / Reference Personal N#2 / Phone',
            'llamado' => '{{ $reference_personal_two->phone }}'
        ],
        [
            'dato' => 'Worker / Reference Personal N#2 / Ocupation',
            'llamado' => '{{ $reference_personal_two->ocupation }}'
        ],
        [
            'dato' => 'Worker / Reference Personal N#2 / Time',
            'llamado' => '{{ $reference_personal_two->time }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#1 / Position',
            'llamado' => '{{ isset($reference_job_one->position) ? $reference_job_one->position : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#1 / Name and Address',
            'llamado' => '{{ isset($reference_job_one->name_and_address) ? $reference_job_one->name_and_address : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#1 / Supervisor',
            'llamado' => '{{ isset($reference_job_one->supervisor) ? $reference_job_one->supervisor : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#1 / Phone Supervisor',
            'llamado' => '{{ isset($reference_job_one->phone_supervisor) ? $reference_job_one->phone_supervisor : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#1 / To Dates Employed',
            'llamado' => '{{ isset($reference_job_one->to_dates_employed) ? $reference_job_one->to_dates_employed : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#1 / Dates Employed',
            'llamado' => '{{ isset($reference_job_one->dates_employed) ? $reference_job_one->dates_employed : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#1 / Reason Leaving',
            'llamado' => '{{ isset($reference_job_one->reason_leaving) ? $reference_job_one->reason_leaving : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#2 / Position',
            'llamado' => '{{ isset($reference_job_two->position) ? $reference_job_two->position : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#2 / Name and Address',
            'llamado' => '{{ isset($reference_job_two->name_and_address) ? $reference_job_two->name_and_address : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#2 / Supervisor',
            'llamado' => '{{ isset($reference_job_two->supervisor) ? $reference_job_two->supervisor : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#2 / Phone Supervisor',
            'llamado' => '{{ isset($reference_job_two->phone_supervisor) ? $reference_job_two->phone_supervisor : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#2 / To Dates Employed',
            'llamado' => '{{ isset($reference_job_two->to_dates_employed) ? $reference_job_two->to_dates_employed : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#2 / Dates Employed',
            'llamado' => '{{ isset($reference_job_two->dates_employed) ? $reference_job_two->dates_employed : ""  }}'
        ],
        [
            'dato' => 'Worker / Reference Job N#2 / Reason Leaving',
            'llamado' => '{{ isset($reference_job_two->reason_leaving) ? $reference_job_two->reason_leaving : ""  }}'
        ],       
        [
            'dato' => 'Worker / Confirmation Independent (options)',
            'llamado' => '{{ $confirmation_independent->independent_contractor == 1 ? "Independent Contractor" : "W2 Worker"  }}'
        ],
        [
            'dato' => 'Worker / Confirmation Independen / Companie / Name',
            'llamado' => '{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $worker->last_name : "" }}'
        ],
        [
            'dato' => 'Worker / Confirmation Independen / Companie / SSN',
            'llamado' => '{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->ssn : "" }}'
        ],
        [
            'dato' => 'Worker / Confirmation Independen / Companie / Street Addres',
            'llamado' => '{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->street_addres : "" }}'
        ],
        [
            'dato' => 'Worker / Confirmation Independen / Companie / Apartment Unit',
            'llamado' => '{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->apartment_unit : "" }}'
        ],
        [
            'dato' => 'Worker / Confirmation Independen / Companie / City',
            'llamado' => '{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->city : "" }}'
        ],
        [
            'dato' => 'Worker / Confirmation Independen / Companie / State',
            'llamado' => '{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->state : "" }}'
        ],
        [
            'dato' => 'Worker / Confirmation Independen / Companie / Zip Code',
            'llamado' => '{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->zip_code : "" }}'
        ],
        [
            'dato' => 'Worker / Confirmation Independen / Companie / Home Phone',
            'llamado' => '{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->home_phone : "" }}'
        ],
        [
            'dato' => 'Worker / Confirmation Independen / Companie / Alternate Phone',
            'llamado' => '{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) && isset($companie->alternate_phone) ? $companie->alternate_phone : "" }}'
        ],
        [
            'dato' => 'Worker / Confirmation Independen / Companie / Email',
            'llamado' => '{{ $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 && isset($companie) ? $companie->email : "" }}'
        ],
    ];
?>

<div class="panel panel-inverse">
	<!-- end panel-heading -->
	<!-- begin panel-body -->
	<div class="panel-body">
        <div class="col-xs-12 ">
            <table id="tableVariables" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th class="text-nowrap">Dato</th>
                        <th class="text-nowrap">Call</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($variables as $key => $variable)
                        <tr>
                            <td>{{ $variable['dato'] }}</td>
                            <td>{{ $variable['llamado'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
	</div>
	<!-- end panel-body -->
</div>

@push('scripts')
<script>
    $(function () {
        $('#tableVariables').DataTable( {
            ordering: true,
            retrieve: true,
            paging: true,
            searching: true,
        });
    });
</script>
@endpush