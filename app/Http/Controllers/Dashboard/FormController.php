<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Form\FormInterface;
use App\Http\Resources\Dashboard\BrochureListResource;
use App\Http\Resources\Dashboard\ContactListResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function __construct(private FormInterface $formI, private ResponseService $responseService)
    {
        $this->formI = $formI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->formI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        if ($request->has('type') && $request->type == 'brochure') {
            $data = BrochureListResource::collection($data['data']);
        } else {
            $data = ContactListResource::collection($data['data']);
        }
        return $this->responseService->json('Success!', $data, 200);
    }

    public function changeStatus($id)
    {
        $data = $this->formI->changeStatus($id);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function read($id)
    {
        $data = $this->formI->read($id);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function unread($id)
    {
        $data = $this->formI->unread($id);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function delete($id)
    {
        $data = $this->formI->delete($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

}
