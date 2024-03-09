<?php

namespace App\Http\Repositories\AdminAuth;

interface AdminAuthInterface
{
    public function login($request);

    public function update($request);

    public function resetPassword($request);

    public function pinCodeConfirmation($request);

    public function confirmPassword($request);
}
