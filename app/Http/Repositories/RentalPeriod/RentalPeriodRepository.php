<?php

namespace App\Http\Repositories\RentalPeriod;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\RentalPeriod;
use App\Models\Type;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RentalPeriodRepository extends BaseRepository implements RentalPeriodInterface
{
    public function __construct(RentalPeriod $model)
    {
        $this->model = $model;
    }
    public function models($request)
    {
        $models = $this->model->where(function ($query) use ($request) {
            if ($request->has('search')) {
                $searchTerm = '%' . $request->search . '%';
                $query->where(function ($query) use ($request, $searchTerm) {
                    $query->Where('period', 'like', $searchTerm);
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
        $model = $this->model->create([
            'period' => [
                'ar' => $request->locales['ar']['period'],
                'en' => $request->locales['en']['period'],
                'ru' => $request->locales['ru']['period'],
            ],
        ]);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.create')]]];
        }
        return ['status' => true, 'data' => $model];
    }

    public function delete($id){
    $model = $this->model::find($id);
        if(!$model){
        return ['status' => false, 'errors' => ['error' => [trans('crud.notfound')]]];
        }
    if (!$model->products->isEmpty()) {
        return ['status' => false, 'errors' => ['error' => [trans('messages.not_empty', ['attribute' => 'period'])]]];
        }
        $model->delete();
        return ['status' => true];
    }
}
