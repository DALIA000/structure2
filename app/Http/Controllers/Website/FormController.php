<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Form\FormInterface;
use App\Http\Requests\BrochureFormRequest;
use App\Http\Requests\ContactFormRequest;
use App\Http\Requests\ExpertFormRequest;
use App\Http\Requests\InterestFormRequest;
use App\Http\Requests\ServiceFormRequest;
use App\Http\Resources\Dashboard\ContactListResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;
class FormController extends Controller
{
    public function __construct(private FormInterface $formI, private ResponseService $responseService)
    {
        $this->formI = $formI;
    }

    public function contact(ContactFormRequest $request)
    {
        $data = $this->formI->create($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

    public function interest(InterestFormRequest $request)
    {
        $data = $this->formI->create($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

    public function service(ServiceFormRequest $request)
    {
        $data = $this->formI->create($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

    public function expert(ExpertFormRequest $request)
    {
        $data = $this->formI->create($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
    public function brochure(BrochureFormRequest $request)
    {
        $data = $this->formI->create($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}
