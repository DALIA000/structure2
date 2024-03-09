<?php

namespace App\Http\Repositories\Amenities;
use App\Http\Repositories\Base\BaseRepository;
use App\Models\Amenities;
use App\Models\Product;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AmenitiesRepository extends BaseRepository implements AmenitiesInterface{

    public function __construct(Amenities $model, public  Media $media){
        $this->model = $model;
        $this->media = $media;
    }
    public function models($request)
    {
    $models = $this->model->where(function ($query) use ($request) {
    if ($request->has('search')) {
    $searchTerm = '%' . $request->search . '%';
    $query->where(function ($query) use ($request, $searchTerm) {
        $query->Where('name->ar', 'like', $searchTerm)
            ->orWhere('name->en', 'like', $searchTerm)
            ->orWhere('name->ru', 'like', $searchTerm)
            ->orWhere('slug', 'like', $searchTerm);
    });}
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

    public function create($request){
        $slug = $this->generateSlug($this->model, $request->locales['en']['name']);
        $model = $this->model->create([
            'name' => [
                'ar' => $request->locales['ar']['name'],
                'en' => $request->locales['en']['name'],
                'ru' => $request->locales['ru']['name'],
            ],
            'slug' => $slug,
        ]);
        if(!$model){
            return ['status' => false, 'errors' => ['error' => [trans('crud.create')]]];
        }
        $this->media->where('id', $request->icon)
            ->update([
                'model_id' => $model->id,
                'model_type' => get_class($this->model),
                'collection_name' => 'icons'
            ]);
        return ['status' => true, 'data' => $model];
    }
    public function edit($request, $id){
        $model = $this->findById($id);
    if(!$model){
        return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Amenities'])]]];
        }
        foreach (['en', 'ar', 'ru'] as $locale) {
        if (isset($request->locales[$locale]['name'])) {
        $jsonData = is_array($model->name) ? $model->name : json_decode($model->name, true);
        $jsonData[$locale] = $request->locales[$locale]['name'];
        $model->update(["name" => $jsonData]);
        $model->fresh();
        }}
        if (isset($request->locales['en']['name'])) {
        $slug = $this->generateSlug($this->model, $request->locales['en']['name']);
        $model->update(["slug" => $slug]);
        }

        if ($request->has('icon') && $model->getMedia('icons')->first()?->id != $request->icon) {
        $model->clearMediaCollection('icons');
        $this->media->where('id', $request->icon)
            ->update([
                'model_id' => $model->id,
                'model_type' => get_class($this->model),
                'collection_name' => 'icons'
            ]);
    }
        return ['status' => true];
    }
    public function delete($id){
    $model = $this->model::find($id);
        if(!$model){
        return ['status' => false, 'errors' => ['error' => [trans('crud.notfound')]]];
        }
    if (Product::whereJsonContains('amenities', $id)->exists()) {
        return ['status' => false, 'errors' => ['error' => [trans('messages.not_empty', ['attribute' => 'amenities'])]]];
    }
        $model->delete();
        return ['status' => true];
    }
}
