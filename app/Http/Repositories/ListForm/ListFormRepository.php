<?php

namespace App\Http\Repositories\ListForm;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\ListForm;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class ListFormRepository extends BaseRepository implements ListFormInterface
{
    public $media;
    public function __construct(ListForm $model, Media $media)
    {
        $this->model = $model;
        $this->media = $media;
    }
    public function models($request)
    {
        $models = $this->model->where(function ($query) use ($request) {
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
        $model = $this->model->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'message' => $request->message,
            'language' => $request->language,
            'availability_id' => $request->availability_id,
            'type_id' => $request->type_id,
        ]);
        if (isset($request->images)) {
            $this->media
                ->whereIn('id', $request->images)
                ->update([
                    'model_id' => $model->id,
                    'model_type' => get_class($model),
                ]);
        }
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
