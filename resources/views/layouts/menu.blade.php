@if(Auth::user()->role_id == 1)
<li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('roles.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Roles</span>
    </a>
</li>
<li class="nav-item {{ Request::is('status*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('status.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Status</span>
    </a>
</li>
<li class="nav-item {{ Request::is('personals*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('personals.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Personals</span>
    </a>
</li>
@elseif (Auth::user()->role_id != 1)
<li class="nav-item {{ Request::is('personals*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('personals.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Information</span>
    </a>
</li>
@endif
<li class="nav-item {{ Request::is('maritalStatuses*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('maritalStatuses.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Marital Statuses</span>
    </a>
</li>
<li class="nav-item {{ Request::is('titleJobs*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('titleJobs.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Title Jobs</span>
    </a>
</li>
<li class="nav-item {{ Request::is('referencesPersonales*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('referencesPersonales.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>References Personales</span>
    </a>
</li>
<li class="nav-item {{ Request::is('referencesJobs*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('referencesJobs.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>References Jobs</span>
    </a>
</li>
<li class="nav-item {{ Request::is('referencesPersonalesTwos*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('referencesPersonalesTwos.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>References Personales Twos</span>
    </a>
</li>
<li class="nav-item {{ Request::is('referencesJobsTwos*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('referencesJobsTwos.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>References Jobs Twos</span>
    </a>
</li>
<li class="nav-item {{ Request::is('typeDocs*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('typeDocs.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Type Docs</span>
    </a>
</li>
<li class="nav-item {{ Request::is('locations*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('locations.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Locations</span>
    </a>
</li>
<li class="nav-item {{ Request::is('services*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('services.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Services</span>
    </a>
</li>
<li class="nav-item {{ Request::is('companies*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('companies.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Companies</span>
    </a>
</li>
<li class="nav-item {{ Request::is('serviceAssigneds*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('serviceAssigneds.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Service Assigneds</span>
    </a>
</li>
<li class="nav-item {{ Request::is('documentUserFiles*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('documentUserFiles.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Document User Files</span>
    </a>
</li>
<li class="nav-item {{ Request::is('documentsEditors*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('documentsEditors.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Documents Editors</span>
    </a>
</li>
<li class="nav-item {{ Request::is('imagesDocuments*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('imagesDocuments.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Images Documents</span>
    </a>
</li>
<li class="nav-item {{ Request::is('salaryServiceAssigneds*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('salaryServiceAssigneds.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Salary Service Assigneds</span>
    </a>
</li>
<li class="nav-item {{ Request::is('alertDocuments*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('alertDocuments.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Alert Documents</span>
    </a>
</li>
<li class="nav-item {{ Request::is('subServices*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('subServices.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Sub Services</span>
    </a>
</li>
<li class="nav-item {{ Request::is('taskSubServices*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('taskSubServices.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Task Sub Services</span>
    </a>
</li>
<li class="nav-item {{ Request::is('units*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('units.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Units</span>
    </a>
</li>
