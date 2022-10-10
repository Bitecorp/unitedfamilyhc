<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ChangePassGlobal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'changePass';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cambia la contrasenas de todos los usuarios de un solo golpe';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    { 

        $allUsers = User::all(); //->update(['email' => false])

        foreach($allUsers as $key => $user){
            $us = User::find($user->id);
            
            if(!isset($user->ssn) || empty($user->ssn)){                
                $us->password = Hash::make('@' . substr(mb_strtoupper($user->first_name),0,2) . '#' . mt_rand(1,10) . '#' . substr(mb_strtolower($user->last_name),0,2) . '@');
            }else{
                $us->password = Hash::make('@' . substr(mb_strtoupper($user->first_name),0,2) . '#' . $user->ssn . '#' . substr(mb_strtolower($user->last_name),0,2) . '@');
            }
            
            $us->save();
        }
        return 0;
    }
}
