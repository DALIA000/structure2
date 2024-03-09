<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\FAQ\FAQInterface;
use App\Http\Requests\CreateFAQRequest;
use App\Http\Requests\UpdateFAQRequest;
use App\Http\Resources\Dashboard\FAQListResource;
use App\Http\Resources\Dashboard\FAQResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function __construct(private FAQInterface $faqI, private ResponseService $responseService)
    {
        $this->faqI = $faqI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->faqI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = FAQListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $id)
    {
        $data = $this->faqI->findById($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new FAQResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function create(CreateFAQRequest $request)
    {
        $data = $this->faqI->create($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

    public function update(UpdateFAQRequest $request, $id)
    {
        $data = $this->faqI->edit($request, $id);
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
        $data = $this->faqI->delete($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

}
