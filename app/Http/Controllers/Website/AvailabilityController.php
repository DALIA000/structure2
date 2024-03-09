<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Availability\AvailabilityInterface;
use App\Http\Resources\Website\AvailabilityListResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;


class AvailabilityController extends Controller
{
    public function __construct(private AvailabilityInterface $availabilityI, private ResponseService $responseService)
    {
        $this->availabilityI = $availabilityI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }

        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }

        $data = $this->availabilityI->models($request);

        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }

        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = AvailabilityListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }
}
