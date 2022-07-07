<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\DataFile;

function createFile($file, $titleFile, $base64 = false){

    if(!$base64){
        $ext  = $file->getClientOriginalExtension();
        $name = $file->getClientOriginalName();
        $mime_type = $file->getClientMimeType();
        $filename = pathinfo($name, PATHINFO_FILENAME);
    }else{
        $ext  = 'png';
        $name = $titleFile . '.' . $ext;
        $mime_type = 'image/png';
    }

    $nameClean = '';
    $fullName = '';

    if($titleFile != ''){
        $nameClean = str_replace(' ', '_', $titleFile);
        if($base64){
            $fullName = $nameClean . "_" . time() . "." . $ext;
        }else{
            $fullName = $nameClean . "." . $ext;
        }
    }else{
        $nameClean = str_replace(' ', '_', $filename);
        $fullName = $nameClean . "_" . time() . "." . $ext;
    }

    if($base64){
        $image = $file;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = $fullName;
        $file = Storage::disk('public_files')->put($imageName, base64_decode($image), 'public');
        $url  = $imageName /* Storage::disk('public_files')->url($fullName ) */;
        $path = $imageName  /* Storage::disk('public_files')->url($fullName ) */;
    }else{
        $file = Storage::disk('public_files')->put($fullName, file_get_contents($file), 'public');
        $url  = $fullName  /* Storage::disk('public_files')->url($fullName ) */;
        $path = $fullName  /* Storage::disk('public_files')->url($fullName ) */;
    }

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
        'name'      => $base64 ? $imageName : $fullName,
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