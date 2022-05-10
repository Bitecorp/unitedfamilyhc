<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\DataFile;

function createFile($file, $titleFile){
    $name = $file->getClientOriginalName();
    $ext  = $file->getClientOriginalExtension();
    $mime_type = $file->getClientMimeType();
    $filename = pathinfo($name, PATHINFO_FILENAME);
    $nameClean = '';
    $fullName = '';
    if($titleFile != ''){
        $nameClean = str_replace(' ', '_', $titleFile);
        $fullName = $nameClean . "." . $ext;
    }else{
        $nameClean = str_replace(' ', '_', $filename);
        $fullName = $nameClean . "_" .time() . "." . $ext;
    }


    $file = Storage::disk('public_files')->put($fullName, file_get_contents($file), 'public');
    $url  = $fullName  /* Storage::disk('public_files')->url($fullName ) */;
    $path = $fullName  /* Storage::disk('public_files')->url($fullName ) */;

/*
    $path = $file->store('public_files');

    Storage::setVisibility($path, 'public');

    $url      = Storage::url($path); */
    /* $api_url  = env("APP_URL");
    $api_port = env("APP_PORT");
    if(!is_null($api_port)){
        $url  = $api_url . ':' . $api_port . $url;
    }else{
        $url  = $api_url . $url;
    } */
   /*  $nameFile = explode("/",ltrim($url, "/")); */
    /* dd($nameFile[1]); */

    $new_file = DataFile::create([
        'name'      => $fullName,
        'ext'       => $ext,
        'mime_type' => $mime_type,
        'path'      => $path,
        'url'       => $url,
    ]);
    $new_file->save();

    return $url;
}

function deleteFile($url){

    $file = DataFile::select('id', 'url')->where('url', $url)->first();

    if (!empty($file)) {
        $nameFile = explode("/",ltrim($url, "/"));
        Storage::disk('public_files')->delete($nameFile[0]);
        DataFile::destroy($file->id);
    }

    return true;
}

function recoveryFile($url){

    $file = DataFile::select('id', 'url')->where('url', $url)->first();

    if (!empty($file) && Storage::disk('public_files')->exists($url)) {
        $fileRecovery = Storage::disk('public_files')->get($url);
    }

    return $fileRecovery;
}