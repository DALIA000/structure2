<?php

namespace App\Http\Repositories\Header;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Header;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HeaderRepository extends BaseRepository implements HeaderInterface
{
    public function __construct(Header $model, public Media $media)
    {
        $this->model = $model;
        $this->media = $media;
    }
    public function models($request)
    {
        $models = $this->model;
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
        $model = $this->model->create();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.create')]]];
        }
        $this->media->where('id', $request->image)
            ->update([
                'model_id' => $model->id,
                'model_type' => get_class($this->model),
                'collection_name' => 'images'
            ]);
        return ['status' => true, 'data' => $model];
    }

    public function edit($request, $id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Header'])]]];
        }
        if ($request->has('image') && $model->getMedia('images')->first()?->id != $request->image) {
            $model->clearMediaCollection('images');
            $this->media->where('id', $request->image)
                ->update([
                    'model_id' => $model->id,
                    'model_type' => get_class($this->model),
                    'collection_name' => 'images'
                ]);
        }
        return ['status' => true];
    }
}
