<?php

namespace App\Http\Repositories\AdminAuth;

use App\Jobs\SendMail;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PinCodeMail;

class AdminAuthRepository implements AdminAuthInterface
{
    private $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    public function login($request)
    {
        $model = $this->model->where('email', $request->email)->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('auth.admin.failed')]]];}
            if (!Hash::check($request->password, $model->password)) {
            return ['status' => false, 'errors' => ['error' => [trans('auth.password')]]];}
        return ['status'=> true, 'data' => $model];
    }

    public function update($request){
    if(!Auth::user()){
        return ['status' => false, 'errors' => ['error' => [trans('auth.forbidden')]]];
    }
    $user = Auth::user();
    if ($request->has('email')) {
        $user->update([
            'email' => $request->email,
        ]);
    }
    if ($request->has('password')) {
        $user->update([
            'password' => $request->password,
        ]);
    }
    if ($request->has('name')) {
        $user->update([
            'name' => $request->name,
        ]);
    }
    if ($request->has('username')) {
        $user->update([
            'username' => $request->username,
        ]);
    }
    return ['status' => true];
}

    public function resetPassword($request)
    {
        $pin_code = rand(111111, 999999);
        $model = $this->model->where('email', $request->email)->first();
        if(!$model){
        return ['status' => false, 'errors' => ['error' => [trans('auth.admin.failed')]]];
        }
        $model->update(['pin_code' => $pin_code]);
        $model->refresh();
        // dispatch(new SendMail($model->email, $model->pin_code));
        Mail::to($model->email)->send(new PinCodeMail($model->pin_code));
        return ["status" => true];
    }

    public function pinCodeConfirmation($request)
    {
        $model = $this->model->where([
            'email' => $request->email,
        ])->first();
        if(!$model){
            return ['status' => false, 'errors' => ['error' => [trans('auth.admin.failed')]]];
        }
        $model = $this->model->where([
            'pin_code' => $request->pin_code,
        ])->first();
        if(!$model){
            return ['status' => false, 'errors' => ['error' => [trans('auth.invalid', ['attribute'=>'pin_code'])]]];
        }
        $updatedAt = $model->updated_at;
        $now = now();
        $timeDifferenceInMinutes = $now->diffInMinutes($updatedAt);
        if($timeDifferenceInMinutes >= 5){
            return ['status' => false, 'errors' => ['error' => [trans('auth.invalid', ['attribute'=>'pin_code'])]]];
        }
            $model->update([
                'pin_code' => null,
                'token' => \Illuminate\Support\Str::random(60),
            ]);
        return ['status' => true, 'data'=>$model];
    }

    public function confirmPassword($request)
    {
            $model = $this->model->where('token', $request->token)->where('token', '!=', null)->first();
            if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('auth.invalid', ['attribute'=>'token'])]]];
            }
                $model->update(['token' => null, 'password' => $request->password]);
        return ['status' => true];
            }
}
