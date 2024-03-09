<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Repositories\AdminAuth\AdminAuthInterface;
use App\Http\Requests\AdminConfirmPasswordRequest;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminResetPasswordRequest;
use App\Http\Requests\ConfirmTokenRequest;
use App\Http\Requests\UpdateAdminProfileRequest;
use App\Http\Resources\Dashboard\AdminProfileResource;
use App\Http\Resources\Dashboard\AdminResource;
use Illuminate\Routing\Controller;
use App\Services\ResponseService;

class AdminAuthController extends Controller
{
    public function __construct(private AdminAuthInterface $modelInterface, public ResponseService $ResponseService)
    {
        $this->modelInterface = $modelInterface;
    }
    public function login(AdminLoginRequest $request)
    {
        $auth = $this->modelInterface->login($request);
        if (!$auth) {
            return $this->ResponseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$auth['status']) {
            return $this->ResponseService->json('Fail!', [], 400, $auth['errors']);
        }
        $token = $auth['data']->createToken('admin')->accessToken;
        $admin = new AdminResource ($auth['data'], $token);
        return $this->ResponseService->Json("success", ['token' => $token, 'admin' => $admin], 200);
    }

    public function logout()
    {
        if(!auth('admin')->user()){
            return ['status' => false, 'errors' => ['error' => [trans('auth.forbidden')]]];
        }
        auth('admin')->user()->token()->revoke();
        return $this->ResponseService->Json("success", [], 200);
    }

    public function update(UpdateAdminProfileRequest $request)
    {
        $auth =  $this->modelInterface->update($request);
        if (!$auth) {
            return $this->ResponseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$auth['status']) {
            return $this->ResponseService->json('Fail!', [], 400, $auth['errors']);
        }
        return $this->ResponseService->Json("success",[], 200);
    }

    public function profile()
    {
        if(!auth('admin')->user()){
            return ['status' => false, 'errors' => ['error' => [trans('auth.forbidden')]]];
        }
        $admin = new AdminProfileResource( auth('admin')->user());
        return $this->ResponseService->Json("success", $admin, 200);
    }

    public function resetPassword(AdminResetPasswordRequest $request)
    {
        $auth = $this->modelInterface->resetPassword($request);
        if (!$auth) {
            return $this->ResponseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$auth['status']) {
            return $this->ResponseService->json('Fail!', [], 400, $auth['errors']);
        }
        return $this->ResponseService->Json("success", [], 200);
    }

    public function confirmPinCode(ConfirmTokenRequest $request)
    {
        $auth = $this->modelInterface->pinCodeConfirmation($request);
        if (!$auth) {
            return $this->ResponseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$auth['status']) {
            return $this->ResponseService->json('Fail!', [], 400, $auth['errors']);
        }
        return $this->ResponseService->Json("success", $auth['data']->token, 200);
    }

    public function confirmPassword(AdminConfirmPasswordRequest $request)
    {
        $auth = $this->modelInterface->confirmPassword($request);
        if (!$auth) {
            return $this->ResponseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$auth['status']) {
            return $this->ResponseService->json('Fail!', [], 400, $auth['errors']);
        }
        return $this->ResponseService->Json("success", [], 200);
    }
}
