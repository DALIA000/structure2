<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ListForm\ListFormInterface;
use App\Http\Requests\ListFormRequest;
use App\Services\ResponseService;

class ListFormController extends Controller
{
    public function __construct(private ListFormInterface $listFormI, private ResponseService $responseService)
    {
        $this->listFormI = $listFormI;
    }

    public function create(ListFormRequest $request)
    {
        $data = $this->listFormI->create($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}
