<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Blog\BlogInterface;
use App\Http\Resources\Website\BlogListResource;
use App\Http\Resources\Website\BlogResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(private BlogInterface $blogI, private ResponseService $responseService)
    {
        $this->blogI = $blogI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->blogI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = BlogListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $slug)
    {
        $data = $this->blogI->findBySlug($slug);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $view = $this->blogI->addView($slug);
        if (!$view) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new BlogResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }
    // public function addView($slug)
    // {
    //     $data = $this->blogI->addView($slug);
    //     return $this->responseService->json('Success!', $data, 200);
    // }

    public function like($slug)
    {
        $data = $this->blogI->like($slug);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function unlike($slug)
    {
        $data = $this->blogI->unlike($slug);
        return $this->responseService->json('Success!', $data, 200);
    }

}
