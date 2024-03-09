<?php

namespace App\Http\Repositories\Setting;

use App\Http\Repositories\Base\BaseRepository;
use App\Http\Repositories\Setting\SettingInterface;
use App\Models\General;
use App\Models\Setting;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SettingRepository extends BaseRepository implements SettingInterface
{

    public function __construct(Setting $model, public General $general, public Media $media)
    {
        $this->model = $model;
        $this->media = $media;
        $this->general = $general;
    }

    public function model($request, $slug)
    {
        $model = $this->model->where('slug', $slug)->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
        }
        return ['status' => true, 'data' => $model];
    }

    public function edit_contacts($request)
    {
        if (isset($request->social)) {
            $model = $this->findBySlug('social');
            if (!$model) {
                return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
            }
            foreach (['facebook', 'twitter', 'instagram', 'linkedin', 'tiktok'] as $social) {
                if (isset($request->social[$social])) {
                    $jsonData = is_array($model->info) ? $model->info : json_decode($model->info, true);
                    $jsonData[$social] = $request->social[$social];
                    $model->update(["info" => $jsonData]);
                    $model->fresh();
                }
            }
        }
        if (isset($request->location)) {
            $model = $this->findBySlug('location');
            if (!$model) {
                return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
            }
            foreach (['lat', 'long'] as $var) {
                if (isset($request->location[$var])) {
                    $jsonData = is_array($model->info) ? $model->info : json_decode($model->info, true);
                    $jsonData[$var] = $request->location[$var];
                    $model->update(["info" => $jsonData]);
                    $model->fresh();
                }
            }
        }

        if (isset($request->locales)) {
            $model = $this->findBySlug('address');
            if (!$model) {
                return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
            }
            foreach (['ar', 'en', 'ru'] as $var) {
                if (isset($request->locales[$var]['address'])) {
                    $jsonData = is_array($model->text) ? $model->text : json_decode($model->text, true);
                    $jsonData[$var] = $request->locales[$var]['address'];
                    $model->update(["text" => $jsonData]);
                    $model->fresh();
                }
            }
        }
        if (isset($request->contacts)) {
            $model = $this->findBySlug('contacts');
            if (!$model) {
                return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
            }
            foreach (['phone', 'email', 'whatsapp'] as $var) {
                if (isset($request->contacts[$var])) {
                    $jsonData = is_array($model->info) ? $model->info : json_decode($model->info, true);
                    $jsonData[$var] = $request->contacts[$var];
                    $model->update(["info" => $jsonData]);
                    $model->fresh();
                }
            }
        }
        return ['status' => true];
    }

    public function edit_currency($request)
    {
        $model = $this->findBySlug('currency');
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
        }
        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['description'])) {
                $jsonData = is_array($model->text) ? $model->text : json_decode($model->text, true);
                $jsonData[$locale] = $request->locales[$locale]['description'];
                $model->update(["text" => $jsonData]);
                $model->fresh();
            }
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

    public function edit_terms($request)
    {
        $model = $this->findBySlug('terms');
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
        }
        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['description'])) {
                $jsonData = is_array($model->text) ? $model->text : json_decode($model->text, true);
                $jsonData[$locale] = $request->locales[$locale]['description'];
                $model->update(["text" => $jsonData]);
                $model->fresh();
            }
        }
        return ['status' => true];
    }

    public function edit_privacy($request)
    {
        $model = $this->findBySlug('privacy');
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
        }
        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['description'])) {
                $jsonData = is_array($model->text) ? $model->text : json_decode($model->text, true);
                $jsonData[$locale] = $request->locales[$locale]['description'];
                $model->update(["text" => $jsonData]);
                $model->fresh();
            }
        }
        return ['status' => true];
    }

    public function brochure($request)
    {
        $model = $this->general->where('slug', 'pdf')->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
        }
        return ['status' => true, 'data' => $model];
    }
    public function about($request)
    {
        $model = $this->general->where('slug', 'about')->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
        }
        return ['status' => true, 'data' => $model];
    }

    public function edit_brochure($request)
    {
        $model = $this->general->where('slug', 'pdf')->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
        }
        if ($request->has('pdf') && $model->getMedia('files')->first()?->id != $request->pdf) {
            $model->clearMediaCollection('files');
            $this->media->where('id', $request->pdf)
                ->update([
                    'model_id' => $model->id,
                    'model_type' => get_class($this->general),
                    'collection_name' => 'files'
                ]);
        }
        return ['status' => true];
    }

    public function edit_about($request)
    {
        $model = $this->general->where('slug', 'about')->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
        }
        if ($request->has('image') && $model->getMedia('images')->first()?->id != $request->image) {
            $model->clearMediaCollection('images');
            $this->media->where('id', $request->image)
                ->update([
                    'model_id' => $model->id,
                    'model_type' => get_class($this->general),
                    'collection_name' => 'images'
                ]);
        }
        return ['status' => true];
    }

    public function edit_statistics_title($request)
    {
        $model = $this->findBySlug('statistics_title');
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
        }
        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['description'])) {
                $jsonData = is_array($model->text) ? $model->text : json_decode($model->text, true);
                $jsonData[$locale] = $request->locales[$locale]['description'];
                $model->update(["text" => $jsonData]);
                $model->fresh();
            }
        }
        return ['status' => true];
    }

    public function edit_table_title($request)
    {
        $model = $this->findBySlug('table_title');
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => 'Setting'])]]];
        }
        foreach (['en', 'ar', 'ru'] as $locale) {
            if (isset($request->locales[$locale]['description'])) {
                $jsonData = is_array($model->text) ? $model->text : json_decode($model->text, true);
                $jsonData[$locale] = $request->locales[$locale]['description'];
                $model->update(["text" => $jsonData]);
                $model->fresh();
            }
        }
        return ['status' => true];
    }
}

