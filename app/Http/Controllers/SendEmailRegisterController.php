<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Flash;
use Response;
use Mail;
use App\Mail\registerWorker;

class SendEmailRegisterController extends Controller
{
    /**
     * Display a listing of the Worker.
     *
     * @return Response
     */
    public function emailRegisterWorker(){

        return view('workers.emailRegisterWorker');
    }


    /**
     * Remove the specified Worker from storage.
     *
     * @return Response
     */
    public function sendEmailRegisterWorker(Request $request)
    {
        $input = $request->all();
        $data = [
            'btnURL' => 'http://app.unitedfamilyhc.com/register/?email=' . $input['email'] . '&code=' . Hash::make($input['email']),
            'email' => $input['email']
        ];

        Mail::to($data['email'])->send(new registerWorker($data));
        
        Flash::success('Email for new employee registration sent correctlyr.');

        return view('workers.emailRegisterWorker');
    }
}