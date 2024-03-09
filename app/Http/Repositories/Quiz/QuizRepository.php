<?php

namespace App\Http\Repositories\Quiz;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Quiz;
use App\Models\QuizQA;

class QuizRepository extends BaseRepository implements QuizInterface
{
    public $qaModel;
    public function __construct(Quiz $model, QuizQA $qaModel)
    {
        $this->model = $model;
        $this->qaModel = $qaModel;
    }
    public function models($request)
    {
        $models = $this->model->where(function ($query) use ($request) {
            if ($request->has('status')) {
                $query->where('status', $request->status);
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
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        foreach ($request->questions_answers as $qa) {
            $this->qaModel->create([
                'question' => [
                    'en' => $qa['en']['question'],
                    'ar' => $qa['ar']['question'],
                    'ru' => $qa['ru']['question'],
                ],
                'answer' => [
                    'en' => $qa['en']['answer'],
                    'ar' => $qa['ar']['answer'],
                    'ru' => $qa['ru']['answer'],
                ],
                'quiz_id' => $model->id,
            ]);
        }

        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.create')]]];
        }
        return ['status' => true, 'data' => $model];
    }

    public function changeStatus($id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }
        if ($model->status == 'unread') {
            $model->update([
                'status' => 'read'
            ]);
            $model->save();
        } else {
            $model->update([
                'status' => 'unread'
            ]);
            $model->save();
        }
        return ['status' => true];
    }

    public function read($id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }
        if ($model->status == 'unread') {
            $model->update([
                'status' => 'read'
            ]);
            $model->save();
        } else {
            return ['status' => false];
        }
        return ['status' => true];
    }

    public function unread($id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }
        if ($model->status == 'read') {
            $model->update([
                'status' => 'unread'
            ]);
            $model->save();
        } else {
            return ['status' => false];
        }
        return ['status' => true];
    }
}
