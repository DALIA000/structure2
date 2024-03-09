<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\FAQ\FAQInterface;
use App\Http\Resources\Website\FAQListResource;
use App\Http\Resources\Website\FAQResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function __construct(private FAQInterface $faqI, private ResponseService $responseService)
    {
        $this->faqI = $faqI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->faqI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = FAQListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }
}
