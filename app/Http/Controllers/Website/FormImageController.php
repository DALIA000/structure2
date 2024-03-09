<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\FormImage\FormImageInterface;
use App\Http\Resources\ListFormImagesResource;
use App\Http\Resources\Website\ExpertImageResource;
use App\Http\Resources\Website\FormImageResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class FormImageController extends Controller
{
    public function __construct(private FormImageInterface $FormImageI, private ResponseService $responseService)
    {
        $this->FormImageI = $FormImageI;
    }

    public function expert(Request $request)
    {
        $data = $this->FormImageI->expert($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new ExpertImageResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function list(Request $request)
    {
        $data = $this->FormImageI->list($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new ListFormImagesResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }
}
