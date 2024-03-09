<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Permission\PermissionInterface;
use App\Http\Resources\Dashboard\PermissionResource;
use App\Http\Resources\Dashboard\PermissionsListResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Pluralizer;


class PermissionController extends Controller
{
    private $PermissionI;

    public function __construct(PermissionInterface $PermissionI, public ResponseService $responseService)
    {
        $this->PermissionI = $PermissionI;

    }
    public function permissions(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'asc']);
        }

        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'created_at']);
        }

        $permissions = $this->PermissionI->models($request);

        if (!$permissions) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }

        if (!$permissions['status']) {
            return $this->responseService->json('Fail!', [], 400, $permissions['errors']);
        }

        $permissions = $permissions['data'];

        // Group permissions by role
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        // Transform the grouped permissions
        $mappedPermissions = $groupedPermissions->map(function ($permissions, $role) {
            $pluralizedName = Pluralizer::plural($role);
            return [
                $role => [
                    'name' => $pluralizedName, // Adjust pluralization as needed
                    'permissions' => $permissions->map(function ($permission) {
                        return [
                            'id' => $permission->id,
                            'name' => $permission->name,
                        ];
                    }),
                ],
            ];
        });
        return $this->responseService->json('Success!', $mappedPermissions->values(), 200);
    }

    public function permission(Request $request)
    {
        $permission = $this->PermissionI->findById($request->id);
        if (!$permission) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        $data = new PermissionResource($permission);
        return $this->responseService->json('Success!', $data, 200);
    }
}
