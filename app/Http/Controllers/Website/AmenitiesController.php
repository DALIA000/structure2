<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Amenities\AmenitiesInterface;
use App\Http\Resources\Website\AmenitiesListResource;
use App\Http\Resources\Website\AmenitiesResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class AmenitiesController extends Controller
{
    public function __construct(private AmenitiesInterface $amenitiesI, private ResponseService $responseService)
    {
        $this->amenitiesI = $amenitiesI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->amenitiesI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = AmenitiesListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $id)
    {
        $data = $this->amenitiesI->findById($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new AmenitiesResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }
}
