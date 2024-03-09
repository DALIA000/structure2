<?php

namespace App\Http\Repositories\FAQ;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\FAQ;

class FAQRepository extends BaseRepository implements FAQInterface
{
    public function __construct(FAQ $model)
    {
        $this->model = $model;
        // $this->media = $media;
    }
    public function models($request)
    {
        $models = $this->model->where(function ($query) use ($request) {
            if ($request->has('search')) {
                $searchTerm = '%' . $request->search . '%';
                $query->where(function ($query) use ($request, $searchTerm) {
                    $query->Where('question->ar', 'like', $searchTerm)
                        ->orWhere('question->en', 'like', $searchTerm)
                        ->orWhere('question->ru', 'like', $searchTerm)
                        ->orWhere('answer->ar', 'like', $searchTerm)
                        ->orWhere('answer->en', 'like', $searchTerm)
                        ->orWhere('answer->ru', 'like', $searchTerm);
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
            'question' => [
                'en' => $request->locales['en']['question'],
                'ar' => $request->locales['ar']['question'],
                'ru' => $request->locales['ru']['question'],
            ],
            'answer' => [
                'en' => $request->locales['en']['answer'],
                'ar' => $request->locales['ar']['answer'],
                'ru' => $request->locales['ru']['answer'],
            ],
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
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }

        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['question'])) {
                $jsonData = is_array($model->question) ? $model->question : json_decode($model->question, true);
                $jsonData[$locale] = $request->locales[$locale]['question'];
                $model->update(["question" => $jsonData]);
                $model->fresh();
            }

            if (isset($request->locales[$locale]['answer'])) {
                $jsonData = is_array($model->answer) ? $model->answer : json_decode($model->answer, true);
                $jsonData[$locale] = $request->locales[$locale]['answer'];
                $model->update(["answer" => $jsonData]);
                $model->fresh();
            }
        }
        return ['status' => true];
    }
}
