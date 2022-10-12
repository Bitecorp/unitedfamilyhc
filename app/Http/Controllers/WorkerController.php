<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkerRequest;
use App\Http\Requests\UpdateWorkerRequest;
use App\Repositories\WorkerRepository;
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
use App\Models\Role;
use App\Models\Statu;
use App\Models\Service;
use App\Models\MaritalStatus;
use App\Models\TitleJobs;
use App\Models\TypeDoc;
use App\Models\Worker;
use App\Models\Patiente;
use App\Models\ConfirmationIndependent;
use App\Models\Education;
use App\Models\JobInformation;
use App\Models\ContactEmergency;
use App\Models\documentsEditors;
use App\Models\DocumentsUserFiles;
use App\Models\Location;
use App\Models\SalaryServiceAssigneds;
use App\Models\ReferencesJobs;
use App\Models\ReferencesJobsTwo;
use App\Models\ReferencesPersonales;
use App\Models\ReferencesPersonalesTwo;
use App\Models\alertDocuments;
use App\Models\SubServices;
use App\Models\ExternalsDocuments;
use Flash;
use Response;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Auth;
use Elibyy\TCPDF\Facades\TCPDF;

use Illuminate\Support\Facades\Config;
use Mail;
use App\Mail\resetPassword;

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
                $this->setX(180);
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

class WorkerController extends AppBaseController
{
    /** @var  StatuRepository */
    private $statuRepository;

    /** @var  RoleRepository */
    private $roleRepository;

    /** @var  WorkerRepository */
    private $workerRepository;

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
        WorkerRepository $workerRepo,
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
    ) {
        $this->workerRepository = $workerRepo;
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
         * Metodo Publico
         * OrdenarMatrizColumna($MatrizRegistros = false, $Columna = false, $Orden = false)
         *
         * Ordena una matriz de registros en funcion de la columna indicada
         * @param $MatrizRegistros   : Matriz de registros desordenados
         * @param $Columna           : String Nombre de columna
         * @param $Orden             : String ASC o DESC -> default DESC
         * @return $MatrizRegistros  : Matriz de registros Ordenados
         */
        public static function OrdenarMatrizColumna(array $MatrizRegistros, $Columna = false, $Orden = false) {
            if (is_array($MatrizRegistros) == true and $Columna == true and $Orden == true) {
                $Orden = ($Orden == "ASC") ? SORT_ASC : SORT_DESC;
                foreach ($MatrizRegistros as $Arreglo) {
                    $Lista[] = $Arreglo->$Columna;
                }
                array_multisort($Lista, $Orden, $MatrizRegistros);
                return $MatrizRegistros;
            }
        }

    /**
     * Display a listing of the Worker.
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

        $workersAct = DB::table('users')->whereNotIn('role_id', [4, 5])->where('statu_id', 1)->orderBy('first_name', 'asc')->get();

        $workersInact = DB::table('users')->whereNotIn('role_id', [4, 5])->where('statu_id', 2)->orderBy('first_name', 'asc')->get();
        
        $confirmationIndependents = ConfirmationIndependent::all();

        $contactEmergencies = ContactEmergency::all();

        $educations = Education::all();

        $jobInformations = JobInformation::all();

        return view('workers.index')
            ->with('roles', $roles)
            ->with('status', $status)
            ->with('confirmationIndependents', $confirmationIndependents)
            ->with('contactEmergencies', $contactEmergencies)
            ->with('jobInformations', $jobInformations)
            ->with('workers', ['WA' => $workersAct, 'WI' => $workersInact])
            ->with('servicesAssigned', $servicesAssigned)
            ->with('educations', $educations)
            ->with('maritalStatus', $maritalStatus);
    }

    public function getPDF($id, $idPdf, Request $request)
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
            ob_start();
            ob_end_flush();
        } else {
            ob_start();
            ob_end_flush();
        }

        $namePdf = documentsEditors::find($idPdf);

        $worker = Worker::find($id);
        $patiente = Patiente::find($id);
        $confirmation_independent = ConfirmationIndependent::where('user_id', $worker->id)->first();
        $companie = Companies::where('user_id', $id)->first();
        $job_information = JobInformation::where('user_id', $worker->id)->first();
        $location = Location::where('id', $job_information->work_name_location)->first();
        $supervisor = Worker::where('id', $job_information->supervisor)->first();
        $services = Service::all();

        /* $confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2 */

        $nameFile = '';

        if ($confirmation_independent->independent_contractor == 1 && $confirmation_independent->personalEmpresa == 2) {
            $buscar = array (".",",",";",":");    
            $remplazar = array ("","","","");

            $nameFile = str_replace($buscar, $remplazar, $companie->name);
        } else {
            $nameFile = $worker->first_name . "_" . $worker->last_name;
        }

        $arrayData = [
            'worker' => $worker,
            'patiente' => $patiente,
            'contactEmergencyPatiente' => ContactEmergency::where('user_id', $patiente->id)->where('guardian', 0)->first(),
            'guardianPatiente' => ContactEmergency::where('user_id', $patiente->id)->where('guardian', 1)->first(),
            'fullNamePatiente' => $patiente->first_name . ' ' . $patiente->last_name,
            'fullName' => $nameFile,
            'maritalStatus' => MaritalStatus::where('id', $worker->marital_status)->first(),
            'role' => Role::where('id', $worker->role_id)->first(),
            'contact_emergency' => ContactEmergency::where('user_id', $worker->id)->first(),
            'job_information' => $job_information,
            'education' => Education::where('user_id', $worker->id)->first(),
            'reference_job_one' => ReferencesJobs::where('user_id', $worker->id)->where('reference_number', 1)->first(),
            'reference_job_two' => ReferencesJobsTwo::where('user_id', $worker->id)->where('reference_number', 2)->first(),
            'reference_personal_one' => ReferencesPersonales::where('user_id', $worker->id)->where('reference_number', 1)->first(),
            'reference_personal_two' => ReferencesPersonales::where('user_id', $worker->id)->where('reference_number', 2)->first(),
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
        $pdf->SetMargins(15, 15,  15);
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
     * Show the form for creating a new Worker.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::where('id', '<=', 3)->get();

        $status = Statu::all();

        $serviceAssigned = ServiceAssigneds::all();

        $companies = Companies::all();

        $service = Service::all();

        $marital_status = MaritalStatus::all();

        $titleJobs = TitleJobs::all();

        $typeDoc = TypeDoc::all();

        if (empty($serviceAssigned)) {
            return view('workers.create')->with('roles', $roles)->with('status', $status)->with('marital_status', $marital_status)->with('titleJobs', $titleJobs)->with('serviceAssigned', $serviceAssigned);
        } else {
            return view('workers.create')->with('roles', $roles)->with('status', $status)->with('marital_status', $marital_status)->with('titleJobs', $titleJobs);
        }
    }

    /**
     * Store a newly created Worker in storage.
     *
     * @param CreateWorkerRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkerRequest $request)
    {
        $input = $request->all();
        $pass = isset($input['ssn']) && !empty($input['ssn']) ?
            Hash::make('@' . substr(mb_strtoupper($input['first_name']),0,2) . '#' . $input['ssn'] . '#' . substr(mb_strtolower($input['last_name']),0,2) . '@') :
            Hash::make('@' . substr(mb_strtoupper($input['first_name']),0,2) . '#' . mt_rand(1,10) . '#' . substr(mb_strtolower($input['last_name']),0,2) . '@');
        
        $input['password'] = $pass;
        $input['remember_token'] = Str::random(10);
        $input['email_verified_at'] = now();

        $age = Carbon::parse($input['birth_date'])->age;

        if ($age < 18) {

            Flash::error('The Worker cannot be less than 18 years old.');

            return redirect(route('workers.create'));
        } else {
            $worker = $this->workerRepository->create($input);

            DB::table('contacts_emergencys')->insert([
                'user_id' => $worker->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('jobs_information')->insert([
                'user_id' => $worker->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('educations')->insert([
                'user_id' => $worker->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('confirmations')->insert([
                'user_id' => $worker->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('references')->insert([
                'user_id' => $worker->id,
                'reference_number' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('references_jobs')->insert([
                'user_id' => $worker->id,
                'reference_number' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('references')->insert([
                'user_id' => $worker->id,
                'reference_number' => '2',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('references_jobs')->insert([
                'user_id' => $worker->id,
                'reference_number' => '2',
                'created_at' => now(),
                'updated_at' => now()
            ]);


            $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $worker->id)->first();
            $contactEmergency = $this->contactEmergencyRepository->find($contactEmergencyID->id);

            Flash::success('Worker saved successfully, your current password is your SSN.');

            return view('contact_emergencies.create')->with('workerID', $worker->id)->with('contactEmergency', $contactEmergency);
        }
    }

    /**
     * Display the specified Worker.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $roles = Role::where('id', '<=', 3)->get();

        $status = Statu::all();

        $companies = Companies::where('user_id', $id)->first();

        $services = Service::all();

        $maritalStatus = MaritalStatus::all();

        $titleJobs = TitleJobs::all();

        $typeDoc = TypeDoc::all();

        $workers = Worker::all();

        $locations = Location::all();

        $documentsEditors = documentsEditors::where('role_id', [2, 3])->get();

        $worker = $this->workerRepository->find($id);

        if (empty($worker)) {
            Flash::error('Worker not found');
            return redirect(route('workers.index'));
        }

        $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $id)->first();
        $contactEmergency = $this->contactEmergencyRepository->find($contactEmergencyID->id);

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

        if (Auth::user()->role_id == 2) {
            $dataFull = ReferencesPersonalesTwo::where('user_id', Auth::user()->id)->where('reference_number', 2)->get();

            if (isset($dataFull) && !empty($dataFull)) {
                if (!isset($dataFull[0]->name_job) || empty($dataFull[0]->name_job) && !isset($dataFull[0]->address) || empty($dataFull[0]->address) && !isset($dataFull[0]->phone) || empty($dataFull[0]->phone) && !isset($dataFull[0]->ocupation) || empty($dataFull[0]->ocupation) && !isset($dataFull[0]->time) || empty($dataFull[0]->time)) {
                    return redirect(route('workers.edit', Auth::user()->id));
                }
            }
        }

        if (!empty($servicesAssingneds)) {
            $salaryServiceAssigneds = SalaryServiceAssigneds::where('user_id', '=', $id)->get();

            $dataServicesAssigneds = array();
            foreach (collect(json_decode($servicesAssingneds->services)) as $key => $value) {
                array_push($dataServicesAssigneds, DB::table('services')->select('documents')->where('id', $value)->first());
                array_push($subServices, SubServices::where('service_id', $value)->get());
                array_push($idsSubServices, SubServices::select('id')->where('service_id', $value)->first());
                array_push($externalDocuments, ExternalsDocuments::where('role_id', '=', $worker->role_id)->where('service_id', $value)->get());
                $dataMoment = documentsEditors::whereIn('role_id', [2, 3])->where('service_id', $value)->get();
                if (isset($dataMoment) && !empty($dataMoment) && count($dataMoment) >= 1) {
                    array_push($documentsEditors, documentsEditors::whereIn('role_id', [2, 3])->where('service_id', $value)->get());
                }
            }
            $dataMomen = documentsEditors::where('role_id', [2, 3])->where('service_id', 0)->get();
            if (isset($dataMomen) && !empty($dataMomen) && count($dataMomen) >= 1) {
                array_push($documentsEditors, documentsEditors::whereIn('role_id', [2, 3])->where('service_id', 0)->get());
            }
            array_push($externalDocuments, ExternalsDocuments::where('role_id', '=', $worker->role_id)->where('service_id', 0)->get());

            $dataListFiles = array();
            foreach ($dataServicesAssigneds as $key => $values) {
                foreach (json_decode($values->documents) as $key => $value) {
                    $consult = DB::table('type_docs')->select('id')->where('id', $value)->whereIn('role_id', [2, 3])->orderBy('document_certificate', 'ASC')->first();
                    if (isset($consult)) {
                        array_push($dataListFiles, $consult);
                    }
                }
            }

            // dd($dataListFiles);

            $dataListFilesClear = array();
            foreach (collect($dataListFiles) as $key => $val) {
                array_push($dataListFilesClear, $val->id);
            }

            $documentUserFilesFoo = array();
            foreach (array_unique($dataListFilesClear) as $key => $valID) {
                foreach (collect(json_decode($servicesAssingneds->services)) as $keyS => $valueS) {
                    $test = DB::table('type_docs')->where('id', $valID)->first();
                    if (!empty($test)) {
                        foreach (collect(json_decode($servicesAssingneds->services)) as $key => $value) {
                            if ($test->service_id == $value || $test->service_id == 0 || $test->service_id == '0') {
                                array_push($documentUserFilesFoo,  DB::table('type_docs')->select('id')->where('id', $valID)->first());
                            }
                        }
                    }
                }
            }

            $documentUserFilesFo = array();
            foreach (collect($documentUserFilesFoo) as $key => $val) {
                array_push($documentUserFilesFo, $val->id);
            }

            $documentUserFiles = array();
            foreach (array_unique($documentUserFilesFo) as $key => $valID) {
                $constData = DB::table('type_docs')->where('id', $valID)->whereIn('role_id', [2, 3])->orderBy('name_doc', 'asc')->first();
                if(isset($constData) && !empty($constData)){
                    array_push($documentUserFiles,  $constData);
                }                
            }

            //dd($documentUserFiles);

            /* $documentUserFiles = $documentUserFiles; */
            $filesUploads = collect(DB::table('document_user_files')->select('id', 'document_id', 'date_expedition', 'date_expired', 'file', 'expired')->where('user_id', $id)->where('expired', 0)->orderBy('created_at', 'DESC')->get());
            $filesUploadsExpired = collect(DB::table('document_user_files')->select('id', 'document_id', 'date_expedition', 'date_expired', 'file', 'expired')->where('user_id', $id)->where('expired', '<>', 0)->orderBy('updated_at', 'DESC')->orderBy('expired', 'DESC')->get());

            $documentUserFilesUpload = array();
            foreach ($filesUploads as $key => $value) {
                //dd(DB::table('type_docs')->where('id', $value->document_id)->first());
                array_push($documentUserFilesUpload, DB::table('type_docs')->where('id', $value->document_id)->first());
            }

            $documentUserFilesIDsA = array();
            foreach ($documentUserFiles as $key => $value) {
                array_push($documentUserFilesIDsA, $value->id);
            }

            //dd($documentUserFiles);
            //$testArrayC = $this->OrdenarMatrizColumna($documentUserFiles, 'document_certificate', 'ASC');
            //dd($testArrayC);

            $documentUserFilesIDsU = array();
            foreach ($documentUserFilesUpload as $key => $value) {
                array_push($documentUserFilesIDsU, $value->id);
            }

            $idDIffOne = array_diff($documentUserFilesIDsA, $documentUserFilesIDsU);
            $idDIffTwo = array_diff($documentUserFilesIDsU, $documentUserFilesIDsA);

            $arrayData = '';

            if (!empty($idDIffOne) || !empty($idDIffTwo)) {
                if (!empty($idDIffOne) && count($idDIffOne) >= 1) {
                    $arrayData = $idDIffOne;
                } elseif (!empty($idDIffTwo) && count($idDIffTwo) >= 1) {
                    $arrayData = $idDIffTwo;
                } elseif (!empty($idDIffOne) && count($idDIffOne) >= 1 && !empty($idDIffTwo) && count($idDIffTwo) >= 1) {
                    $arrayData = array_unique(array_merge($idDIffOne, $idDIffTwo));
                }
            }

            $documentUserFilesDinst = array();
            if (!empty($arrayData) && count($arrayData) >= 1) {
                foreach ($arrayData as $key => $value) {
                    $valConsult = DB::table('type_docs')->where('id', $value)->first();
                    if (!empty($valConsult)) {
                        array_push($documentUserFilesDinst, $valConsult);
                    }
                }
            }

            $collections = collect(json_decode($servicesAssingneds->services));

            $data = [];

            foreach ($collections as $collection) {
                array_push($data, DB::table('services')->select('id', 'name_service')->where('id', $collection)->first());
            }

            $servicesDist = DB::table('services')->select('id', 'name_service')->get();

            foreach ($collections as $collection) {
                foreach ($services as $key => $service) {
                    if ($service->id == $collection) {
                        unset($servicesDist[$key]);
                    }
                }
            }
           //dd($filesUploadsExpired); //OrdenarMatrizColumna
            $returnView = view('workers.show_index')
                ->with('typeDocs', $typeDoc)
                ->with('roles', $roles)
                ->with('status', $status)
                ->with('titleJobs', $titleJobs)
                ->with('companies', isset($companies) && !empty($companies) ? $companies : null)
                ->with('confirmationIndependent', $confirmationIndependent)
                ->with('contactEmergency', $contactEmergency)
                ->with('jobInformation', $jobInformation)
                ->with('worker', $worker)
                ->with('workers', $workers)
                ->with('referencesPersonales', $referencesPersonales)
                ->with('referencesPersonalesTwo', $referencesPersonalesTwo)
                ->with('referencesJobs', !empty($referenceJobOneID) ? $this->referencesJobsRepository->find($referenceJobOneID->id) : null)
                ->with('referencesJobsTwo', !empty($referenceJobTwoID) ? $this->referencesJobsRepository->find($referenceJobTwoID->id) : null)
                ->with('services', !empty($services) ? $services : null)
                ->with('servicesAssigned', !empty($servicesAssingneds) ? $servicesAssingneds : null)
                ->with('education', $education)
                ->with('filesUploads', !empty($filesUploads) ? $filesUploads : null)
                ->with('documentUserFiles', !empty($documentUserFiles) ? collect($this->OrdenarMatrizColumna($documentUserFiles, 'name_doc', 'ASC')) : null)
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
                ->with('filesUploadsExpired', !empty($filesUploadsExpired) ? $filesUploadsExpired : null)
                ->with('subServices', !empty($subServices) ? $subServices : null)
                ->with('externalDocuments', !empty($externalDocuments) ? $externalDocuments : null);
        } else {

            $returnView = view('workers.show_index')
                ->with('typeDocs', $typeDoc)
                ->with('roles', $roles)
                ->with('status', $status)
                ->with('titleJobs', $titleJobs)
                ->with('companies', isset($companies) && !empty($companies) ? $companies : null)
                ->with('confirmationIndependent', $confirmationIndependent)
                ->with('contactEmergency', $contactEmergency)
                ->with('jobInformation', $jobInformation)
                ->with('worker', $worker)
                ->with('workers', $workers)
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
                ->with('externalDocuments', !empty($externalDocuments) ? $externalDocuments : null);
        }

        //dd($confirmationIndependent);

        return $returnView;
    }

    /**
     * Show the form for editing the specified Worker.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $worker = $this->workerRepository->find($id);

        $roles = Role::where('id', '<=', 3)->get();

        $status = Statu::all();

        $servicesAssigned = ServiceAssigneds::all();

        $companies = Companies::all();

        $service = Service::all();

        $marital_status = MaritalStatus::all();

        $titleJobs = TitleJobs::all();

        $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $id)->first();
        $contactEmergency = $this->contactEmergencyRepository->find($contactEmergencyID->id);

        $jobInformationID = DB::table('jobs_information')->select('id')->where('user_id', '=', $id)->first();
        $jobInformation = $this->jobInformationRepository->find($jobInformationID->id);

        $educationID = DB::table('educations')->select('id')->where('user_id', '=', $id)->first();
        $education = $this->educationRepository->find($educationID->id);

        $confirmationIndependentID = DB::table('confirmations')->select('id')->where('user_id', '=', $id)->first();
        $confirmationIndependent = $this->confirmationIndependentRepository->find($confirmationIndependentID->id);

        if (empty($worker)) {
            Flash::error('Worker not found');

            return redirect(route('workers.index'));
        }

        return view('workers.edit')
            ->with('roles', $roles)
            ->with('status', $status)
            ->with('confirmationIndependent', $confirmationIndependent)
            ->with('contactEmergency', $contactEmergency)
            ->with('jobInformation', $jobInformation)
            ->with('worker', $worker)
            ->with('education', $education)
            ->with('marital_status', $marital_status)
            ->with('titleJobs', $titleJobs);
    }

    /**
     * Update the specified Worker in storage.
     *
     * @param int $id
     * @param UpdateWorkerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkerRequest $request)
    {
        $worker = $this->workerRepository->find($id);

        if (empty($worker)) {
            Flash::error('Worker not found');

            return redirect(route('workers.index'));
        }

        $worker = $this->workerRepository->update($request->all(), $id);

        Flash::success('Worker updated successfully.');
        $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $id)->first();
        $contactEmergency = $this->contactEmergencyRepository->find($contactEmergencyID->id);

        return view('contact_emergencies.edit')->with('contactEmergency', $contactEmergency);
    }

    /**
     * Update the specified Worker in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function updateState($id, Request $request)
    {
        $worker = $this->workerRepository->find($id);

        if (empty($worker)) {
            Flash::error('Worker not found');

            return redirect(route('workers.index'));
        }

        $worker->statu_id = $worker->statu_id == '1' ? '2' : '1';

        $worker->save();

        Flash::success('Worker updated successfully.');

        $roles = Role::where('id', '<=', 3)->get();

        $status = Statu::all();

        $servicesAssigned = ServiceAssigneds::all();

        $companies = Companies::all();

        $service = Service::all();

        $maritalStatus = MaritalStatus::all();

        $titleJobs = TitleJobs::all();

        $typeDoc = TypeDoc::all();

        $workers = Worker::all();

        $confirmationIndependents = ConfirmationIndependent::all();

        $contactEmergencies = ContactEmergency::all();

        $educations = Education::all();

        $jobInformations = JobInformation::all();

        return redirect(route('workers.index', [
            'roles' => $roles,
            'status' => $status,
            'confirmationIndependents' => $confirmationIndependents,
            'contactEmergencies' => $contactEmergencies,
            'jobInformations' => $jobInformations,
            'workers' => $workers,
            'servicesAssigned' => $servicesAssigned,
            'educations' => $educations
        ]));
    }

    /**
     * Remove the specified Worker from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $worker = $this->workerRepository->find($id);

        if (empty($worker)) {
            Flash::error('Worker not found');

            return redirect(route('workers.index'));
        }

        $this->workerRepository->delete($id);

        $confirmationIndependentID = DB::table('confirmations')->select('id')->where('user_id', '=', $id)->first();
        $educationID = DB::table('educations')->select('id')->where('user_id', '=', $id)->first();
        $contactEmergencyID = DB::table('contacts_emergencys')->select('id')->where('user_id', '=', $id)->first();
        $jobInformationID = DB::table('jobs_information')->select('id')->where('user_id', '=', $id)->first();
        $referencePersonalsID = DB::table('references')->select('id')->where('user_id', '=', $id)->get();
        $referenceJobsID = DB::table('references_jobs')->select('id')->where('user_id', '=', $id)->get();
        $companiesID = DB::table('companies')->select('id')->where('user_id', '=', $id)->first();

        $this->educationRepository->delete($educationID->id);
        $this->confirmationIndependentRepository->delete($confirmationIndependentID->id);
        $this->contactEmergencyRepository->delete($contactEmergencyID->id);
        $this->jobInformationRepository->delete($jobInformationID->id);
        foreach ($referencePersonalsID as $referencePersonalID) {
            $this->referencesPersonalesRepository->delete($referencePersonalID->id);
        }
        foreach ($referenceJobsID as $referenceJobID) {
            $this->referencesJobsRepository->delete($referenceJobID->id);
        }
        if (!empty($companiesID->id)) {
            $this->companiesRepository->delete($companiesID->id);
        }

        Flash::success('Worker deleted successfully.');

        return redirect(route('workers.index'));
    }

    public function sendEmailRecovery(Request $request)
    {
        $input = $request->all();
        $exist = Worker::where('email', $input['email'])->first();
        if(isset($exist) && !empty($exist)){
            Mail::to($exist->email)->send(new resetPassword($exist, $input));
            Flash::success('An email with the recovery link has been sent to the email ' . $input['email'] . '.');
            return redirect(route('login'));
        }else{
            Flash::error('The email ' . $input['email'] . ' does not exist in our records.');
            return redirect(route('resetPassword'));
        }
    }

    public function changePass(Request $request){
        
        $input = $request->all();

        $exist = Worker::where('email', $input['email'])->first();
        if(isset($exist) && !empty($exist)){
            Worker::where('email', $input['email'])->update(['password' => Hash::make($input['password'])]);
            Flash::success('Password updated successfully.');
            return redirect(route('login'));
        }else{
            Flash::error('An error has occurred, please try again later.');
            return redirect(route('resetPassword'));
        }
    }
}
