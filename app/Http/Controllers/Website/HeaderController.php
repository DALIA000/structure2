<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Header\HeaderInterface;
use App\Http\Resources\Website\HeaderListResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class HeaderController extends Controller
{
    public function __construct(private HeaderInterface $headerI, private ResponseService $responseService)
    {
        $this->headerI = $headerI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->headerI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = HeaderListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }
}
