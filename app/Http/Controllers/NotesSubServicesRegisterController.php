<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotesSubServicesRegister;
use App\Models\RegisterAttentions;
use App\Models\SubServices;
use App\Models\Service;
use App\Models\User;
use Flash;
use Response;
use Carbon\Carbon;
use App\Models\ReferencesPersonalesTwo;
use Auth;

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
        $allNotes = NotesSubServicesRegister::all()->sortByDesc('created_at')->sortByDesc('id')->values();
        
        $notes = [];
        foreach($allNotes as $note){
            $worker = User::find($note->worker_id);
            $patiente = User::find($note->patiente_id);
            $service = Service::find($note->service_id);
            $subService = SubServices::find($note->sub_service_id);
            $dataStatus = RegisterAttentions::find($note->register_attentions_id);

            $newNote = array( 
                "id" => $note->id,
                "register_attentions_id" => $note->register_attentions_id,
                "worker_id" => array('id' => $worker->id, 'fullName' => $worker->first_name . ' ' . $worker->last_name),
                "patiente_id" => array('id' => $patiente->id, 'fullName' => $patiente->first_name . ' ' . $patiente->last_name),
                "service_id" => array('id' => $service->id, 'nameService' => $service->name_service),
                "sub_service_id" => array('id' => $subService->id, 'nameSubService' => $subService->name_sub_service),
                "note" => $note->note,
                "firma" => $note->firma,
                "status" => $dataStatus->status,
                "created_at" => Carbon::parse($note->created_at)->toDateTimeString(),
                "updated_at" => Carbon::parse($note->updated_at)->toDateTimeString()
            );

            array_push($notes, $newNote);
        }

        //foreach(collect($notes) as $key => $note){
            //dd($note['id']);
        //};

        $dataFull = ReferencesPersonalesTwo::where('user_id', Auth::user()->id)->where('reference_number', 2)->get();

        if(isset($dataFull) && !empty($dataFull)){
            if(!isset($dataFull[0]->name_job) || empty($dataFull[0]->name_job) && !isset($dataFull[0]->address) || empty($dataFull[0]->address) && !isset($dataFull[0]->phone) || empty($dataFull[0]->phone) && !isset($dataFull[0]->ocupation) || empty($dataFull[0]->ocupation) && !isset($dataFull[0]->time) || empty($dataFull[0]->time)){
                return redirect(route('workers.show', Auth::user()->id));
            }else{
                return view('notes.index')->with('notes', collect($notes));
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
        //
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
        $dataStatus = RegisterAttentions::find($noteData->register_attentions_id);

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
            "status" => $dataStatus->status,
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
        $dataStatus = RegisterAttentions::find($noteData->register_attentions_id);

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
            "status" => $dataStatus->status,
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

        $file = $input['firma'];
        $titleFile = "firma_nota_" . $id;
        $uploadImage = createFile($file, $titleFile, true);

        $regNote = NotesSubServicesRegister::find($id);

        $regNote->register_attentions_id = $input['register_attentions_id'];
        $regNote->worker_id = $input['worker_id'];
        $regNote->service_id = $input['service_id'];
        $regNote->patiente_id = $input['patiente_id'];
        $regNote->sub_service_id = $input['sub_service_id'];
        $regNote->note = $input['note'];
        $regNote->firma = $uploadImage;

        $regNote->save();

        $attentionReg = RegisterAttentions::find($input['register_attentions_id']);

        if(isset($regNote->note) && !empty($regNote->note) && isset($regNote->firma) && !empty($regNote->firma)){
            $attentionReg->status = 3;

            $attentionReg->save();
        }

        if(isset($input['typeReturn']) && !empty($input['typeReturn'] && $input['typeReturn'] == 'json') ){
            return response()->json(['succes' => true, 'urlImagen' => $regNote->firma]);
        }else{
            Flash::success('Note updated successfully.');
            return redirect(route('notesSubServices.index'));
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
        //
    }
}
