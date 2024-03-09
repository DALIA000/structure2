<?php

namespace App\Http\Repositories\Form;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Form;
use App\Http\Repositories\Form\FormInterface;

class FormRepository extends BaseRepository implements FormInterface
{
    public function __construct(Form $model)
    {
        $this->model = $model;
    }
    public function models($request)
    {
        $models = $this->model->where(function ($query) use ($request) {
            if ($request->has('type')) {
                $query->where('type', $request->type);
            }
            if ($request->has('language')) {
                $query->where('language', $request->language);
            }
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
        });
        if ($request->exists('trashed') && $request->trashed !== null) {
            $models->onlyTrashed();
        }
        $models->with($request->with ?: [])
            ->withCount($request->withCount ?: []);
        [$sort, $order] = $this->setSortParams($request);
        $models->orderBy($sort, $order);
        $models = $request->per_page ? $models->paginate($request->per_page) : $models->get();
        return ['status' => true, 'data' => $models];
    }

    public function create($request)
    {
        $data = $request->all();
        $model = $this->model->create($data);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.create')]]];
        }
        return ['status' => true, 'data' => $model];
    }

    public function changeStatus($id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }
        if ($model->status == 'unread') {
            $model->update([
                'status' => 'read'
            ]);
            $model->save();
        } else {
            $model->update([
                'status' => 'unread'
            ]);
            $model->save();
        }
        return ['status' => true];
    }

    public function read($id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }
        if ($model->status == 'unread') {
            $model->update([
                'status' => 'read'
            ]);
            $model->save();
        } else {
            return ['status' => false];
        }
        return ['status' => true];
    }

    public function unread($id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }
        if ($model->status == 'read') {
            $model->update([
                'status' => 'unread'
            ]);
            $model->save();
        } else {
            return ['status' => false];
        }
        return ['status' => true];
    }
}
