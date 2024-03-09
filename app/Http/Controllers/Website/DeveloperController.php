<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Developer\DeveloperInterface;
use App\Http\Resources\Website\DeveloperListResource;
use App\Http\Resources\Website\DeveloperResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function __construct(private DeveloperInterface $developerI, private ResponseService $responseService)
    {
        $this->developerI = $developerI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->developerI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = DeveloperListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $slug)
    {
        $data = $this->developerI->findBySlug($slug);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new DeveloperResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }
}
