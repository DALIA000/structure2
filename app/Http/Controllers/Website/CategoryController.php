<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Category\CategoryInterface;
use App\Http\Resources\Website\CategoryListResource;
use App\Http\Resources\Website\CategoryResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class CategoryController extends Controller{
    public function __construct(private CategoryInterface $categoryI, private ResponseService $responseService)
    {
        $this->categoryI = $categoryI;
    }
    public function models(Request $request)
    {
        $data = $this->categoryI->models($request);

        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }

        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = CategoryListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $slug)
    {
        $data = $this->categoryI->findBySlug($slug);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new CategoryResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }
}
