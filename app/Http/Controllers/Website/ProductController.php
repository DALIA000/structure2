<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Product\ProductInterface;
use App\Http\Requests\ProductFormRequest;
use App\Http\Resources\Website\ProductListResource;
use App\Http\Resources\Website\ProductResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductInterface $developerI, private ResponseService $responseService)
    {
        $this->developerI = $developerI;
    }

    public function models(Request $request)
    {
        $data = $this->developerI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = ProductListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $slug)
    {
        $data = $this->developerI->findBySlug($slug);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new ProductResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function form(ProductFormRequest $request)
    {
        $data = $this->developerI->createForm($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}
