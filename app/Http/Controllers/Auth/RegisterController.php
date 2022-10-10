<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;

use Laracasts\Flash\Flash;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::LOGIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $dataReuturn = DB::table('users')->insert([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' =>  Hash::make($data['password']),
            'role_id' => 2, 
            'statu_id' => 1, 
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if($dataReuturn){
            $dataReuturn = User::where('email', $data['email'])->first();
        }

        DB::table('contacts_emergencys')->insert([
            'user_id' => $dataReuturn->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('jobs_information')->insert([
            'user_id' => $dataReuturn->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('educations')->insert([
            'user_id' => $dataReuturn->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('confirmations')->insert([
            'user_id' => $dataReuturn->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('references')->insert([
            'user_id' => $dataReuturn->id,
            'reference_number' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('references_jobs')->insert([
            'user_id' => $dataReuturn->id,
            'reference_number' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('references')->insert([
            'user_id' => $dataReuturn->id,
            'reference_number' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

         DB::table('references_jobs')->insert([
            'user_id' => $dataReuturn->id,
            'reference_number' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Flash::success('Worker saved successfully.');
        return $dataReuturn;
    }
}
