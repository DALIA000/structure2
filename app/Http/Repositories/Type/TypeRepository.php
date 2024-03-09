<?php

namespace App\Http\Repositories\Type;
use App\Http\Repositories\Base\BaseRepository;
use App\Models\Type;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TypeRepository extends BaseRepository implements TypeInterface{
public $media;
    public function __construct(Type $model, Media $media){
        $this->model = $model;
        $this->media = $media;
    }
    public function models($request){
    $models = $this->model->where(function ($query) use ($request) {
    if ($request->has('search')) {
    $searchTerm = '%' . $request->search . '%';
    $query->where(function ($query) use ($request, $searchTerm) {
        $query->Where('name->ar', 'like', $searchTerm)
            ->orWhere('name->en', 'like', $searchTerm)
            ->orWhere('name->ru', 'like', $searchTerm)
            ->orWhere('slug', 'like', $searchTerm);
    });}});
        if ($request->exists('status') && $request->status !== null) {
            $models->where('status', $request->status );
        }
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
        return ['status' => true, 'data' => $model];
    }

    public function edit($request, $id){
        $model = $this->FindById($id);
        if(!$model){
        return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'type'])]]];
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
        if (isset($request->status)) {
        $model->update(["status" => $request->status]);
        }
        return ['status' => true];
    }

    public function delete($id){
    $model = $this->model::find($id);
        if(!$model){
        return ['status' => false, 'errors' => ['error' => [trans('crud.notfound')]]];
        }
    if (!$model->products->isEmpty()) {
        return ['status' => false, 'errors' => ['error' => [trans('messages.not_empty', ['attribute' => 'type'])]]];
        }
        $model->delete();
        return ['status' => true];
    }
}
