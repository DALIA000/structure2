<?php

namespace App\Http\Repositories\Blog;

use App\Http\Repositories\Base\BaseRepository;
use App\Http\Repositories\Blog\BlogInterface;
use App\Models\Blog;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogRepository extends BaseRepository implements BlogInterface
{
    public $media;
    public function __construct(Blog $model, Media $media)
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
                    $query->Where('title->ar', 'like', $searchTerm)
                        ->orWhere('title->en', 'like', $searchTerm)
                        ->orWhere('title->ru', 'like', $searchTerm)
                        ->orWhere('description->ar', 'like', $searchTerm)
                        ->orWhere('description->en', 'like', $searchTerm)
                        ->orWhere('description->ru', 'like', $searchTerm);
                });
            }

            if ($request->exists('tags') && $request->tags !== null) {
                $tag = $request->tags;
                $query->where('hashtags', 'like', "%$tag%");
            }

        });
        if ($request->exists('trashed') && $request->trashed !== null) {
            $models->onlyTrashed();
        }
        $models->with($request->with ?: [])
            ->withCount($request->withCount ?: [])
            ->with('views');
            
        [$sort, $order] = $this->setSortParams($request);
        $models->orderBy($sort, $order);
        $models = $request->per_page ? $models->paginate($request->per_page) : $models->get();
        return ['status' => true, 'data' => $models];
    }

    public function create($request)
    {
        $slug = $this->generateSlug($this->model, $request->locales['en']['title']);
        $model = $this->model->create([
            'slug' => $slug,
            'title' => [
                'ar' => $request->locales['ar']['title'],
                'en' => $request->locales['en']['title'],
                'ru' => $request->locales['ru']['title'],
            ],
            'description' => [
                'ar' => $request->locales['ar']['description'],
                'en' => $request->locales['en']['description'],
                'ru' => $request->locales['ru']['description'],
            ],
            'hashtags' => $request->hashtags,
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
        if (isset($request->hashtags)) {
            $model->update([
                'hashtags' => $request->hashtags,
            ]);
        }
        if (isset($request->$request->locales['en']['title'])) {
            $slug = $this->generateSlug($this->model, $request->locales['en']['title']);
            $model->update([
                'slug' => $slug,
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

    public function addView($slug)
    {
        $model = $this->findBySlug($slug);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }
        $model->views()->create();
        return ['status' => true];
    }

    public function like($slug)
    {
        $model = $this->findBySlug($slug);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }
        $model->increment('likes');
        return ['status' => true];
    }

    public function unlike($slug)
    {
        $model = $this->findBySlug($slug);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }
        $model->increment('unlikes');
        return ['status' => true];
    }
}
