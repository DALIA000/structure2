<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Community\CommunityInterface;
use App\Http\Resources\Website\CommunityListResource;
use App\Http\Resources\Website\CommunityResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function __construct(private CommunityInterface $communityI, private ResponseService $responseService)
    {
        $this->communityI = $communityI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->communityI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = CommunityListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $slug)
    {
        $data = $this->communityI->findBySlug($slug);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new CommunityResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }

}
