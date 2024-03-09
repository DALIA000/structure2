<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Service\ServiceInterface;
use App\Http\Resources\Website\ServiceResource;
use App\Http\Resources\Website\ServiceListResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(private ServiceInterface $serviceI, private ResponseService $responseService)
    {
        $this->serviceI = $serviceI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->serviceI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = ServiceListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $slug)
    {
        $data = $this->serviceI->findBySlug($slug);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new ServiceResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }
}
