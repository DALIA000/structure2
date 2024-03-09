<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\AboutUs\AboutUsInterface;
use App\Http\Requests\UpdateAboutUsRequest;
use App\Http\Requests\UpdateBenefitsRequest;
use App\Http\Requests\UpdateWhyUsRequest;
use App\Http\Resources\Dashboard\AboutUsResource;
use App\Http\Resources\Dashboard\BenefitsResource;
use App\Http\Resources\Dashboard\WhyUsResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function __construct(private AboutUsInterface $aboutUsI, private ResponseService $responseService)
    {
        $this->aboutUsI = $aboutUsI;
    }

    public function about(Request $request)
    {
        $data = $this->aboutUsI->about($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new AboutUsResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }
    public function why(Request $request)
    {
        $data = $this->aboutUsI->why($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new WhyUsResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }
    public function benefits(Request $request)
    {
        $data = $this->aboutUsI->benefits($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new BenefitsResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function updateAboutUs(UpdateAboutUsRequest $request)
    {
        $data = $this->aboutUsI->edit($request, 1);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

    public function updateWhyUs(UpdateWhyUsRequest $request)
    {
        $data = $this->aboutUsI->edit($request, 2);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
    
    public function updateBenefits(UpdateBenefitsRequest $request)
    {
        $data = $this->aboutUsI->edit($request, 3);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}
