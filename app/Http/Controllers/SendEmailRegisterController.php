<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Flash;
use Response;
use Mail;
use App\Mail\registerWorker;
use App\Models\User;

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
        $exist = User::where('email', $input['email'])->first();
        if(isset($exist) && !empty($exist)){
            Flash::error('There is already a user with this email.');

            return view('workers.emailRegisterWorker');
        }else{

            $data = [
                'btnURL' => env('APP_URL', 'https://app.unitedfamilyhc.com/') . 'register/?code=' . encriptar($input['email']),
                'email' => $input['email']
            ];

            Mail::to($data['email'])->cc(env('MAIL_USERNAME', 'update@unitedfamilyhc.com'))->send(new registerWorker($data));
            
            Flash::success('Email for new employee registration sent correctly.');

            return view('workers.emailRegisterWorker');
        }
    }
}