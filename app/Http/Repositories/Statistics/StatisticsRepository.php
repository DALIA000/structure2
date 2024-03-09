<?php

namespace App\Http\Repositories\Statistics;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Amenities;
use App\Models\Service;
use App\Models\Statistics_card;
use App\Models\Table_data;
use App\Models\Table_header;

class StatisticsRepository extends BaseRepository implements StatisticsInterface
{

    public function __construct(Table_data $model, public Table_header $header, public Statistics_card $card)
    {
        $this->model = $model;
        $this->header = $header;
        $this->card = $card;
    }
    public function models($request)
    {
        $models = $this->model;
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
            'type' => [
                'ar' => $request->locales['ar']['type'],
                'en' => $request->locales['en']['type'],
                'ru' => $request->locales['ru']['type'],
            ],
            'price' => $request->price,
            'percent' => $request->percent,
            'year' => $request->year,
        ]);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.create')]]];
        }
        return ['status' => true, 'data' => $model];
    }
    public function edit($request, $id)
    {
        $model = $this->findById($id);

        if (!$model) {
            return [
                'status' => false,
                'errors' => ['error' => [trans('crud.notfound', ['model' => 'statistics'])]]
            ];
        }

        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['type'])) {
                $jsonData = is_array($model->type) ? $model->type : json_decode($model->type, true);
                $jsonData[$locale] = $request->locales[$locale]['type'];
                $model->update(["type" => $jsonData]);
                $model->fresh();
            }
        }

        if (isset($request->price)) {
            $model->update(["price" => $request->price]);
        }

        if (isset($request->percent)) {
            $model->update(["percent" => $request->percent]);
        }

        if (isset($request->year)) {
            $model->update(["year" => $request->year]);
        }

        return ['status' => true];
    }


    public function find($request, $id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'statistics'])]]];
        }
        return ['status' => true, 'data' => $model];
    }

    public function header($request)
    {
        $models = $this->header->first();
        return ['status' => true, 'data' => $models];
    }
    public function header_edit($request)
    {
        $model = $this->header->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'statistics'])]]];
        }
        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['first'])) {
                $jsonData = is_array($model->first) ? $model->first : json_decode($model->first, true) ?? [];
                $jsonData[$locale] = $request->locales[$locale]['first'];
                $model->update(["first" => $jsonData]);
                $model->refresh();
            }
            if (isset($request->locales[$locale]['second'])) {
                $jsonData = is_array($model->second) ? $model->second : json_decode($model->second, true) ?? [];
                $jsonData[$locale] = $request->locales[$locale]['second'];
                $model->update(["second" => $jsonData]);
                $model->refresh();
            }
            if (isset($request->locales[$locale]['third'])) {
                $jsonData = is_array($model->third) ? $model->third : json_decode($model->third, true) ?? [];
                $jsonData[$locale] = $request->locales[$locale]['third'];
                $model->update(["third" => $jsonData]);
                $model->refresh();
            }
            if (isset($request->locales[$locale]['fourth'])) {
                $jsonData = is_array($model->fourth) ? $model->fourth : json_decode($model->fourth, true) ?? [];
                $jsonData[$locale] = $request->locales[$locale]['fourth'];
                $model->update(["fourth" => $jsonData]);
                $model->refresh();
            }
        }
        return ['status' => true, 'data' => $model];
    }

    public function cards($request)
    {
        $models = $this->card->all();
        return ['status' => true, 'data' => $models];
    }

    public function card($request, $id)
    {
        $model = $this->card->where('id', $id)->first();
        return ['status' => true, 'data' => $model];
    }

    public function card_edit($request, $id)
    {
        $model = $this->card->where('id', $id)->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'statistics'])]]];
        }
        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['description'])) {
                $jsonData = is_array($model->description) ? $model->description : json_decode($model->description, true);
                $jsonData[$locale] = $request->locales[$locale]['description'];
                $model->update(["description" => $jsonData]);
                $model->refresh();
            }
        }
        if (isset($request->number)) {
            $model->update(["number" => $request->number]);
        }
        if (isset($request->Percentage)) {
            $model->update(["Percentage" => $request->Percentage]);
        }
        return ['status' => true, 'data' => $model];
    }
}
