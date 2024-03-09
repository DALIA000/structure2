<?php

use App\Services\LoggedinUser;
use Illuminate\Support\Facades\Cache;

function remove_special_chars($str) {
    return str_replace(['\'', '"', ',' , ';', '<', '>', '(', ')', '-', '+'], '', $str);
}

function responseJson($response_status, $massage, $object = null, $pagination = null)
{
    return response()->json([
        'message' => $massage,
        'data' => $object,
        'pagination' => $pagination,
    ], $response_status);
}

function trans_class_basename($class) {
    return trans('models.'.class_basename($class));
}

function user()
{
    return LoggedinUser::user();
}


function cacheForget($key)
{
    return Cache::forget($key);
}
