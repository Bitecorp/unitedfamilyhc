<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatienteRequest;
use App\Http\Requests\UpdatePatienteRequest;
use App\Repositories\PatienteRepository;
use App\Repositories\JobInformationRepository;
use App\Repositories\EducationRepository;
use App\Repositories\ContactEmergencyRepository;
use App\Repositories\ConfirmationIndependentRepository;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateStatuRequest;
use App\Http\Requests\UpdateStatuRequest;
use App\Http\Requests\CreateMaritalStatusRequest;
use App\Http\Requests\UpdateMaritalStatusRequest;
use App\Repositories\MaritalStatusRepository;
use App\Repositories\StatuRepository;
use App\Http\Requests\CreateReferencesPersonalesRequest;
use App\Http\Requests\UpdateReferencesPersonalesRequest;
use App\Repositories\ReferencesPersonalesRepository;
use App\Http\Requests\CreateReferencesPersonalesTwoRequest;
use App\Http\Requests\UpdateReferencesPersonalesTwoRequest;
use App\Repositories\ReferencesPersonalesTwoRepository;
use App\Http\Requests\CreateReferencesJobsRequest;
use App\Http\Requests\UpdateReferencesJobsRequest;
use App\Repositories\ReferencesJobsRepository;
use App\Http\Requests\CreateReferencesJobsTwoRequest;
use App\Http\Requests\UpdateReferencesJobsTwoRequest;
use App\Repositories\ReferencesJobsTwoRepository;
use App\Repositories\CompaniesRepository;
use Illuminate\Http\Request;
use App\Models\ServiceAssigneds;
use App\Models\Companies;
use App\Models\User;
use App\Models\Role;
use App\Models\Statu;
use App\Models\Service;
use App\Models\MaritalStatus;
use App\Models\TitleJobs;
use App\Models\TypeDoc;
use App\Models\Patiente;
use App\Models\ConfirmationIndependent;
use App\Models\Education;
use App\Models\PatientesAssignedWorkers;
use App\Models\JobInformation;
use App\Models\ContactEmergency;
use App\Models\documentsEditors;
use App\Models\DocumentUserFiles;
use App\Models\AlertDocumentsExpired;
use App\Models\Location;
use App\Models\SalaryServiceAssigneds;
use App\Models\ReferencesJobs;
use App\Models\ReferencesJobsTwo;
use App\Models\ReferencesPersonales;
use App\Models\ReferencesPersonalesTwo;
use App\Models\alertDocuments;
use App\Models\SubServices;
use App\Models\ExternalsDocuments;
use App\Models\ConfigSubServicesPatiente;
use Flash;
use Response;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use App\Models\DocumentUserSol;
use Illuminate\Support\Facades\Config;

class MyPdf extends \TCPDF
{
    protected $headerCallback;

    protected $footerCallback;

    public function Header()
    {
            if ($this->headerCallback != null && is_callable($this->headerCallback)) {
                $cb = $this->headerCallback;
                $cb($this);
            } else {
                //if (Config::get('tcpdf.use_original_header')) {
                    //parent::Header();
                //}
                if (Config::get('tcpdf.use_original_header')) {
                    // Get the current page break margin
                    $bMargin = $this->getBreakMargin();

                    // Get current auto-page-break mode
                    $auto_page_break = $this->AutoPageBreak;

                    // Disable auto-page-break
                    $this->SetAutoPageBreak(false, 0);

                    // Define the path to the image that you want to use as watermark.
                    $img_file = Config::get('tcpdf.image_background');
                    // Render the image
                    $this->Image($img_file, 0, 0, 210, 295, '', '', '', false, 300, '', false, false, 0);

                    // Restore the auto-page-break status
                    $this->SetAutoPageBreak($auto_page_break, $bMargin);

                    // set the starting point for the page content
                    $this->setPageMark();
                }
            }
    }

    public function Footer()
    {
        if ($this->footerCallback != null && is_callable($this->footerCallback)) {
            $cb = $this->footerCallback;
            $cb($this);
        } else {
            //if (Config::get('tcpdf.use_original_footer')) {
                //parent::Footer();
            //}
            if (Config::get('tcpdf.use_original_footer')) {
                // Set font
                $this->SetFont('helvetica', 'I', 8);

                // Page number
                $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            }
        }
    }

    public function setHeaderCallback($callback)
    {
        $this->headerCallback = $callback;
    }

    public function setFooterCallback($callback)
    {
        $this->footerCallback = $callback;
    }

    public function addTOC($page = '', $numbersfont = '', $filler = '.', $toc_name = 'TOC', $style = '', $color = array(0, 0, 0))
    {
        // sort bookmarks before generating the TOC
        parent::sortBookmarks();

        parent::addTOC($page, $numbersfont, $filler, $toc_name, $style, $color);
    }

    public function addHTMLTOC($page = '', $toc_name = 'TOC', $templates = array(), $correct_align = true, $style = '', $color = array(0, 0, 0))
    {
        // sort bookmarks before generating the TOC
        parent::sortBookmarks();

        parent::addHTMLTOC($page, $toc_name, $templates, $correct_align, $style, $color);
    }
}

class PatienteController extends AppBaseController
{
    /** @var  StatuRepository */
    private $statuRepository;

    /** @var  RoleRepository */
    private $roleRepository;

    /** @var  PatienteRepository */
    private $patienteRepository;

    /** @var  JobInformationRepository */
    private $jobInformationRepository;

     /** @var  EducationRepository */
    private $educationRepository;

    /** @var  ContactEmergencyRepository */
    private $contactEmergencyRepository;

    /** @var  ConfirmationIndependentRepository */
    private $confirmationIndependentRepository;

    /** @var  MaritalStatusRepository */
    private $maritalStatusRepository;

    /** @var  ReferencesPersonalesRepository */
    private $referencesPersonalesRepository;

    /** @var  ReferencesPersonalesTwoRepository */
    private $referencesPersonalesTwoRepository;

    /** @var  CompaniesRepository */
    private $companiesRepository;

    public function __construct(
        PatienteRepository $patienteRepo,
        JobInformationRepository $jobInformationRepo,
        EducationRepository $educationRepo,
        ContactEmergencyRepository $contactEmergencyRepo,
        ConfirmationIndependentRepository $confirmationIndependentRepo,
        RoleRepository $roleRepo,
        StatuRepository $statuRepo,
        MaritalStatusRepository $maritalStatusRepo,
        ReferencesPersonalesRepository $referencesPersonalesRepo,
        ReferencesPersonalesTwoRepository $referencesPersonalesTwoRepo,
        ReferencesJobsRepository $referencesJobsRepo,
        ReferencesJobsTwoRepository $referencesJobsTwoRepo,
        CompaniesRepository $companiesRepo
    )
    {
        $this->patienteRepository = $patienteRepo;
        $this->jobInformationRepository = $jobInformationRepo;
        $this->educationRepository = $educationRepo;
        $this->contactEmergencyRepository = $contactEmergencyRepo;
        $this->confirmationIndependentRepository = $confirmationIndependentRepo;
        $this->roleRepository = $roleRepo;
        $this->statuRepository = $statuRepo;
        $this->maritalStatusRepository = $maritalStatusRepo;
        $this->referencesPersonalesRepository = $referencesPersonalesRepo;
        $this->referencesPersonalesTwoRepository = $referencesPersonalesTwoRepo;
        $this->referencesJobsRepository = $referencesJobsRepo;
        $this->referencesJobsTwoRepository = $referencesJobsTwoRepo;
        $this->companiesRepository = $companiesRepo;
    }

    /**
     * Display a listing of the Patiente.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $roles = Role::all();

        $status = Statu::all();

        $servicesAssigned = ServiceAssigneds::all();

        $companies = Companies::all();

        $service = Service::all();

        $maritalStatus = MaritalStatus::all();

        $titleJobs = TitleJobs::all();

        $typeDoc = TypeDoc::all();

        $patientesAct = DB::table('users')->where('role_id', 4)->where('statu_id', 1)->orderBy('first_name', 'asc')->get();
        $patientesInact = DB::table('users')->where('role_id', 4)->where('statu_id', 2)->orderBy('first_name', 'asc')->get();

        $confirmationIndependents = ConfirmationIndependent::all();

        $contactEmergencies = ContactEmergency::all();

        $educations = Education::all();

        $jobInformations = JobInformation::all();

        return view('patientes.index')
        ->with('roles', $roles)
        ->with('status', $status)
        ->with('confirmationIndependents', $confirmationIndependents)
        ->with('contactEmergencies', $contactEmergencies)
        ->with('jobInformations', $jobInformations)
        ->with('patientes', ['PA' => $patientesAct, 'PI' => $patientesInact])
        ->with('servicesAssigned', $servicesAssigned)
        ->with('educations', $educations)
        ->with('maritalStatus', $maritalStatus);
    }

    public function getPDF($id, $idPdf, Request $request)
    {

        if(ob_get_length() > 0) {
            ob_end_clean();
            ob_start();
            ob_end_flush();
        }else{
            ob_start();
            ob_end_flush();
        }

        $namePdf = documentsEditors::find($idPdf);

        $patiente = Patiente::find($id);
        $confirmation_independent = ConfirmationIndependent::where('user_id', $patiente->id)->first();
        $companie = Companies::where('user_id', $id)->first();
        $job_information = JobInformation::where('user_id', $patiente->id)->first();
        $location = Location::where('id', $job_information->work_name_location)->first();
        $supervisor = Patiente::where('id', $job_information->supervisor)->first();
        $services = Service::all();

        /* $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 */

        $nameFile = '';

        if($confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2){
            $nameFile = $companie->name;
        }else{
            $nameFile = $patiente->first_name ."_". $patiente->last_name;
        }

        $arrayData = [
            'patiente' => $patiente,
            'fullName' => $nameFile,
            'maritalStatus' => MaritalStatus::where('id', $patiente->marital_status)->first(),
            'role' => Role::where('id', $patiente->role_id)->first(),
            'contact_emergency' => ContactEmergency::where('user_id', $patiente->id)->first(),
            'job_information' => $job_information,
            'education' => Education::where('user_id', $patiente->id)->first(),
            'reference_job_one' => ReferencesJobs::where('user_id', $patiente->id)->where('reference_number', 1)->first(),
            'reference_job_two' => ReferencesJobsTwo::where('user_id', $patiente->id)->where('reference_number', 2)->first(),
            'reference_personal_one' => ReferencesPersonales::where('user_id', $patiente->id)->where('reference_number', 1)->first(),
            'reference_personal_two' => ReferencesPersonales::where('user_id', $patiente->id)->where('reference_number', 2)->first(),
            'confirmation_independent' => $confirmation_independent,
            'companie' => Companies::where('user_id', $id)->first(),
            'location' => $location,
            'supervisor' => $supervisor,
            'services' => $services,
            'salaryServices' => SalaryServiceAssigneds::where('user_id', $id)->get(),
        ];
        
        //$pdf = PDF::loadView('pdf/' . str_replace(' ', '_', $namePdf->name_document_editor), $arrayData);
        //return $pdf->download(str_replace(' ', '_', $namePdf->name_document_editor) ."_". $nameFile ."_". date("d/m/Y") . '.pdf');

        /* return $pdf->download($worker->first_name . $worker->first_name . '.pdf'); */
		/* $pdf = PDF::loadView('pdf/workerPDF'); */
        //$nameFileOut = str_replace(' ', '_', $namePdf->name_document_editor) ."_". str_replace(' ', '_', $nameFile) ."_". date("d/m/Y") . '.pdf';

        $filename = str_replace(' ', '_', $namePdf->name_document_editor) . "_" . str_replace(' ', '_', $nameFile) . '_' . date("d/m/Y") . '.pdf';
        $title = str_replace(' ', '_', $namePdf->name_document_editor) . "_" . str_replace(' ', '_', $nameFile) . '_' . date("d/m/Y");
        $titleFileOrFile = 'pdf.' . str_replace(' ', '_', $namePdf->name_document_editor);

        if(isset($namePdf->backgroundImg) && !empty($namePdf->backgroundImg)){
            Config::set('tcpdf.image_background', public_path($namePdf->backgroundImg));
        }else{
            Config::set('tcpdf.use_original_header', false);
        }

        if(isset($namePdf->paginate) && !empty($namePdf->paginate) && ($namePdf->paginate == 1 || $namePdf->paginate == true)){
            Config::set('tcpdf.use_original_footer', true);
        }

    	$view = \View::make($titleFileOrFile, $arrayData);
        $html = $view->render();

    	$pdf = new MyPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        //dd(Config::get('tcpdf.use_original_header'), Config::get('tcpdf.image_background'), $pdf);
        
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(PDF_AUTHOR);
        $pdf->SetTitle(!empty($title) ? $title : PDF_HEADER_TITLE);
        $pdf->SetSubject($nameFile . '.');
        $pdf->SetKeywords('TCPDF, PDF');

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP,  PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


        $pdf->AddPage();

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output($filename, 'I'); 

        //return response()->download(public_path($filename));

		//return $pdf->stream($nameFileOut);
	}

    /**
     * Show the form for creating a new Patiente.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::all();

        $status = Statu::all();

        $serviceAssigned = ServiceAssigneds::all();

        $companies = Companies::all();

        $service = Service::all();

        $marital_status = MaritalStatus::all();

        $titleJobs = TitleJobs::all();

        $typeDoc = TypeDoc::all();

        if(empty($serviceAssigned)){
            return view('patientes.create')->with('roles', $roles)->with('status', $status)->with('marital_status', $marital_status)->with('titleJobs', $titleJobs)->with('serviceAssigned', $serviceAssigned);
        }else{
            return view('patientes.create')->with('roles', $roles)->with('status', $status)->with('marital_status', $marital_status)->with('titleJobs', $titleJobs);
        }
    }

    /**
     * Store a newly created Patiente in storage.
     *
     * @param CreatePatienteRequest $request
     *
     * @return Response
     */
    public function store(CreatePatienteRequest $request)
    {
        $input = $request->all();
        $input['password'] = null;
        $input['remember_token'] = null;
        $input['email_verified_at'] = null;

        $age = Carbon::parse($input['birth_date'])->age;

        $patiente = $this->patienteRepository->create($input);

        DB::table('contacts_emergencys')->insert([
            'user_id' => $patiente->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('contacts_emergencys')->insert([
            'user_id' => $patiente->id,
            'guardian' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('jobs_information')->insert([
            'user_id' => $patiente->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('educations')->insert([
            'user_id' => $patiente->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('confirmations')->insert([
            'user_id' => $patiente->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('references')->insert([
            'user_id' => $patiente->id,
            'reference_number' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('references_jobs')->insert([
            'user_id' => $patiente->id,
            'reference_number' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('references')->insert([
            'user_id' => $patiente->id,
            'reference_number' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('references_jobs')->insert([
            'user_id' => $patiente->id,
            'reference_number' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $patiente->id)->where('guardian', 0)->first();
        $contactEmergency = $this->contactEmergencyRepository->find($contactEmergencyID->id);

        Flash::success('Patiente saved successfully');

        return view('contact_emergencies.create')->with('patienteID', $patiente->id)->with('workerID', $patiente->id)->with('contactEmergency', $contactEmergency);

    }

    /**
     * Display the specified Patiente.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $roles = Role::all();

        $status = Statu::all();

        $companies = Companies::all();

        $services = Service::all();

        $maritalStatus = MaritalStatus::all();

        $titleJobs = TitleJobs::all();

        $typeDoc = TypeDoc::all();

        $patientes = Patiente::where('role_id', 4)->get();

        $locations = Location::all();

        $patiente = $this->patienteRepository->find($id);

        if (empty($patiente)) {
            Flash::error('Patiente not found');
            return redirect(route('patientes.index'));
        }

        $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $id)->where('guardian', 0)->first();
        $contactEmergency = $this->contactEmergencyRepository->find($contactEmergencyID->id);

        $contactEmergencyIDGuardian = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $id)->where('guardian', 1)->first();
        $contactEmergencyGuardian = $this->contactEmergencyRepository->find($contactEmergencyIDGuardian->id);

        $jobInformationID = DB::table('jobs_information')->select('id')->where('user_id', '=', $id)->first();
        $jobInformation = $this->jobInformationRepository->find($jobInformationID->id);

        $educationID = DB::table('educations')->select('id')->where('user_id', '=', $id)->first();
        $education = $this->educationRepository->find($educationID->id);

        $confirmationIndependentID = DB::table('confirmations')->select('id')->where('user_id', '=', $id)->first();
        $confirmationIndependent = $this->confirmationIndependentRepository->find($confirmationIndependentID->id);

        $referenceOneID = DB::table('references')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '1')->first();
        $referencesPersonales = $this->referencesPersonalesRepository->find($referenceOneID->id);

        $referenceTwoID = DB::table('references')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '2')->first();
        $referencesPersonalesTwo = $this->referencesPersonalesRepository->find($referenceTwoID->id);

        $referenceJobOneID = DB::table('references_jobs')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '1')->first();

        $referenceJobTwoID = DB::table('references_jobs')->select('id')->where('user_id', '=', $id)->where('reference_number', '=', '2')->first();

        $servicesAssingneds = DB::table('service_assigneds')->select('services')->where('user_id', $id)->first();

        $returnView = '';
        $subServices = [];
        $subServicesDif = [];
        $idsSubServices = [];
        $externalDocuments = [];
        $documentsEditors = [];

        if(!empty($servicesAssingneds)){
            $salaryServiceAssigneds = SalaryServiceAssigneds::where('user_id', '=', $id)->get();

            $dataServicesAssigneds = array();
            foreach(collect(json_decode($servicesAssingneds->services)) as $key => $value){
                array_push($dataServicesAssigneds, DB::table('services')->select('documents')->where('id', $value)->first());
                array_push($subServices, SubServices::where('service_id', $value)->get());
                array_push($idsSubServices, SubServices::select('id')->where('service_id', $value)->first());
                array_push($externalDocuments, ExternalsDocuments::where('role_id', 4)->where('service_id', $value)->get());
                $dataMoment = documentsEditors::where('role_id', 4)->where('service_id', $value)->get();
                if(isset($dataMoment) && !empty($dataMoment) && count($dataMoment) >= 1){
                    array_push($documentsEditors, documentsEditors::where('role_id', 4)->where('service_id', $value)->get());
                }
            }
            $dataMoment = documentsEditors::where('role_id', 4)->where('service_id', 0)->get();
            if(isset($dataMoment) && !empty($dataMoment) && count($dataMoment) >= 1){
                array_push($documentsEditors, documentsEditors::where('role_id', 4)->where('service_id', 0)->get());
            }
            array_push($externalDocuments, ExternalsDocuments::where('role_id', 4)->where('service_id', 0)->get());

            //dd($documentsEditors);

            $dataListFiles = array();
            foreach($dataServicesAssigneds as $key => $values){
                foreach(json_decode($values->documents) as $key => $value){
                    $consult = DB::table('type_docs')->select('id')->where('id', $value)->where('role_id', 4)->first();
                    if(isset($consult)){
                        array_push($dataListFiles, $consult);
                    }
                }
            }

            $dataListFilesClear = array();
            foreach(collect($dataListFiles) as $key => $val){
                array_push($dataListFilesClear, $val->id);
            }

            $documentUserFilesFoo = array();
            foreach(array_unique($dataListFilesClear) as $key => $valID){
                foreach(collect(json_decode($servicesAssingneds->services)) as $keyS => $valueS){
                    $test = DB::table('type_docs')->where('id', $valID)->first();
                    if(!empty($test)){
                        foreach(collect(json_decode($servicesAssingneds->services)) as $key => $value){
                            if($test->service_id == $value || $test->service_id == 0 || $test->service_id == '0'){
                                array_push($documentUserFilesFoo,  DB::table('type_docs')->select('id')->where('id', $valID)->first());
                            }
                        }
                    }
                }
            }

            $documentUserFilesFo = array();
            foreach(collect($documentUserFilesFoo) as $key => $val){
                array_push($documentUserFilesFo, $val->id);
            }

            $documentUserFiles = array();
            foreach(array_unique($documentUserFilesFo) as $key => $valID){
                $constData = DB::table('type_docs')->where('id', $valID)->first();
                if(isset($constData) && !empty($constData)){
                    $docIsSol = DocumentUserSol::where('document_id', $constData->id)->where('user_id', $patiente->id)->first();
                    if(isset($docIsSol) && !empty($docIsSol)){
                        $constData->isSol = intval($docIsSol->isSol);
                    }else{
                        $constData->isSol = 0;
                    }
                    array_push($documentUserFiles,  $constData);
                }
            }

            /* $documentUserFiles = $documentUserFiles; */
            $filesUploads = collect(DB::table('document_user_files')->select('id', 'document_id', 'date_expedition', 'date_expired', 'file', 'expired')->where('user_id', $id)->where('expired', 0)->orderBy('created_at', 'DESC')->get());
            $filesUploadsExpired = collect(DB::table('document_user_files')->select('id', 'document_id', 'date_expedition', 'date_expired', 'file', 'expired')->where('user_id', $id)->where('expired', '<>', 0)->orderBy('created_at', 'DESC')->get());

            $documentUserFilesUpload = array();
            foreach ($filesUploads as $key => $value) {
                $fileUpload = DB::table('type_docs')->where('id', $value->document_id)->first();
                $docIsSol = DocumentUserSol::where('document_id', $fileUpload->id)->where('user_id', $patiente->id)->first();
                if(isset($docIsSol) && !empty($docIsSol)){
                    $fileUpload->isSol = intval($docIsSol->isSol);
                }else{
                    $fileUpload->isSol = 0;
                }
                array_push($documentUserFilesUpload, $fileUpload);
            }

            $documentUserFilesIDsA = array();
            foreach($documentUserFiles AS $key => $value){
                array_push($documentUserFilesIDsA, $value->id);
            }

            $documentUserFilesIDsU = array();
            foreach($documentUserFilesUpload AS $key => $value){
                array_push($documentUserFilesIDsU, $value->id);
            }

            $idDIffOne = array_diff($documentUserFilesIDsA, $documentUserFilesIDsU);
            $idDIffTwo = array_diff($documentUserFilesIDsU, $documentUserFilesIDsA);

            $arrayData = '';

            if(!empty($idDIffOne) || !empty($idDIffTwo)){
                if(!empty($idDIffOne) && count($idDIffOne) >= 1){
                    $arrayData = $idDIffOne;
                }elseif(!empty($idDIffTwo) && count($idDIffTwo) >= 1){
                    $arrayData = $idDIffTwo;
                }elseif(!empty($idDIffOne) && count($idDIffOne) >= 1 && !empty($idDIffTwo) && count($idDIffTwo) >= 1){
                    $arrayData = array_unique(array_merge($idDIffOne , $idDIffTwo));
                }
            }

            $documentUserFilesDinst = array();
            if (!empty($arrayData) && count($arrayData) >= 1) {
                foreach ($arrayData as $key => $value) {
                    $valConsult = DB::table('type_docs')->where('id', $value)->first();
                    if (!empty($valConsult)) {
                        $docIsSol = DocumentUserSol::where('document_id', $valConsult->id)->where('user_id', $patiente->id)->first();
                        if(isset($docIsSol) && !empty($docIsSol)){
                            $valConsult->isSol = intval($docIsSol->isSol);
                        }else{
                            $valConsult->isSol = 0;
                        }
                        array_push($documentUserFilesDinst, $valConsult);
                    }
                }
            }

            $collections = collect(json_decode($servicesAssingneds->services));

            $data = [];

            foreach($collections as $collection){
                array_push($data, DB::table('services')->select('id', 'name_service')->where('id', $collection)->first());
            }

            $servicesDist = DB::table('services')->select('id', 'name_service')->get();

            foreach($collections as $collection){
                foreach($services as $key => $service){
                    if($service->id == $collection){
                        unset($servicesDist[$key]);
                    }
                }
            }
            
            $userAndServices = ServiceAssigneds::all();

            $workersServicesPatientes = [];

            foreach($userAndServices as $userAndService){
                foreach(json_decode($userAndService->services) as $servUser){
                    foreach(json_decode($servicesAssingneds->services) as $servPat){
                        if($servPat == $servUser){
                            array_push($workersServicesPatientes, $userAndService->user_id);
                        }
                    }
                }
            }

            $workerList = [];

            foreach(array_unique($workersServicesPatientes) as $value){
                $userValue = User::where('id', $value)->first();
                if(isset($userValue) && !empty($userValue) && $userValue['role_id'] == 2 && $userValue['statu_id'] == 1){
                    array_push($workerList, $userValue);
                }
            }

            $workersAssigneds = PatientesAssignedWorkers::where('patiente_id', $id)->get();

            $returnView = view('patientes.show_index')
                ->with('typeDocs', $typeDoc)
                ->with('roles', $roles)
                ->with('status', $status)
                ->with('companies', ($companies))
                ->with('confirmationIndependent', $confirmationIndependent)
                ->with('contactEmergency', $contactEmergency)
                ->with('contactEmergencyGuardian', $contactEmergencyGuardian)
                ->with('jobInformation', $jobInformation)
                ->with('patiente', $patiente)
                ->with('patientes', $patientes)
                ->with('worker', $patiente)
                ->with('workers', $patientes)
                ->with('referencesPersonales', $referencesPersonales)
                ->with('referencesPersonalesTwo', $referencesPersonalesTwo)
                ->with('referencesJobs', !empty($referenceJobOneID) ? $this->referencesJobsRepository->find($referenceJobOneID->id) : null)
                ->with('referencesJobsTwo', !empty($referenceJobTwoID) ? $this->referencesJobsRepository->find($referenceJobTwoID->id) : null)
                ->with('services', !empty($services) ? $services : null)
                ->with('servicesAssigned', !empty($servicesAssingneds) ? $servicesAssingneds : null)
                ->with('education', $education)
                ->with('filesUploads', !empty($filesUploads) ? $filesUploads : null)
                ->with('documentUserFiles', !empty($documentUserFiles) ? collect($documentUserFiles) : null)
                ->with('documentUserFilesUploads', !empty($documentUserFilesUpload) ? collect($documentUserFilesUpload) : null)
                ->with('documentUserFilesDiffs', !empty($documentUserFilesDinst) ? collect($documentUserFilesDinst) : null)
                ->with('documentsEditors', !empty($documentsEditors) ? $documentsEditors : null)
                ->with('salaryServiceAssigneds', !empty($salaryServiceAssigneds) ? $salaryServiceAssigneds : null)
                ->with('locations', $locations)
                ->with('userID', $id)
                ->with('serviceAssigneds', !empty($servicesAssingneds) ? $servicesAssingneds : null)
                ->with('collection', collect($data))
                ->with('servicesDist', collect($servicesDist))
                ->with('maritalStatus', $maritalStatus)
                ->with('filesUploadsExpired', !empty($filesUploadsExpired)  ? $filesUploadsExpired : null)
                ->with('subServices', !empty($subServices) ? $subServices : null)
                ->with('externalDocuments', !empty($externalDocuments) ? $externalDocuments : null)
                ->with('workerList', isset($workerList) && !empty($workerList) && count($workerList) >= 1 ? $workerList : [])
                ->with('workersAssigneds', isset($workersAssigneds) && !empty($workersAssigneds) && count($workersAssigneds) >= 1 ? $workersAssigneds: []);

        }else{

            $returnView = view('patientes.show_index')
                ->with('typeDocs', $typeDoc)
                ->with('roles', $roles)
                ->with('status', $status)
                ->with('companies', ($companies))
                ->with('confirmationIndependent', $confirmationIndependent)
                ->with('contactEmergency', $contactEmergency)
                ->with('contactEmergencyGuardian', $contactEmergencyGuardian)
                ->with('jobInformation', $jobInformation)
                ->with('patiente', $patiente)
                ->with('patientes', $patientes)
                ->with('worker', $patiente)
                ->with('workers', $patientes)
                ->with('referencesPersonales', $referencesPersonales)
                ->with('referencesPersonalesTwo', $referencesPersonalesTwo)
                ->with('referencesJobs', !empty($referenceJobOneID) ? $this->referencesJobsRepository->find($referenceJobOneID->id) : null)
                ->with('referencesJobsTwo', !empty($referenceJobTwoID) ? $this->referencesJobsRepository->find($referenceJobTwoID->id) : null)
                ->with('services', !empty($services) ? $services : null)
                ->with('servicesAssigned', !empty($servicesAssingneds) ? $servicesAssingneds : null)
                ->with('education', $education)
                ->with('filesUploads', !empty($filesUploads) ? $filesUploads : null)
                ->with('documentUserFiles', !empty($documentUserFiles) ? collect($documentUserFiles) : null)
                ->with('documentUserFilesUploads', !empty($documentUserFilesUpload) ? collect($documentUserFilesUpload) : null)
                ->with('documentUserFilesDiffs', !empty($documentUserFilesDinst) ? collect($documentUserFilesDinst) : null)
                ->with('documentsEditors', !empty($documentsEditors) ? $documentsEditors : null)
                ->with('salaryServiceAssigneds', !empty($salaryServiceAssigneds) ? $salaryServiceAssigneds : null)
                ->with('locations', $locations)
                ->with('userID', $id)
                ->with('serviceAssigneds', !empty($servicesAssingneds) ? $servicesAssingneds : null)
                ->with('maritalStatus', $maritalStatus)
                ->with('subServices', !empty($subServices) ? $subServices : null)
                ->with('externalDocuments', !empty($externalDocuments) ? $externalDocuments : null)
                ->with('workerList', isset($workerList) && !empty($workerList) && count($workerList) >= 1 ? $workerList : [])
                ->with('workersAssigneds', isset($workersAssigneds) && !empty($workersAssigneds) && count($workersAssigneds) >= 1 ? $workersAssigneds: []);

        }

        return $returnView;
    }

    /**
     * Show the form for editing the specified Patiente.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $patiente = $this->patienteRepository->find($id);

        $roles = Role::all();

        $status = Statu::all();

        $servicesAssigned = ServiceAssigneds::all();

        $companies = Companies::all();

        $service = Service::all();

        $marital_status = MaritalStatus::all();

        $titleJobs = TitleJobs::all();

        $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $id)->where('guardian', 0)->first();
        $contactEmergency = $this->contactEmergencyRepository->find($contactEmergencyID->id);

        $contactEmergencyIDGuardian = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $id)->where('guardian', 1)->first();
        $contactEmergencyGuardian = $this->contactEmergencyRepository->find($contactEmergencyIDGuardian->id);

        $jobInformationID = DB::table('jobs_information')->select('id')->where('user_id', '=', $id)->first();
        $jobInformation = $this->jobInformationRepository->find($jobInformationID->id);

        $educationID = DB::table('educations')->select('id')->where('user_id', '=', $id)->first();
        $education = $this->educationRepository->find($educationID->id);

        $confirmationIndependentID = DB::table('confirmations')->select('id')->where('user_id', '=', $id)->first();
        $confirmationIndependent = $this->confirmationIndependentRepository->find($confirmationIndependentID->id);

        if (empty($patiente)) {
            Flash::error('Patiente not found');

            return redirect(route('patientes.index'));
        }

        return view('patientes.edit')
        ->with('roles', $roles)
        ->with('status', $status)
        ->with('confirmationIndependent', $confirmationIndependent)
        ->with('contactEmergency', $contactEmergency)
        ->with('jobInformation', $jobInformation)
        ->with('patiente', $patiente)
        ->with('education', $education)
        ->with('marital_status', $marital_status)
        ->with('titleJobs', $titleJobs)
        ->with('contactEmergencyGuardian', $contactEmergencyGuardian);
    }

    /**
     * Update the specified Patiente in storage.
     *
     * @param int $id
     * @param UpdatePatienteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePatienteRequest $request)
    {
        $patiente = $this->patienteRepository->find($id);

        if (empty($patiente)) {
            Flash::error('Patiente not found');

            return redirect(route('patientes.index'));
        }

        $patiente = $this->patienteRepository->update($request->all(), $id);

        Flash::success('Patiente updated successfully.');
        $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $id)->first();
        $contactEmergency = $this->contactEmergencyRepository->find($contactEmergencyID->id);

        return view('contact_emergencies.edit')->with('contactEmergency', $contactEmergency);
    }

    /**
     * Update the specified Patiente in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function updateState($id, Request $request)
    {
        $patiente = $this->patienteRepository->find($id);

        if (empty($patiente)) {
            Flash::error('Patiente not found');

            return redirect(route('patientes.index'));
        }

        $patiente->statu_id = $patiente->statu_id == '1' ? '2' : '1';

        $patiente->save();

        Flash::success('Patiente updated successfully.');

        $dataAlert = DB::select(
            'SELECT id FROM alert_documents WHERE document_user_file_id IN 
            (SELECT id FROM document_user_files WHERE user_id =' . $id . ' AND expired = 1)'
        );

        if(count($dataAlert) >= 1){
            foreach($dataAlert as $key => $val){
                AlertDocumentsExpired::where('id', $val)->delete();
            }

            DocumentUserFiles::where('user_id', $id)->where('expired', 1)->update(['expired' => 0]);
        }

        $roles = Role::all();

        $status = Statu::all();

        $servicesAssigned = ServiceAssigneds::all();

        $companies = Companies::all();

        $service = Service::all();

        $maritalStatus = MaritalStatus::all();

        $titleJobs = TitleJobs::all();

        $typeDoc = TypeDoc::all();

        $patientes = Patiente::all();

        $confirmationIndependents = ConfirmationIndependent::all();

        $contactEmergencies = ContactEmergency::all();

        $educations = Education::all();

        $jobInformations = JobInformation::all();

        return redirect(route('patientes.index', [
            'roles' => $roles,
            'status' => $status,
            'confirmationIndependents' => $confirmationIndependents,
            'contactEmergencies' => $contactEmergencies,
            'jobInformations' => $jobInformations,
            'patientes' => $patientes,
            'servicesAssigned' => $servicesAssigned,
            'educations' => $educations
        ]));
    }

    /**
     * Remove the specified Patiente from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $patiente = $this->patienteRepository->find($id);

        if (empty($patiente)) {
            Flash::error('Patiente not found');

            return redirect(route('patientes.index'));
        }

        $this->patienteRepository->delete($id);

        $confirmationIndependentID = DB::table('confirmations')->select('id')->where('user_id', '=', $id)->first();
        $educationID = DB::table('educations')->select('id')->where('user_id', '=', $id)->first();
        $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $id)->where('guardian', 0)->first();
        $contactEmergencyIDGuardian = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $id)->where('guardian', 1)->first();
        $jobInformationID = DB::table('jobs_information')->select('id')->where('user_id', '=', $id)->first();
        $referencePersonalsID = DB::table('references')->select('id')->where('user_id', '=', $id)->get();
        $referenceJobsID = DB::table('references_jobs')->select('id')->where('user_id', '=', $id)->get();
        $companiesID = DB::table('companies')->select('id')->where('user_id', '=', $id)->first();

        $existData = SalaryServiceAssigneds::where('user_id', $id)->get();
        if(isset($existData) && !empty($existData) && count($existData) >= 1){
            foreach($existData AS $exist){
                $configs = ConfigSubServicesPatiente::where('salary_service_assigned_id', $exist->id)->first();
                $config = ConfigSubServicesPatiente::find($configs->id);
                $config->delete();

                $flight = SalaryServiceAssigneds::find($exist->id);
                $flight->delete();
            }
        }

        $this->educationRepository->delete($educationID->id);
        $this->confirmationIndependentRepository->delete($confirmationIndependentID->id);
        $this->contactEmergencyRepository->delete($contactEmergencyID->id);
        $this->contactEmergencyRepository->delete($contactEmergencyIDGuardian->id);
        $this->jobInformationRepository->delete($jobInformationID->id);
        foreach($referencePersonalsID as $referencePersonalID){
            $this->referencesPersonalesRepository->delete($referencePersonalID->id);
        }
        foreach($referenceJobsID as $referenceJobID){
            $this->referencesJobsRepository->delete($referenceJobID->id);
        }
        if(!empty($companiesID->id)){
            $this->companiesRepository->delete($companiesID->id);
        }

        Flash::success('Patiente deleted successfully.');

        return redirect(route('patientes.index'));
    }

    public function assingWorker($idPatiente, $idWorker)
    {
        $exist = PatientesAssignedWorkers::where('patiente_id', $idPatiente)->where('worker_id', $idWorker)->first();

        if(isset($exist) && !empty($exist)){
            $flight = PatientesAssignedWorkers::find($exist->id);
 
            $flight->delete();
        }else{

            $flight = new PatientesAssignedWorkers;
    
            $flight->patiente_id = $idPatiente;
            $flight->worker_id = $idWorker;
    
            $flight->save();
        }

        return redirect(route('patientes.show', [$idPatiente]) . "?assignWorker");
    }
}
