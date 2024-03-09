<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Availability\AvailabilityInterface;
use App\Http\Requests\CreateAvailabilityRequest;
use App\Http\Resources\Dashboard\AvailabilityListResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function __construct(private AvailabilityInterface $availabilityI, private ResponseService $responseService)
    {
        $this->availabilityI = $availabilityI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }

        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }

        $data = $this->availabilityI->models($request);

        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }

        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = AvailabilityListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $id)
    {
        $data = $this->availabilityI->findById($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new AvailabilityListResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function create(CreateAvailabilityRequest $request)
    {
        $data = $this->availabilityI->create($request);
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
        $data = $this->availabilityI->delete($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}
