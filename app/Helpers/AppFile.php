<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class AppFile
{
    // public static function base64_to_jpeg($base64_string, $output_file) {
    public static function base64_to_jpeg($img) {
        $path = storage_path('app/public/');

        $parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $parts[0]);
        $image_type = $image_type_aux[1];
        $base64 = base64_decode($parts[1]);
        $filename = uniqid(). '.'.$image_type;
        $file = $path . $filename;

        file_put_contents($file, $base64);
        return $filename;
    }

    public static function upload(string $disk, $file)
    {
        // $fileEx   = $file->extension();
        $fileEx = $file->getClientOriginalExtension();
        $filename = sha1(date('YmdHis')) . '.' . $fileEx;
        $path     = Storage::disk($disk)->putFileAs('', $file, $filename);

        return $path;
    }

    public static function url(string $disk, $filename)
    {
        if (Storage::disk($disk)->exists($filename)) {
            return Storage::url($disk . '/' . $filename);
        }
        return false;
    }

    public static function path(string $disk, $filename)
    {
        if (Storage::disk($disk)->exists($filename)) {
            return Storage::disk($disk)->path($filename);
        }
        return false;
    }

    public static function download(string $disk, $filename)
    {   
        if (Storage::disk($disk)->exists($filename)) {
            return Storage::disk($disk)->download($filename);
        }
        return false;
    }

    public static function delete(string $disk, $filename)
    {   
        if ( Storage::disk($disk)->exists($filename) ) {
            Storage::disk($disk)->delete($filename);
        }
        return true;
    }

    public static function mkdirIfNotExist($directory)
    {
        if (!Storage::directories($directory)) {
            Storage::makeDirectory($directory);
        }
        return true;
    }    
}