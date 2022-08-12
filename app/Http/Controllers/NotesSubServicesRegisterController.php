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
        //dd(DB::select('SELECT role_id FROM documents_editors GROUP BY role_id'));
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

            $newNote = array( 
                "id" => $note->id,
                "register_attentions_id" => $note->register_attentions_id,
                "worker_id" => array('id' => $worker->id, 'fullName' => $worker->first_name . ' ' . $worker->last_name),
                "patiente_id" => array('id' => $patiente->id, 'fullName' => $patiente->first_name . ' ' . $patiente->last_name),
                "service_id" => array('id' => $service->id, 'nameService' => $service->name_service),
                "sub_service_id" => array('id' => $subService->id, 'nameSubService' => $subService->name_sub_service),
                "note" => $note->note,
                "firma" => $note->firma,
                "status" => $data->status,
                "start" => Carbon::createFromFormat('Y-m-d H:i:s', $data->start)->format('d-m-Y'),
                "end" => Carbon::createFromFormat('Y-m-d H:i:s', $data->end)->format('d-m-Y'),
                "created_at" => Carbon::parse($note->created_at)->toDateTimeString(),
                "updated_at" => Carbon::parse($note->updated_at)->toDateTimeString()
            );

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
        
        $note->delete();

        Flash::success('Activity and Note delete successfully');
        return redirect(route('notesSubServices.index'));
    }
}
