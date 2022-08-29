<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotesSubServicesRegister;
use App\Models\RegisterAttentions;
use App\Models\SubServices;
use App\Models\Service;
use App\Models\User;
use App\Models\Role;
use Flash;
use Response;
use Carbon\Carbon;
use App\Models\ReferencesPersonalesTwo;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Models\SalaryServiceAssigneds;
use App\Models\Units;
use App\Models\ConfigSubServicesPatiente;

class NotesSubServicesRegisterController extends Controller
{      
    /**
     * Display a listing of the NotesSubServicesRegister.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $allNotes = [];
        if(Auth::user()->role_id == 1){
            $allNotes = NotesSubServicesRegister::all()->sortByDesc('created_at')->sortByDesc('id')->values();
        }else{
            $allNotes = NotesSubServicesRegister::where('worker_id', Auth::user()->id)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();
        }
        
        $notes = [];
        foreach($allNotes as $note){
            $worker = User::find($note->worker_id);
            $patiente = User::find($note->patiente_id);
            $service = Service::find($note->service_id);
            $subService = SubServices::find($note->sub_service_id);
            $data = RegisterAttentions::find($note->register_attentions_id);
                
                if(isset($data) && !empty($data)){
                
                    $timeAttention = $data->start->diff($data->end);
                    $times = explode(":", $timeAttention->format('%H:%i:%s'));
    
                    if($times[0] < 10){
                        $times[0] = str_split($times[0])[1];
                    }
    
                    if($times[1] < 10){
                        $times[1] = '0' . $times[1];
                    }
    
                    if($times[2] < 10){
                        $times[2] = '0' . $times[2];
                    }
                    
                    $data->time_attention = $times[0] . ':' . $times[1] . ':' . $times[2];
                }

            $newNote = array( 
                "id" => $note->id,
                "register_attentions_id" => $note->register_attentions_id,
                "worker_id" => array('id' => $worker->id, 'fullName' => $worker->first_name . ' ' . $worker->last_name),
                "patiente_id" => array('id' => $patiente->id, 'fullName' => $patiente->first_name . ' ' . $patiente->last_name),
                "service_id" => array('id' => $service->id, 'nameService' => $service->name_service),
                "sub_service_id" => array('id' => $subService->id, 'nameSubService' => $subService->name_sub_service),
                "note" => $note->note,
                "firma" => $note->firma,
                "status" => isset($data) && !empty($data) && isset($data->status) && !empty($data->status) ? $data->status : '',
                "start" => isset($data) && !empty($data) && isset($data->start) && !empty($data->start) ? date('m-d-Y h:i:s A', strtotime($data->start)) : '',
                "end" => isset($data) && !empty($data) && isset($data->end) && !empty($data->end) ? date('m-d-Y h:i:s A', strtotime($data->end)) : '',
                "time_attention" => isset($data) && !empty($data) && isset($data->time_attention) && !empty($data->time_attention) ? $data->time_attention : '00:00:00',
                "created_at" => Carbon::parse($note->created_at)->toDateTimeString(),
                "updated_at" => Carbon::parse($note->updated_at)->toDateTimeString()
            );

            $dataPagosWorker = SalaryServiceAssigneds::where('service_id', $subService->id)->where('user_id', $worker->id)->first();

            if(isset($dataPagosWorker) && !empty($dataPagosWorker)){
                if(!isset($dataPagosWorker->salary) || empty($dataPagosWorker->salary)){
                    $dataPagosWorker->salary = $subService->worker_payment;
                    $newNote['unit_value_worker'] = $dataPagosWorker->salary;
                }else{
                    $newNote['unit_value_worker'] = $dataPagosWorker->salary;
                }

                $dataConfig = ConfigSubServicesPatiente::where('salary_service_assigned_id', $dataPagosWorker->id)->first();
                                    
                if(isset($dataConfig) && !empty($dataConfig)){
                    if(isset($dataConfig->unit_id) && !empty($dataConfig->unit_id)){
                        $dataUnidadConfig = Units::find($dataConfig->unit_id);
                        if(isset($dataUnidadConfig) && !empty($dataUnidadConfig)){
                            $newNote['unidad_time_worker'] = $dataUnidadConfig->time;
                            $newNote['unidad_type_worker'] = $dataUnidadConfig->type_unidad == 0 ? 'Minutes' : 'Hours';
                            $newNote['unidad_type_worker_int'] = $dataUnidadConfig->type_unidad;
                        }
                    }else{
                        $dataUnidadWorker = Units::find($subService->unit_worker_payment_id);
                        $newNote['unidad_time_worker'] = $dataUnidadWorker->time;
                        $newNote['unidad_type_worker'] = $dataUnidadWorker->type_unidad == 0 ? 'Minutes' : 'Hours';
                        $newNote['unidad_type_worker_int'] = $dataUnidadWorker->type_unidad;
                    }
                }else{
                    $dataUnidadWorker = Units::find($subService->unit_worker_payment_id);
                    $newNote['unidad_time_worker'] = $dataUnidadWorker->time;
                    $newNote['unidad_type_worker'] = $dataUnidadWorker->type_unidad == 0 ? 'Minutes' : 'Hours';
                    $newNote['unidad_type_worker_int'] = $dataUnidadWorker->type_unidad;
                }

                $unidadesPorPagar = '';
                if(isset($newNote['time_attention']) && !empty($newNote['time_attention']) && strval($newNote['time_attention']) != '00:00:00'){
                    $times = explode(":", $newNote['time_attention']);
                    if($newNote['unidad_type_worker_int'] == 0){
                        $unidH = ($times[0] * 60) / $newNote['unidad_time_worker'];
                        $unidM = $times[1] / $newNote['unidad_time_worker'];

                        $calc = $unidH + $unidM;
                        $unidadesPorPagar = number_format((float)$calc, 2, '.', '');

                    }else{
                        $calc = ($times[0] + ($times[1] / 100)) / $newNote['unidad_time_worker'];
                        $unidadesPorPagar = number_format((float)$calc, 2, '.', '');
                    }
                }else{
                    $unidadesPorPagar = number_format((float)00, 2, '.', '');
                }
                                    
                $newNote['unid_pay_worker'] = $unidadesPorPagar;
                $calcPay = $newNote['unid_pay_worker'] * $dataPagosWorker->salary;
                $newNote['mont_pay'] = number_format((float)$calcPay, 2, '.', '');                        
            }

            $dataCobroPatiente = SalaryServiceAssigneds::where('service_id', $subService->id)->where('user_id', $patiente->id)->first();

            if(isset($dataCobroPatiente) && !empty($dataCobroPatiente)){
                if(!isset($dataCobroPatiente->customer_payment) || empty($dataCobroPatiente->customer_payment)){
                    $dataCobroPatiente->customer_payment = $subService->price_sub_service;
                    $newNote['unit_value_patiente'] = $subService->price_sub_service;
                }else{
                    $newNote['unit_value_patiente'] = $dataCobroPatiente->customer_payment;
                }
                                        
                $dataConfig = ConfigSubServicesPatiente::where('salary_service_assigned_id', $dataCobroPatiente->id)->first();
                if(isset($dataConfig) && !empty($dataConfig)){
                    if(isset($dataConfig->unit_id) && !empty($dataConfig->unit_id)){
                        $dataUnidadConfig = Units::find($dataConfig->unit_id);
                            if(isset($dataUnidadConfig) && !empty($dataUnidadConfig)){
                                $newNote['unidad_time_patiente'] = $dataUnidadConfig->time;
                                $newNote['unidad_type_patiente'] =  $dataUnidadConfig->type_unidad == 0 ? 'Minutes' : 'Hours';
                                $dataCobroPatiente->unidades_aprovadas = $dataUnidadConfig->approved_units;
                                $newNote['unidad_type_patiente_int'] = $dataUnidadConfig->type_unidad;
                            }
                        }else{
                            $dataUnidadPatiente = Units::find($subService->unit_customer_id);
                            $newNote['unidad_time_patiente'] = $dataUnidadPatiente->time;
                            $newNote['unidad_type_patiente'] =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                            $newNote['unidad_type_patiente_int'] = $dataUnidadPatiente->type_unidad;
                        }
                    }else{
                        $dataUnidadPatiente = Units::find($subService->unit_customer_id);
                        $newNote['unidad_time_patiente'] = $dataUnidadPatiente->time;
                        $newNote['unidad_type_patiente'] =  $dataUnidadPatiente->type_unidad == 0 ? 'Minutes' : 'Hours';
                        $newNote['unidad_type_patiente_int'] = $dataUnidadPatiente->type_unidad;
                    }

                    $unidadesPorCobrar = '';
                    if(isset($newNote['time_attention']) && !empty($newNote['time_attention']) && strval($newNote['time_attention']) != '00:00:00'){
                        $times = explode(":", $newNote['time_attention']);
                        if($newNote['unidad_type_patiente_int'] == 0){
                            if($newNote['unidad_time_patiente'] != 0){
                                $unidH = ($times[0] * 60) / $newNote['unidad_time_patiente'];
                            }
                            if($newNote['unidad_time_patiente'] != 0){
                                $unidM = $times[1] / $newNote['unidad_time_patiente'];
                            }

                            $calc = $unidH + $unidM;
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');

                        }else{
                            $calc = ($times[0] + ($times[1] / 100)) / $newNote['unidad_time_patiente'];
                            $unidadesPorCobrar = number_format((float)$calc, 2, '.', '');
                        }
                    }else{
                        $unidadesPorCobrar = number_format((float)00, 2, '.', '');
                    }
                                    
                $newNote['unid_cob_patiente'] = $unidadesPorCobrar;
                $calcCob = $newNote['unid_cob_patiente'] * $dataCobroPatiente->customer_payment;
                $newNote['mont_cob'] = number_format((float)$calcCob, 2, '.', '');
            }



            $calcGan = $newNote['mont_cob'] - $newNote['mont_pay'];
            $newNote['ganancia_empresa'] = number_format((float)$calcGan, 2, '.', '');

            array_push($notes, $newNote);
        }

        //foreach(collect($notes) as $key => $note){
            //dd($note['id']);
        //};

        if(Auth::user()->role_id == 1){
            return view('notes.index')->with('notes', collect($notes));
        }else{
            $dataFull = ReferencesPersonalesTwo::where('user_id', Auth::user()->id)->where('reference_number', 2)->get();

            if(isset($dataFull) && !empty($dataFull)){
                if(!isset($dataFull[0]->name_job) || empty($dataFull[0]->name_job) && !isset($dataFull[0]->address) || empty($dataFull[0]->address) && !isset($dataFull[0]->phone) || empty($dataFull[0]->phone) && !isset($dataFull[0]->ocupation) || empty($dataFull[0]->ocupation) && !isset($dataFull[0]->time) || empty($dataFull[0]->time)){
                    return redirect(route('workers.edit', Auth::user()->id));
                }else{
                    return view('notes.index')->with('notes', collect($notes));
                }
            }
        }
    }

    /**
     * Show the form for creating a new NotesSubServicesRegister.
     *
     * @return Response
     */
    public function create()
    {
        $workers = User::where('role_id', 2)->get();
        $patientes = User::where('role_id', 4)->get();
        $roles = Role::all();
        $services = Service::all();
        $subServices = SubServices::all();

        return view('notes.create')->with('workers', $workers)->with('patientes', $patientes)->with('roles', $roles)->with('services', $services)->with('subServices', $subServices);
    }

    /**
     * Store a newly created NotesSubServicesRegister in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified NotesSubServicesRegister.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $noteData = NotesSubServicesRegister::find($id);

        $worker = User::find($noteData->worker_id);
        $patiente = User::find($noteData->patiente_id);
        $service = Service::find($noteData->service_id);
        $subService = SubServices::find($noteData->sub_service_id);
        $data = RegisterAttentions::find($noteData->register_attentions_id);

        $note = [];
        $newNote = array( 
            "id" => $noteData->id,
            "register_attentions_id" => $noteData->register_attentions_id,
            "worker_id" => array('id' => $worker->id, 'fullName' => $worker->first_name . ' ' . $worker->last_name),
            "patiente_id" => array('id' => $patiente->id, 'fullName' => $patiente->first_name . ' ' . $patiente->last_name),
            "service_id" => array('id' => $service->id, 'nameService' => $service->name_service),
            "sub_service_id" => array('id' => $subService->id, 'nameSubService' => $subService->name_sub_service),
            "note" => $noteData->note,
            "firma" => $noteData->firma,
            "status" => $data->status,
            "register_attentions" => $data,
            "created_at" => Carbon::parse($noteData->created_at)->toDateTimeString(),
            "updated_at" => Carbon::parse($noteData->updated_at)->toDateTimeString()
        );

        array_push($note, $newNote);

        return view('notes.show')->with('note', collect($note));
    }

    /**
     * Show the form for editing the specified NotesSubServicesRegister.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $noteData = NotesSubServicesRegister::find($id);

        $worker = User::find($noteData->worker_id);
        $patiente = User::find($noteData->patiente_id);
        $service = Service::find($noteData->service_id);
        $subService = SubServices::find($noteData->sub_service_id);
        $data = RegisterAttentions::find($noteData->register_attentions_id);

        $note = [];
        $newNote = array( 
            "id" => $noteData->id,
            "register_attentions_id" => $noteData->register_attentions_id,
            "worker_id" => array('id' => $worker->id, 'fullName' => $worker->first_name . ' ' . $worker->last_name),
            "patiente_id" => array('id' => $patiente->id, 'fullName' => $patiente->first_name . ' ' . $patiente->last_name),
            "service_id" => array('id' => $service->id, 'nameService' => $service->name_service),
            "sub_service_id" => array('id' => $subService->id, 'nameSubService' => $subService->name_sub_service),
            "note" => $noteData->note,
            "firma" => $noteData->firma,
            "status" => $data->status,
            "register_attentions" => $data,
            "created_at" => Carbon::parse($noteData->created_at)->toDateTimeString(),
            "updated_at" => Carbon::parse($noteData->updated_at)->toDateTimeString()
        );

        array_push($note, $newNote);

        //$test = collect($note);
        //dd($test[0]);

        return view('notes.edit')->with('note', collect($note));
    }

    /**
     * Update the NotesSubServicesRegister in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        $registerNote = NotesSubServicesRegister::find($id);

        $uploadImage = '';

        if(isset($input['firma']) && !empty($input['firma'])){
            if($registerNote->firma == '' || $registerNote->firma == null || strcmp($registerNote->firma, $input['firma']) !== 0){
                $file = $input['firma'];
                $titleFile = "firma_nota_" . $id;
                $uploadImage = createFile($file, $titleFile, true);
            }
        }

        $regNote = $registerNote;

        $regNote->register_attentions_id = $input['register_attentions_id'];
        $regNote->worker_id = $input['worker_id'];
        $regNote->service_id = $input['service_id'];
        $regNote->patiente_id = $input['patiente_id'];
        $regNote->sub_service_id = $input['sub_service_id'];
        $regNote->note = $input['note'];
        $regNote->firma = isset($uploadImage) && !empty($uploadImage) ? $uploadImage : ($registerNote->firma != '' &&  $registerNote->firma != null ? $registerNote->firma : null) ;

        $regNote->save();

        $attentionReg = RegisterAttentions::find($input['register_attentions_id']);

        if(Auth::user()->role_id = 1 && !isset($input['typeReturn']) || empty($input['typeReturn'] || $input['typeReturn'] != 'json')){

            $updateAt = $attentionReg;

            $updateAt->worker_id = $input['worker_id'];
            $updateAt->service_id = $input['service_id'];
            $updateAt->patiente_id = $input['patiente_id'];
            $updateAt->sub_service_id = $input['sub_service_id'];
            $updateAt->start = $input['start'];
            $updateAt->lat_start = $input['lat_start'];
            $updateAt->long_start = $input['long_end'];
            $updateAt->end = $input['end'];
            $updateAt->lat_end = $input['lat_end'];
            $updateAt->long_end = $input['long_end'];

            $updateAt->save();

            $attentionReg = RegisterAttentions::find($input['register_attentions_id']);

        }

        if(isset($regNote->note) && !empty($regNote->note) && isset($regNote->firma) && !empty($regNote->firma)){
            $attentionReg->status = 3;
            $attentionReg->save();
        }

        if(Auth::user()->role_id == 1){
            if(isset($input['typeReturn']) && !empty($input['typeReturn'] && $input['typeReturn'] == 'json') ){
                return response()->json(['succes' => true, 'urlImagen' => $regNote->firma, 'prevUrl' => $input['previa_url'], 'statusAttention' => $attentionReg->status, 'userAuth' => Auth::user()->role_id]);
            }else{
                Flash::success('Update Save successfully.');
                return redirect(route('notesSubServices.edit', $id));
            }
        }

        if(strpos($input['previa_url'], "dashboard")){
            if(isset($input['typeReturn']) && !empty($input['typeReturn'] && $input['typeReturn'] == 'json') ){
                return response()->json(['succes' => true, 'urlImagen' => $regNote->firma, 'prevUrl' => $input['previa_url'], 'statusAttention' => $attentionReg->status, 'userAuth' => Auth::user()->role_id]);
            }else{
                if($attentionReg->status == 2 && !isset($regNote->firma) || !empty($regNote->firma) && isset($regNote->note) && !empty($regNote->note)){
                    Flash::success('Note Save successfully.');

                    $noteData = NotesSubServicesRegister::find($id);

                    $worker = User::find($noteData->worker_id);
                    $patiente = User::find($noteData->patiente_id);
                    $service = Service::find($noteData->service_id);
                    $subService = SubServices::find($noteData->sub_service_id);
                    $data = RegisterAttentions::find($noteData->register_attentions_id);

                    $note = [];
                    $newNote = array( 
                        "id" => $noteData->id,
                        "register_attentions_id" => $noteData->register_attentions_id,
                        "worker_id" => array('id' => $worker->id, 'fullName' => $worker->first_name . ' ' . $worker->last_name),
                        "patiente_id" => array('id' => $patiente->id, 'fullName' => $patiente->first_name . ' ' . $patiente->last_name),
                        "service_id" => array('id' => $service->id, 'nameService' => $service->name_service),
                        "sub_service_id" => array('id' => $subService->id, 'nameSubService' => $subService->name_sub_service),
                        "note" => $noteData->note,
                        "firma" => $noteData->firma,
                        "status" => $data->status,
                        "created_at" => Carbon::parse($noteData->created_at)->toDateTimeString(),
                        "updated_at" => Carbon::parse($noteData->updated_at)->toDateTimeString()
                    );




                    array_push($note, $newNote);

                    return view('notes.edit')->with('note', collect($note))->with('prevUrl', $input['previa_url']);
                }else if($attentionReg->status == 2 && !isset($regNote->note) || empty($regNote->note) && isset($regNote->firma) && !empty($regNote->firma)){
                    Flash::success('Signature Save successfully.');
                    return response()->json(['succes' => true, 'urlImagen' => $regNote->firma, 'prevUrl' => $input['previa_url'], 'statusAttention' => $attentionReg->status, 'userAuth' => Auth::user()->role_id]);
                }else if($attentionReg->status == 3){
                    return redirect(route('home'));
                }
            }
        }else{
            if(isset($input['typeReturn']) && !empty($input['typeReturn'] && $input['typeReturn'] == 'json') ){
                return response()->json(['succes' => true, 'urlImagen' => $regNote->firma, 'prevUrl' => $input['previa_url'], 'statusAttention' => $attentionReg->status, 'userAuth' => Auth::user()->role_id]);
            }else{
                if($attentionReg->status == 3){
                    Flash::success('Note Save successfully.');
                    return redirect(route('notesSubServices.index'));
                }else{
                    Flash::success('Note Save successfully.');
                    return redirect(route('notesSubServices.edit', $id));
                }
            }
        }
    }

    /**
     * Remove the specified NotesSubServicesRegister from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $note = NotesSubServicesRegister::find($id);

        if (empty($note)) {
            Flash::error('Activity and Note not found');

            return redirect(route('notesSubServices.index'));
        }
        
            $reg = RegisterAttentions::find($note->register_attentions_id);
            $reg->delete();
            
        deleteFile($note->firma);
        $note->delete();

        Flash::success('Activity and Note delete successfully');
        return redirect(route('notesSubServices.index'));
    }
}