<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Agent\AgentInterface;
use App\Http\Resources\Website\AgentListResource;
use App\Http\Resources\Website\AgentResource;
use App\Models\Click;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function __construct(private AgentInterface $agentI, private ResponseService $responseService)
    {
        $this->agentI = $agentI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->agentI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = AgentListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $slug)
    {
        $data = $this->agentI->findBySlug($slug);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new AgentResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function addClick($slug)
    {
        $data = $this->agentI->addClick($slug);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function addWhatsappClick()
    {
        Click::create();
        $data = ['status' => true];
        return $this->responseService->json('Success!', $data, 200);
    }

}
