<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Category\CategoryInterface;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Dashboard\CategoryListResource;
use App\Http\Resources\Dashboard\CategoryResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
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

    public function find(Request $request, $id)
    {
        $data = $this->categoryI->findById($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new CategoryResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $data = $this->categoryI->edit($request, $id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }

        return $this->responseService->json('Success!', [], 200);
    }
}
