<?php

namespace App\Http\Repositories\Availability;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Availability;
use App\Http\Repositories\Availability\AvailabilityInterface;

class AvailabilityRepository extends BaseRepository implements AvailabilityInterface
{
    public function __construct(Availability $model)
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

    public function create($request)
    {
        $slug = $this->generateSlug($this->model, $request->locales['en']['name']);
        $model = $this->model->create([
            'slug' => $slug,
            'name' => [
                'ar' => $request->locales['ar']['name'],
                'en' => $request->locales['en']['name'],
                'ru' => $request->locales['ru']['name'],
            ],
        ]);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.create')]]];
        }
        return ['status' => true, 'data' => $model];
    }
}
