<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Setting\SettingInterface;
use App\Http\Resources\ContactsResource;
use App\Http\Resources\Website\CurrencyResource;
use App\Http\Resources\Website\SocialResource;
use App\Http\Resources\Website\StatisticsTitleResource;
use App\Http\Resources\Website\TableTitleResource;
use App\Http\Resources\Website\TermsResource;
use App\Http\Resources\Website\AboutImageResource;
use App\Http\Resources\Website\brochureResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(private SettingInterface $settingI, private ResponseService $responseService)
    {
        $this->settingI = $settingI;
    }

    public function social(Request $request)
    {
        $data = $this->settingI->model($request, 'social');
        $data1 = $this->settingI->model($request, 'contacts');
        $data2 = $this->settingI->model($request, 'location');
        $data3 = $this->settingI->model($request, 'address');
        if (!$data||!$data1||!$data2||!$data3) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']||!$data1['status']||!$data2['status']||!$data3['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new ContactsResource($data['data'], $data1['data'], $data2['data'], $data3['data']);
        return $this->responseService->json('Success!', $data, 200);
    }


    public function terms(Request $request)
    {
        $data = $this->settingI->model($request, 'terms');
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new TermsResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function privacy(Request $request)
    {
        $data = $this->settingI->model($request, 'privacy');
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new TermsResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function currency(Request $request)
    {
        $data = $this->settingI->model($request, 'currency');
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new CurrencyResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function about(Request $request)
    {
        $data = $this->settingI->about($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new AboutImageResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function brochure(Request $request)
    {
        $data = $this->settingI->brochure($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new brochureResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function statistics_title(Request $request)
    {
        $data = $this->settingI->model($request, 'statistics_title');
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new StatisticsTitleResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function table_title(Request $request)
    {
        $data = $this->settingI->model($request, 'table_title');
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = new TableTitleResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }
}

