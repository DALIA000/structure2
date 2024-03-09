<?php

namespace App\Http\Repositories\Category;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryInterface
{

    public function __construct(Category $model)
    {
        $this->model = $model;
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

    public function edit($request, $id)
    {
        $model = $this->FindById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Category'])]]];
        }
        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['name'])) {
                $jsonData = is_array($model->name) ? $model->name : json_decode($model->name, true);
                $jsonData[$locale] = $request->locales[$locale]['name'];
                $model->update(["name" => $jsonData]);
                $model->fresh();
            }
        }
        // if (isset($request->locales['en']['name'])) {
        //     $slug = $this->generateSlug($this->model, $request->locales['en']['name']);
        //     $model->update(["slug" => $slug]);
        // }
        // if (isset($request->date)) {
        //     $model->update(["date" => $request->date]);
        // }
        return ['status' => true];
    }
}
