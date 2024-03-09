<?php

namespace App\Http\Repositories\FormImage;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\FormImage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FormImageRepository extends BaseRepository implements FormImageInterface
{

    public function __construct(FormImage $model, public Media $media)
    {
        $this->model = $model;
        $this->media = $media;
    }
    public function expert($request)
    {
        $data = $this->model->findOrFail(1);
        return ['status' => true, 'data' => $data];
    }

    public function updateExpert($request)
    {
        $model = $this->model->findOrFail(1);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'FormImage'])]]];
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

    public function list($request)
    {
        $data = $this->model->findOrFail(2);
        return ['status' => true, 'data' => $data];
    }

    public function updateList($request)
    {
        $model = $this->model->findOrFail(2);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'FormImage'])]]];
        }
        if ($request->has('images')) {
            $newImageIds = $this->UpdateImage($request, $model);
            if ($newImageIds) {
                foreach ($newImageIds as $imageId) {
                    Media::where('id', $imageId)
                        ->update([
                            'model_type' => FormImage::class,
                            'model_id' => $model->id,
                        ]);
                }
            }
        }
        return ['status' => true];
    }
}
