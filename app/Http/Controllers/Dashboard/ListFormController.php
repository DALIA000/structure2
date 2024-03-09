<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ListForm\ListFormInterface;
use App\Http\Resources\Dashboard\AddListFormResource;
use App\Http\Resources\Dashboard\AddListFormSingleResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;


class ListFormController extends Controller
{
    public function __construct(private ListFormInterface $listFormI, private ResponseService $responseService)
    {
        $this->listFormI = $listFormI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->listFormI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = AddListFormResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $id)
    {
        $data = $this->listFormI->findById($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new AddListFormSingleResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function changeStatus($id)
    {
        $data = $this->listFormI->changeStatus($id);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function read($id)
    {
        $data = $this->listFormI->read($id);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function unread($id)
    {
        $data = $this->listFormI->unread($id);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function delete($id)
    {
        $data = $this->listFormI->delete($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}
