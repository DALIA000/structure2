<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Agent\AgentInterface;
use App\Http\Requests\CreateAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Http\Resources\Dashboard\AgentListResource;
use App\Http\Resources\Dashboard\AgentResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class AgentController extends Controller{
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

    public function find(Request $request, $id)
    {
        $data = $this->agentI->findById($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new AgentResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function create(CreateAgentRequest $request)
    {
        $data = $this->agentI->create($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }

        return $this->responseService->json('Success!', [], 200);
    }

    public function update(UpdateAgentRequest $request, $id)
    {
        $data = $this->agentI->edit($request, $id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

    public function delete($id)
    {
        $data = $this->agentI->delete($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}

