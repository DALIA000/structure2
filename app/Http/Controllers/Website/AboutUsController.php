<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\AboutUs\AboutUsInterface;
use App\Http\Resources\Website\AboutUsResource;
use App\Http\Resources\Website\BenefitsResource;
use App\Http\Resources\Website\WhyUsResource;
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
}
