<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\DataFile;
use Jenssegers\Agent\Agent;

function createFile($file, $titleFile, $base64 = false)
{

    if (!$base64) {
        $ext  = $file->getClientOriginalExtension();
        $name = $file->getClientOriginalName();
        $mime_type = $file->getClientMimeType();

        if ($mime_type == "application/octet-stream") {
            return false;
        }
    } else {
        $ext  = 'png';
        $name = $titleFile . '.' . $ext;
        $mime_type = 'image/png';
    }

    $nameClean = '';
    $fullName = '';

    if (isset($titleFile) && !empty($titleFile) && $titleFile != '') {
        $nameClean = str_replace(' ', '_', $titleFile);
        if ($base64) {
            $fullName = $nameClean . "_" . time() . "." . $ext;
        } else {
            $fullName = $nameClean . "." . $ext;
        }
    } else {
        $nameClean = str_replace(' ', '_', pathinfo($name, PATHINFO_FILENAME));
        $fullName = $nameClean . "_" . time() . "." . $ext;
    }

    if ($base64) {
        $image = $file;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = $fullName;
        $file = Storage::disk('public_files')->put($imageName, base64_decode($image), 'public');
        $url  = $imageName /* Storage::disk('public_files')->url($fullName ) */;
        $path = $imageName  /* Storage::disk('public_files')->url($fullName ) */;
    } else {
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

function deleteFile($url)
{

    $file = DataFile::select('id', 'url')->where('url', $url)->first();

    if (!empty($file)) {
        $nameFile = explode("/", ltrim($url, "/"));
        Storage::disk('public_files')->delete($nameFile[0]);
        DataFile::destroy($file->id);
    }

    return true;
}

function sumaFechasTiempos ($fechaOne, $fechaTwo)
{
    $fechaOne = explode(":", $fechaOne);
    $fechaTwo = explode(":", $fechaTwo);

    $sh = intval($fechaOne[0]) + intval($fechaTwo[0]);
    $sm = intval($fechaOne[1]) + intval($fechaTwo[1]);
    $ss = intval($fechaOne[2]) + intval($fechaTwo[2]);

    $sumaTimes = $sh . ':' . $sm . ':' . $ss;

    $times = explode(':', $sumaTimes);

    if($times[0] < 10){
        $times[0] = str_split($times[0])[1];
    }

    if($times[1] < 10){
        $times[1] = '0' . $times[1];
    }

    if($times[2] < 10){
        $times[2] = '0' . $times[2];
    }

    $timeU = $times[0] . ':' . $times[1] . ':' . $times[2];
    return $timeU;
}
