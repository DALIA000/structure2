<?php

namespace App\Http\Repositories\Agent;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Agent;
use App\Models\Service;
use App\Services\ResponseService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AgentRepository extends BaseRepository implements AgentInterface
{

    public function __construct(Agent $model, public Media $media, public ResponseService $responseService)
    {
        $this->model = $model;
        $this->media = $media;
        $this->responseService = $responseService;
    }
    public function models($request)
    {
        $models = $this->model->where(function ($query) use ($request) {
            if ($request->has('search')) {
                $searchTerm = '%' . $request->search . '%';
                $query->where(function ($query) use ($request, $searchTerm) {
                    $query->Where('first_name->ar', 'like', $searchTerm)
                        ->orWhere('first_name->en', 'like', $searchTerm)
                        ->orWhere('first_name->ru', 'like', $searchTerm)
                        ->orWhere('last_name->ar', 'like', $searchTerm)
                        ->orWhere('last_name->en', 'like', $searchTerm)
                        ->orWhere('last_name->ru', 'like', $searchTerm)
                        ->orWhere('position->ar', 'like', $searchTerm)
                        ->orWhere('position->en', 'like', $searchTerm)
                        ->orWhere('position->ru', 'like', $searchTerm)
                        ->orWhere('lang->ar', 'like', $searchTerm)
                        ->orWhere('lang->en', 'like', $searchTerm)
                        ->orWhere('lang->ru', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm)
                        ->orWhere('whatsapp', 'like', $searchTerm)
                        ->orWhere('phone', 'like', $searchTerm);
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
        $slug = $this->generateSlug($this->model, $request->locales['en']['first_name']);
        $model = $this->model->create([
            'slug' => $slug,
            'first_name' => [
                'ar' => $request->locales['ar']['first_name'],
                'en' => $request->locales['en']['first_name'],
                'ru' => $request->locales['ru']['first_name'],
            ],
            'last_name' => [
                'ar' => $request->locales['ar']['last_name'],
                'en' => $request->locales['en']['last_name'],
                'ru' => $request->locales['ru']['last_name'],
            ],
            'position' => [
                'ar' => $request->locales['ar']['position'],
                'en' => $request->locales['en']['position'],
                'ru' => $request->locales['ru']['position'],
            ],
            'lang' => [
                'ar' => $request->locales['ar']['lang'],
                'en' => $request->locales['en']['lang'],
                'ru' => $request->locales['ru']['lang'],
            ],
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'service' => []
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
        //services
        if ($request->has('service') && is_array($request->service)) {
            $servicesData = [];
            foreach ($request->service as $serviceId) {
                $service = Service::find($serviceId);
                $service->update(['agent' => $model->id]);
                $service->refresh();
                $servicesData[] = $serviceId;
            }
            $model->update(['service' => $servicesData]);
        }
        return ['status' => true, 'data' => $model];
    }

    public function edit($request, $id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Agent'])]]];
        }
        if (isset($request->position)) {
            $model->update(["position" => $request->position]);
        }
        //services
        if ($request->has('service') && is_array($request->service)) {
            $servicesData = [];
            foreach ($request->service as $serviceId) {
                $service = Service::find($serviceId);
                $service->update(['agent' => $model->id]);
                $service->refresh();
                $servicesData[] = $serviceId;
            }
            $model->update(['service' => $servicesData]);
        }
        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['first_name'])) {
                $jsonData = is_array($model->first_name) ? $model->first_name : json_decode($model->first_name, true);
                $jsonData[$locale] = $request->locales[$locale]['first_name'];
                $model->update(["first_name" => $jsonData]);
                $model->fresh();
            }
            if (isset($request->locales[$locale]['last_name'])) {
                $jsonData = is_array($model->last_name) ? $model->last_name : json_decode($model->last_name, true);
                $jsonData[$locale] = $request->locales[$locale]['last_name'];
                $model->update(["last_name" => $jsonData]);
                $model->fresh();
            }
            if (isset($request->locales[$locale]['lang'])) {
                $jsonData = is_array($model->lang) ? $model->lang : json_decode($model->lang, true);
                $jsonData[$locale] = $request->locales[$locale]['lang'];
                $model->update(["lang" => $jsonData]);
                $model->fresh();
            }
            if (isset($request->locales[$locale]['position'])) {
                $jsonData = is_array($model->position) ? $model->position : json_decode($model->position, true);
                $jsonData[$locale] = $request->locales[$locale]['position'];
                $model->update(["position" => $jsonData]);
                $model->fresh();
            }
        }
        if (isset($request->email)) {
            $model->update(["email" => $request->email]);
        }
        if (isset($request->phone)) {
            $model->update(["phone" => $request->phone]);
        }
        if (isset($request->whatsapp)) {
            $model->update(["whatsapp" => $request->whatsapp]);
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

    public function addClick($slug)
    {
        $model = $this->findBySlug($slug);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Developer'])]]];
        }
        $model->clicks()->create();
        return ['status' => true];
    }

    public function delete($id)
    {
        $model = $this->model::find($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound')]]];
        }
        if (!$model->products->isEmpty()) {
            return ['status' => false, 'errors' => ['error' => [trans('messages.not_empty', ['attribute' => 'agent'])]]];
        }
        $model->delete();
        return ['status' => true];
    }
}
