<?php

namespace App\Http\Repositories\Slider;
use App\Http\Repositories\Base\BaseRepository;
use App\Models\Slider;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SliderRepository extends BaseRepository implements SliderInterface{

    public function __construct(Slider $model, public  Media $media){
        $this->model = $model;
        $this->media = $media;
    }
    public function model($request)
    {
    $models = $this->model;
    if ($request->exists('trashed') && $request->trashed !== null) {
            $models->onlyTrashed();
        }
        $models->with($request->with ?: [])
        ->withCount($request->withCount ?: []);
        [$sort, $order] = $this->setSortParams($request);
        $models->orderBy($sort, $order);
        $models = $request->per_page ? $models->paginate($request->per_page) : $models->first();
        return ['status' => true, 'data' => $models];
    }

    public function edit($request){
        $model = $this->model->first();
        if(!$model){
        return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Slider'])]]];
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
            if (isset($request->locales[$locale]['filter_title'])) {
                $jsonData = is_array($model->filter_title) ? $model->filter_title : json_decode($model->filter_title, true);
                $jsonData[$locale] = $request->locales[$locale]['filter_title'];
                $model->update(["filter_title" => $jsonData]);
                $model->fresh();
            }}
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
