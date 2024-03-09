<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Type\TypeInterface;
use App\Http\Resources\Website\TypeListResource;
use App\Http\Resources\Website\TypeResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function __construct(private TypeInterface $amenitiesI, private ResponseService $responseService)
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
        $data = TypeListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $slug)
    {
        $data = $this->amenitiesI->findBySlug($slug);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new TypeResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }
}
