<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Setting\SettingInterface;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Resources\Dashboard\BrochureResource;
use App\Http\Resources\Dashboard\CurrencyResource;
use App\Http\Resources\Dashboard\SocialResource;
use App\Http\Resources\Website\AboutImageResource;
use App\Http\Resources\Dashboard\TermsResource;
use App\Http\Resources\StatisticsTitleResource;
use App\Http\Resources\TableTitleResource;
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
        $data = new SocialResource($data['data'], $data1['data'], $data2['data'], $data3['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function update_contacts(UpdateSettingRequest $request)
    {
        $data = $this->settingI->edit_contacts($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
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

    public function update_terms(UpdateSettingRequest $request)
    {
        $data = $this->settingI->edit_terms($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
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

    public function update_privacy(UpdateSettingRequest $request)
    {
        $data = $this->settingI->edit_privacy($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
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

    public function update_currency(UpdateSettingRequest $request)
    {
        $data = $this->settingI->edit_currency($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
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

    public function update_about(UpdateSettingRequest $request)
    {
        $data = $this->settingI->edit_about($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
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
        $data = new BrochureResource($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function update_brochure(UpdateSettingRequest $request)
    {
        $data = $this->settingI->edit_brochure($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
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

    public function update_statistics_title(UpdateSettingRequest $request)
    {
        $data = $this->settingI->edit_statistics_title($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
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

    public function update_table_title(UpdateSettingRequest $request)
    {
        $data = $this->settingI->edit_table_title($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}
