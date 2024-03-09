<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\AdminListResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Http\Repositories\Admin\AdminInterface;
use App\Http\Resources\Dashboard\AdminResource;
use App\Http\Resources\Dashboard\AdminsListResource;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\EditAdminRequest;
use App\Http\Resources\Dashboard\AdminProfileResource;

class AdminController extends Controller
{
    public function __construct(private AdminInterface $AdminI, private ResponseService $responseService)
    {
    }

    public function admins(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }

        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }

        $admins = $this->AdminI->models($request);

        if (!$admins) {
            return $this->responseService->json('Fail!', [], 400);
        }

        if (!$admins['status']) {
            return $this->responseService->json('Fail!', [], 400, $admins['errors']);
        }

        $admins = $admins['data'];
        $data = AdminListResource::collection($admins);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function admin(Request $request)
    {
        $admin = $this->AdminI->findByIdWith($request);
        if (!$admin) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new AdminListResource($admin);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function create(CreateAdminRequest $request)
    {

        $admin = $this->AdminI->create($request);
        if (!$admin) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }

        if (!$admin['status']) {
            return $this->responseService->json('Fail!', [], 400, $admin['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }

    public function update(EditAdminRequest $request, $id)
    {
        $admin = $this->AdminI->edit($request, $id);
        if (!$admin) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }

        if (!$admin['status']) {
            return $this->responseService->json('Fail!', [], 400, $admin['errors']);
        }

        return $this->responseService->json('Success!', [], 200);
    }

    public function delete(Request $request, $id)
    {
        $deleted = $this->AdminI->delete($id);
        if (!$deleted) {
            return $this->responseService->json('fall!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$deleted['status']) {
            return $this->responseService->json('fall!', [], 400, $deleted['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}
