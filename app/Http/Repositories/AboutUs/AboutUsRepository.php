<?php

namespace App\Http\Repositories\AboutUs;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\AboutUs;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AboutUsRepository extends BaseRepository implements AboutUsInterface
{
    public function __construct(AboutUs $model, public Media $media)
    {
        $this->model = $model;
        $this->media = $media;
    }
    public function about($request)
    {
        $data = $this->model->where('type', 'about')->first();
        return ['status' => true, 'data' => $data];
    }
    public function why($request)
    {
        $data = $this->model->where('type', 'why')->first();
        return ['status' => true, 'data' => $data];
    }
    public function benefits($request)
    {
        $data = $this->model->where('type', 'benefits')->first();
        return ['status' => true, 'data' => $data];
    }

    public function edit($request, $id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'AboutUs'])]]];
        }
        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['title'])) {
                $jsonData = is_array($model->title) ? $model->title : json_decode($model->title, true);
                $jsonData[$locale] = $request->locales[$locale]['title'];
                $model->update(["title" => $jsonData]);
                $model->fresh();
            }

            if (isset($request->locales[$locale]['description'])) {
                $jsonData = is_array($model->description) ? $model->description : json_decode($model->description, true);
                $jsonData[$locale] = $request->locales[$locale]['description'];
                $model->update(["description" => $jsonData]);
                $model->fresh();
            }
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
        if ($request->has('images')) {
            $newImageIds = $this->UpdateImage($request, $model);
            if ($newImageIds) {
                foreach ($newImageIds as $imageId) {
                    Media::where('id', $imageId)
                        ->update([
                            'model_type' => AboutUs::class,
                            'model_id' => $id,
                        ]);
                }
            }
        }
        return ['status' => true];
    }
}
