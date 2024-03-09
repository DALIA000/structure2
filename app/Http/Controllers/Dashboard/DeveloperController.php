<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Developer\DeveloperInterface;
use App\Http\Requests\CreateDeveloperRequest;
use App\Http\Requests\UpdateDeveloperRequest;
use App\Http\Resources\Dashboard\DeveloperListResource;
use App\Http\Resources\Dashboard\DeveloperResource;
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

    public function find(Request $request, $id)
    {
        $data = $this->developerI->findById($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new DeveloperResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function create(CreateDeveloperRequest $request)
    {
        $data = $this->developerI->create($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

    public function update(UpdateDeveloperRequest $request, $id)
    {
        $data = $this->developerI->edit($request, $id);
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
        $data = $this->developerI->delete($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}

