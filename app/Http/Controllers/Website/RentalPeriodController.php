<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RentalPeriod\RentalPeriodInterface;
use App\Http\Resources\Website\RentalPeriodResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class RentalPeriodController extends Controller
{
    public function __construct(private RentalPeriodInterface $periodI, private ResponseService $responseService)
    {
        $this->periodI = $periodI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->periodI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = RentalPeriodResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $id)
    {
        $data = $this->periodI->findById($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new RentalPeriodResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }
}
