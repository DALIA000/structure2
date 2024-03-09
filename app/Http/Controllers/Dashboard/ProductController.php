<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Product\ProductInterface;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\CreateStatisticsRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Dashboard\ProductListResource;
use App\Http\Resources\Dashboard\ProductResource;
use App\Http\Resources\ProductFormResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductInterface $productI, private ResponseService $responseService)
    {
        $this->productI = $productI;
    }

    public function models(Request $request)
    {
        $data = $this->productI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = ProductListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $id)
    {
        $data = $this->productI->findById($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new ProductResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function create(CreateProductRequest $request)
    {
        $data = $this->productI->create($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $data = $this->productI->edit($request, $id);
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
        $data = $this->productI->delete($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
    public function forms (Request $request)
    {
        $data = $this->productI->getForm($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = ProductFormResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function form(Request $request, $id)
    {
        $data = $this->productI->findForm($request, $id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new ProductFormResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function read(Request $request, $id)
    {
        $data = $this->productI->read($request, $id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!',[], 200);
    }

    public function unread(Request $request, $id)
    {
        $data = $this->productI->unread($request, $id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

    public function deleteform(Request $request, $id)
    {
        $data = $this->productI->delete($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}
