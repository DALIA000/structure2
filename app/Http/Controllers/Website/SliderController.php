<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Slider\SliderInterface;
use App\Http\Resources\Website\SliderResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct(private SliderInterface $sliderI, private ResponseService $responseService)
    {
        $this->sliderI = $sliderI;
    }
    public function model(Request $request)
    {
        $data = $this->sliderI->model($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new SliderResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }
}
