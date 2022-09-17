<?php

if(!function_exists('respondWithSuccess')){

    function respondWithSuccess($message='', $data = [], $code = 200){

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}

if(!function_exists('respondWithError')){

    function respondWithError($message = '', $code = 400){

        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }
}


if (!function_exists('user_id')) {
    function user_id() {
        return auth()->user()->id;
    }
}

if (!function_exists('imageUpload')) {
    
    function imageUpload($file_name, $destination) {

        $fileName = $_FILES[$file_name]['name'];
        
        $tmpFile = $_FILES[$file_name]['tmp_name'];

        list($name, $extention) = explode('.', $fileName);

        $image = $name . '_' . uniqid() . '.' . $extention;
        
        if (!is_dir($destination)) { mkdir($destination); }

        move_uploaded_file($tmpFile, $destination . '/' . $image);

        return $destination . '/' . $image;
    }
}

