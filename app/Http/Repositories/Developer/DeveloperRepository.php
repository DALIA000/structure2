<?php

namespace App\Http\Repositories\Developer;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Developer;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DeveloperRepository extends BaseRepository implements DeveloperInterface
{

    public function __construct(Developer $model, public Media $media)
    {
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
                        ->orWhere('position', 'like', $searchTerm);
                });
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
        $slug = $this->generateSlug($this->model, $request->locales['en']['name']);
        $model = $this->model->create([
            'slug' => $slug,
            'name' => [
                'en' => $request->locales['en']['name'],
                'ar' => $request->locales['ar']['name'],
                'ru' => $request->locales['ru']['name'],
            ],
            'description' => [
                'en' => $request->locales['en']['description'],
                'ar' => $request->locales['ar']['description'],
                'ru' => $request->locales['ru']['description'],
            ]
        ]);
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
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }
        if (isset($request->locales['en']['name'])) {
        $slug = $this->generateSlug($this->model, $request->locales['en']['name']);
        $model->update([
            "slug" => $slug
        ]);}
        foreach (['en', 'ar', 'ru'] as $locale) {
        if (isset($request->locales[$locale]['description'])) {
        $jsonData = is_array($model->description) ? $model->description : json_decode($model->description, true);
        $jsonData[$locale] = $request->locales[$locale]['description'];
        $model->update(["description" => $jsonData]);
        $model->fresh();
        }
        if (isset($request->locales[$locale]['name'])) {
        $jsonData = is_array($model->name) ? $model->name : json_decode($model->name, true);
        $jsonData[$locale] = $request->locales[$locale]['name'];
        $model->update(["name" => $jsonData]);
        $model->fresh();
        }}
        if ($request->has('image') && $model->getMedia('images')->first()?->id != $request->image) {
        $model->clearMediaCollection('images');
        $this->media->where('id', $request->image)
            ->update([
                'model_id' => $model->id,
                'model_type' => get_class($this->model),

            ]);
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

    public function delete($id){
    $model = $this->model::find($id);
        if(!$model){
        return ['status' => false, 'errors' => ['error' => [trans('crud.notfound')]]];
        }
    if (!$model->products->isEmpty()) {
        return ['status' => false, 'errors' => ['error' => [trans('messages.not_empty', ['attribute' => 'developer'])]]];
        }
        $model->delete();
        return ['status' => true];
    }
}
