<?php

namespace App\Http\Repositories\Role;

use App\Http\Repositories\Role\RoleInterface;
use App\Http\Repositories\Base\BaseRepository;
use App\Models\Permission;
use App\Models\Role;
use DB;

class RoleRepository extends BaseRepository implements RoleInterface
{
    public $loggedinUser;

    public function __construct(Role $model)
    {
        $this->model = $model;
        $this->loggedinUser = \Auth::user();
    }

    public function models($request)
    {
        $roles = $this->model->where(function ($query) use ($request) {
            if ($request->exists('name') && $request->search !== null) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
        });

        $roles = $this->getWith($roles, $request->with ?: []);

        [$sort, $order] = $this->setSortParams($request);
        $roles->orderBy($sort, $order);

        $roles = $request->per_page ? $roles->paginate($request->per_page) : $roles->get();

        return ['status' => true, 'data' => $roles];
    }

    public function create($request)
    {
        $model = DB::transaction(function () use ($request) {
            $title = [
                "en" => $request->title,
            ];

            $model = $this->model->create([
                'name' => $request->title,
                'title' => $title,
                'guard_name' => 'admin',
            ]);
            if ($request->has('permissions')) {
                $permissions = $request->permissions;
                foreach ($permissions as $permissionId) {
                    $permission = Permission::find($permissionId);
                    if ($permission) {
                        $permission_slug = $permission->name;
                        $parts = explode('.', $permission_slug);
                        if (count($parts) >= 2) {
                            $firstPart = $parts[0];
                            $secondPart = $parts[1];
                            if (strpos($secondPart, "create") !== false || strpos($secondPart, "edit") !== false || strpos($secondPart, "delete") !== false || strpos($secondPart, "read") !== false || strpos($secondPart, "un_read") !== false) {
                                $adminsViewPermission = Permission::where('name', $firstPart)->first();
                                if ($adminsViewPermission) {
                                    $model->givePermissionTo($adminsViewPermission);
                                }
                            }
                        }
                        $model->givePermissionTo($permission);
                    }
                }
            }
        });
        return ['status' => true, 'data' => $model];
    }


    public function edit($request, $id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound')]]];
        }
        if (isset($request->title)) {
            $model->update([
                'title' => [
                    "en" => $request->title,
                ],
            ]);
        }
        if ($request->exists('permissions')) {
            foreach ($request->permissions as $permission) {
                $name = Permission::find($permission)->name;
                $model->syncPermissions($name);
            }
            $permissions = $request->permissions;
            foreach ($permissions as $permissionId) {
                $permission = Permission::find($permissionId);
                if ($permission) {
                    $permission_slug = $permission->name;
                    $parts = explode('.', $permission_slug);
                    if (count($parts) >= 2) {
                        $firstPart = $parts[0];
                        $secondPart = $parts[1];
                        if (strpos($secondPart, "create") !== false || strpos($secondPart, "edit") !== false || strpos($secondPart, "delete") !== false || strpos($secondPart, "read") !== false || strpos($secondPart, "un_read") !== false) {
                            $adminsViewPermission = Permission::where('name', $firstPart)->first();
                            if ($adminsViewPermission) {
                                $model->givePermissionTo($adminsViewPermission);
                            }
                        }
                    }
                    $model->givePermissionTo($permission);
                }
            }
        }
        $model->save();
        return ['status' => true, 'data' => $model];
    }

    public function delete($id)
    {
        $model = $this->model::find($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound')]]];
        }
        if (!$model->users->isEmpty()) {
            return ['status' => false, 'errors' => ['error' => [trans('messages.not_empty')]]];
        }
        $model->delete();
        return ['status' => true];
    }
}
