<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Statistics\StatisticsInterface;
use App\Http\Resources\Website\CardResource;
use App\Http\Resources\Website\TableDataResource;
use App\Http\Resources\Website\TableHeaderResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function __construct(private StatisticsInterface $statisticsI, private ResponseService $responseService)
    {
        $this->statisticsI = $statisticsI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->statisticsI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = TableDataResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function header(Request $request)
    {
        $data = $this->statisticsI->header($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new TableHeaderResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function cards(Request $request)
    {
        $data = $this->statisticsI->cards($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = CardResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function card(Request $request, $id)
    {
        $data = $this->statisticsI->card($request, $id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new CardResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

}

