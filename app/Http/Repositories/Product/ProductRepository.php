<?php

namespace App\Http\Repositories\Product;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\productForm;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductRepository extends BaseRepository implements ProductInterface
{
    public $media;
    public $details;
    public function __construct(Product $model, Media $media, ProductDetails $details, public productForm $form)
    {
        $this->model = $model;
        $this->media = $media;
        $this->details = $details;
        $this->form = $form;
    }
    public function models($request)
    {
        $models = $this->model->where(function ($query) use ($request) {

            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function ($query) use ($searchTerm) {
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(title, '$.en'))) LIKE ?", [strtolower('%' . $searchTerm . '%')])
                        ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(description, '$.en'))) LIKE ?", [strtolower('%' . $searchTerm . '%')])
                        ->orWhere('title->ar', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('title->ru', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('description->ar', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('description->ru', 'LIKE', '%' . $searchTerm . '%');
                });
            }

            if ($request->exists('category_id') && $request->category_id !== null) {
                $query->where('category', $request->category_id);
            }

            if ($request->exists('category_slug') && $request->category_slug !== null) {
                $query->WhereHas('Category', function ($query) use ($request) {
                    $query->where('slug', $request->category_slug);
                });
            }

            if ($request->exists('type_id') && $request->type_id !== null) {
                $query->where('type', $request->type_id);
            }

            if ($request->exists('type_slug') && $request->type_slug !== null) {
                $query->WhereHas('Type', function ($query) use ($request) {
                    $query->where('slug', $request->type_slug);
                });
            }

            if ($request->exists('developer_id') && $request->developer_id !== null) {
                $query->where('developer', $request->developer_id);
            }

            if ($request->exists('developer_slug') && $request->developer_slug !== null) {
                $query->WhereHas('Developer', function ($query) use ($request) {
                    $query->where('slug', $request->developer_slug);
                });
            }

            if ($request->exists('agent_id') && $request->agent_id !== null) {
                $query->where('agent', $request->agent_id);
            }

            if ($request->exists('agent_slug') && $request->agent_slug !== null) {
                $query->WhereHas('Agent', function ($query) use ($request) {
                    $query->where('slug', $request->agent_slug);
                });
            }

            if ($request->exists('community_id') && $request->community_id !== null) {
                $query->where('community', $request->community_id);
            }

            if ($request->exists('community_slug') && $request->community_slug !== null) {
                $query->WhereHas('Community', function ($query) use ($request) {
                    $query->where('slug', $request->community_slug);
                });
            }

            if ($request->exists('status') && $request->status !== null) {
                $query->where('status', $request->status);
            }

            if ($request->exists('furnishing') && $request->furnishing !== null) {
                $query->where('furnishing', $request->furnishing);
            }

            if ($request->exists('address') && $request->address !== null) {
                $query->where('address', $request->address);
            }

            if ($request->exists('bedroom_min') && $request->bedroom_min !== null && !$request->exists('bedroom_max')) {
                $query->whereHas('details', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('min_bedroom', '>=', $request->bedroom_min)
                            ->orWhere('max_bedroom', '>=', $request->bedroom_min);
                    });
                });
            }

            if ($request->exists('bedroom_max') && $request->bedroom_max !== null && !$request->exists('bedroom_min')) {
                $query->whereHas('details', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('min_bedroom', '<=', $request->bedroom_max)
                            ->orWhere('max_bedroom', '<=', $request->bedroom_max);
                    });
                });
            }

            if ($request->exists('bedroom_min') && $request->bedroom_min !== null && $request->exists('bedroom_max') && $request->bedroom_max !== null) {
                $query->whereHas('details', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('max_bedroom', '<=', $request->bedroom_max)
                            ->orWhere('min_bedroom', '<=', $request->bedroom_max);
                    })->where('min_bedroom', '>=', $request->bedroom_min)
                    ->orWhere('max_bedroom', '>=', $request->bedroom_min);
                });
            }

            if ($request->exists('bathroom_min') && $request->bathroom_min !== null && !$request->exists('bathroom_max')) {
                $query->whereHas('details', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('min_bathroom', '>=', $request->bathroom_min)
                            ->orWhere('max_bathroom', '>=', $request->bathroom_min);
                    });
                });
            }

            if ($request->exists('bathroom_max') && $request->bathroom_max !== null && !$request->exists('bathroom_min')) {
                $query->whereHas('details', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('min_bathroom', '<=', $request->bathroom_max)
                            ->orWhere('max_bathroom', '<=', $request->bathroom_max);
                    });
                });
            }

            if ($request->exists('bathroom_min') && $request->bathroom_min !== null && $request->exists('bathroom_max') && $request->bathroom_max !== null) {
                $query->whereHas('details', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->where('max_bathroom', '<=', $request->bathroom_max)
                                ->orWhere('min_bathroom', '<=', $request->bathroom_max);
                        })->where(function ($query) use ($request) {
                            $query->where('min_bathroom', '>=', $request->bathroom_min)
                                ->orWhere('max_bathroom', '>=', $request->bathroom_min);
                        });
                    });
                });
            }

            if ($request->exists('size_min') && $request->size_min !== null && !$request->exists('size_max')) {
                $query->whereHas('details', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('min_size', '>=', $request->size_min)
                            ->orWhere('max_size', '>=', $request->size_min);
                    });
                });
            }

            if ($request->exists('size_max') && $request->size_max !== null && !$request->exists('size_min')) {
                $query->whereHas('details', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('min_size', '<=', $request->size_max)
                            ->orWhere('max_size', '<=', $request->size_max);
                    });
                });
            }

            if ($request->exists('size_min') && $request->size_min !== null && $request->exists('size_max') && $request->size_max !== null) {
                $query->whereHas('details', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('max_size', '<=', $request->size_max)
                            ->orWhere('min_size', '<=', $request->size_max);
                    })->where('min_size', '>=', $request->size_min)
                    ->orWhere('max_size', '>=', $request->size_min);
                });
            }

            // if ($request->exists('bedroom_min') && $request->bedroom_min !== null && !$request->exists('bedroom_max')) {
            //     $query->whereHas('Details', function ($query) use ($request) {
            //         $query->where("min_bedroom", ">=", $request->bedroom_min);
            //     });
            // }

            // if ($request->exists('bedroom_min') && $request->bedroom_min !== null && $request->exists('bedroom_max') && $request->bedroom_max !== null) {
            //     $query->whereHas('Details', function ($query) use ($request) {
            //         $query->where("max_bedroom", "<=", $request->bedroom_max)
            //         ->orWhere("min_bedroom", "<=", $request->bedroom_max);
            //     });
            // }


            // if ($request->exists('bathroom_min') && $request->bathroom_min !== null && !$request->exists('bathroom_max')) {
            //     $query->whereHas('Details', function ($query) use ($request) {
            //         $query->where("min_bathroom", ">=", $request->bathroom_min);
            //     });
            // }

            // if ($request->exists('bathroom_max') && $request->bathroom_max !== null && !$request->exists('bathroom_min')) {
            //     $query->whereHas('Details', function ($query) use ($request) {
            //         $query->where("max_bathroom", "<=", $request->bathroom_max);
            //     });
            // }

            // if ($request->exists('bathroom_min') && $request->bathroom_min !== null && $request->exists('bathroom_max') && $request->bathroom_max !== null) {
            //     $query->whereHas('Details', function ($query) use ($request) {
            //         $query->where("max_bathroom", "<=", $request->bathroom_max)
            //             ->orWhere("min_bathroom", "<=", $request->bathroom_max);
            //     });
            // }

            // if ($request->exists('size_min') && $request->size_min !== null && !$request->exists('size_max')) {
            //     $query->whereHas('Details', function ($query) use ($request) {
            //         $query->where("min_size", ">=", $request->size_min);
            //     });
            // }

            // if ($request->exists('size_max') && $request->size_max !== null && !$request->exists('size_min')) {
            //     $query->whereHas('Details', function ($query) use ($request) {
            //         $query->where("max_size", "<=", $request->size_max);
            //     });
            // }

            // if ($request->exists('size_min') && $request->size_min !== null && $request->exists('size_max') && $request->size_max !== null) {
            //     $query->whereHas('Details', function ($query) use ($request) {
            //         $query->where("max_size", "<=", $request->size_max)
            //             ->orWhere("min_size", "<=", $request->size_max);
            //     });
            // }

            if ($request->exists('amenities') && is_array($request->amenities)) {
                $query->where(function ($q) use ($request) {
                    foreach ($request->amenities as $amenityId) {
                        $q->orWhereJsonContains('amenities', $amenityId);
                    }
                });
            }

            if ($request->exists('type') && is_array($request->type)) {
                $query->where(function ($q) use ($request) {
                    foreach ($request->type as $typeId) {
                        $q->orWhereJsonContains('type', $typeId);
                    }
                });
            }
            if ($request->exists('trashed') && $request->trashed !== null) {
                $query->onlyTrashed();
            }

            if ($request->exists('rental_period') && $request->rental_period !== null) {
                $query->where('rental_period', 'like', '%' . $request->rental_period . '%');
            }
            if ($request->exists('handover_date') && $request->handover_date !== null) {
                $query->where('handover_date', 'like', '%' . $request->handover_date . '%');
            }
        });
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
            'address' => [
                'ar' => $request->locales['ar']['address'],
                'en' => $request->locales['en']['address'],
                'ru' => $request->locales['ru']['address'],
            ],
            'location' => [
                'lat' => $request->location['lat'],
                'long' => $request->location['long']
            ],
            'price' => $request->price,
            'type' => [],
            'category' => $request->category,
            'amenities' => [],
            'badge' => [],
            'community' => $request->community,
            'agent' => $request->agent,
            'developer' => $request->developer,
            'rental_period' => $request->rental_period,
            'handover_date' => $request->handover_date,
        ]);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.create')]]];
        }
        // $model->Details()->create();

        if($request->furnishing){
            $model->update(['furnishing' => $request->furnishing]);
        }

        if (isset($request->locales['ar']['badge']) && isset($request->locales['en']['badge']) && isset($request->locales['ru']['badge'])) {
            $model->update([
                'badge' => [
                    'ar' => $request->locales['ar']['badge'],
                    'en' => $request->locales['en']['badge'],
                    'ru' => $request->locales['ru']['badge'],
                ],
            ]);
        }
        //amenities
        if ($request->has('amenities') && is_array($request->amenities)) {
            $amenitiesData = [];
            foreach ($request->amenities as $amenities) {
                $amenitiesData[] = $amenities;
            }
            $model->update(['amenities' => $amenitiesData]);
        }
        //type
        if ($request->has('type') && is_array($request->type)) {
            $typeData = [];
            foreach ($request->type as $type) {
                $typeData[] = $type;
            }
            $model->update(['type' => $typeData]);
        }

        $details = ProductDetails::create();
        $model->update([
            'details' => $details->id
        ]);

        if (isset($request->min_bathroom) || isset($request->max_bathroom)) {
            $details->update([
                'min_bathroom' => $request->min_bathroom,
                'max_bathroom' => $request->max_bathroom,
            ]);
        }

        if (isset($request->min_bedroom) || isset($request->max_bedroom)) {
            $details->update([
                'min_bedroom' => $request->min_bedroom,
                'max_bedroom' => $request->max_bedroom,
            ]);
        }

        if (isset($request->min_size) || isset($request->max_size)) {
            $details->update([
                'min_size' => $request->min_size,
                'max_size' => $request->max_size,
            ]);
        }

        $category = Category::find($request->category)->name;
        $handover_date_categories = ['Luxury', 'Buy', 'New Projects', 'luxury', 'buy', 'new projects'];
        $rental_period_categories = ['Rent', 'rent'];

        if (in_array($category, $handover_date_categories)) {
            // $request->validate([
            //     'handover_date' => 'required',
            // ]);
            $model->update(['handover_date' => $request->handover_date]);
        }

        if (in_array($category, $rental_period_categories)) {
            // $request->validate([
            //     'rental_period' => 'required|exists:rental_periods,id',
            // ]);
            $model->update(['rental_period' => $request->rental_period]);
        }

        $this->media
            ->whereIn('id', $request->images)
            ->update([
                'model_id' => $model->id,
                'model_type' => get_class($model),
            ]);

        $this->media
            ->where('id', $request->brochure)
            ->update([
                'model_id' => $model->id,
                'model_type' => get_class($model),
                'collection_name' => 'brochure',
            ]);
        return ['status' => true, 'data' => $model];
    }

    public function edit($request, $id)
    {
        $model = $this->findById($id);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound', ['model' => '[Product]'])]]];
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
            if (isset($request->locales[$locale]['address'])) {
                $jsonData = is_array($model->address) ? $model->address : json_decode($model->address, true);
                $jsonData[$locale] = $request->locales[$locale]['address'];
                $model->update(["address" => $jsonData]);
                $model->fresh();
            }
            if (isset($request->locales[$locale]['badge'])) {
                $existingBadge = $model->badge;
                if (is_scalar($existingBadge) || (is_string($existingBadge) && is_json($existingBadge))) {
                    $existingBadge = [$locale => $existingBadge];
                } elseif (!is_array($existingBadge)) {
                    $existingBadge = [];
                }
                $existingBadge[$locale] = $request->locales[$locale]['badge'];
                $model->update(["badge" => $existingBadge]);
                $model->fresh();
            }
        }
        if (isset($request->locales['en']['title'])) {
            $slug = $this->generateSlug($this->model, $request->locales['en']['title']);
            $model->update(["slug" => $slug]);
        }
        if (isset($request->status) && $request->status == 1) {
            $type = $model->Type->pluck('status');
            if ($type->contains(1)) {
                $model->update(['status' => $request->status]);
            } else {
                return ['status' => false, 'errors' => ['error' => [trans('messages.highlight')]]];
            }
        }

        if(isset($request->status) && $request->status == 0){
            $model->update(['status' => $request->status]);
        }
//changed now.
        // if (isset($request->type)) {
        //     $model->update(['type' => $request->type, 'status' => 0]);
        // }

        if (isset($request->price)) {
            $model->update(['price' => $request->price]);
        }
        if (isset($request->category)) {
            $model->update(['category' => $request->category]);
            $category = Category::find($request->category)->name;
            $handover_date_categories = ['Luxury', 'Buy', 'New Projects', 'luxury', 'buy', 'new projects'];
            $rental_period_categories = ['Rent', 'rent'];

            if (isset($request->handover_date)) {
                $model->update(['handover_date' => $request->handover_date]);
            }

            if (isset($request->rental_period)) {
                $model->update(['rental_period' => $request->rental_period]);
            }
        }
        if ($request->has('amenities') && is_array($request->amenities)) {
            $amenitiesData = [];
            foreach ($request->amenities as $amenities) {
                $amenitiesData[] = $amenities;
            }
            $model->update(['amenities' => $amenitiesData]);
        }
        if ($request->has('type') && is_array($request->type)) {
            $typeData = [];
            foreach ($request->type as $type) {
                $typeData[] = $type;
            }
            $model->update(['type' => $typeData]);
        }
        if (isset($request->furnishing)) {
            $model->update(['furnishing' => $request->furnishing]);
        }
        if (isset($request->community)) {
            $model->update(['community' => $request->community]);
        }
        if (isset($request->agent)) {
            $model->update(['agent' => $request->agent]);
        }
        if (isset($request->developer)) {
            $model->update(['developer' => $request->developer]);
        }
        if (isset($request->min_bathroom) || isset($request->max_bathroom)) {
            $model->details()->updateOrCreate(
                [],
                [
                    'min_bathroom' => $request->min_bathroom,
                    'max_bathroom' => $request->max_bathroom,
                ]
            );
        }

        if (isset($request->min_bedroom) || isset($request->max_bedroom)) {
            $model->details()->updateOrCreate(
                [],
                [
                    'min_bedroom' => $request->min_bedroom,
                    'max_bedroom' => $request->max_bedroom,
                ]
            );
        }

        if (isset($request->min_size) || isset($request->max_size)) {
            $model->details()->updateOrCreate(
                [],
                [
                    'min_size' => $request->min_size,
                    'max_size' => $request->max_size,
                ]
            );
        }


        foreach (['lat', 'long'] as $var) {
            if (isset($request->location[$var])) {
                $jsonData = is_array($model->location) ? $model->location : json_decode($model->location, true);
                $jsonData[$var] = $request->location[$var];
                $model->update(["location" => $jsonData]);
                $model->fresh();
            }
        }
        if ($request->has('images')) {
            $newImageIds = $this->UpdateImage($request, $model);
            if ($newImageIds) {
                foreach ($newImageIds as $imageId) {
                    Media::where('id', $imageId)
                        ->update([
                            'model_type' => Product::class,
                            'model_id' => $id,
                        ]);
                }
            }
        }
        if ($request->has('brochure') && $model->getMedia('brochure')->first()?->id == null || $model->getMedia('brochure')->first()?->id !=  $request->brochure) {
            $this->media->where('id', $request->brochure)
                ->update([
                    'model_id' => $model->id,
                    'model_type' => get_class($this->model),
                    'collection_name' => 'brochure'
                ]);
        }
        if ($request->has('brochure') && $model->getMedia('brochure')->first()?->id !== null) {
            $media = $this->media->updateOrCreate(
                ['id' => $request->brochure],
                [
                    'model_id' => $model->id,
                    'model_type' => get_class($this->model),
                    'collection_name' => 'brochure'
                ]
            );
            if ($media->wasRecentlyCreated || $media->wasChanged()) {
                $model->clearMediaCollection('brochure');
                $model->addMedia($media)->toMediaCollection('brochure');
            }
        }
        return ['status' => true];
    }

    public function createForm($request){
        $model = $this->form->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'product_slug' => $request->product_slug,
        ]);
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.create')]]];
        }
        return ['status' => true];
    }

    public function getForm($request)
    {
        $models = $this->form->where(function ($query) use ($request) {
            if ($request->has('search')) {
                $searchTerm = '%' . $request->search . '%';
            }
        });
        if ($request->exists('status') && $request->status !== null) {
            $models->where('status', $request->status);
        }
        if ($request->exists('trashed') && $request->trashed !== null) {
            $models->onlyTrashed();
        }
        $models->with($request->with ?: [])
            ->withCount($request->withCount ?: [])
            ->with([]);

        [$sort, $order] = $this->setSortParams($request);
        $models->orderBy($sort, $order);
        $models = $request->per_page ? $models->paginate($request->per_page) : $models->get();
        return ['status' => true, 'data' => $models];
    }

    public function findForm($request, $id)
    {
        $model = $this->form->where('id', $id)->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound')]]];
        }
        return ['status' => true, 'data' => $model];
    }

    public function read($request, $id)
    {
        $model = $this->form->where('id', $id)->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound')]]];
        }
        $model->update(['status' => 1]);
        return ['status' => true];
    }


    public function unread($request, $id)
    {
        $model = $this->form->where('id', $id)->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound')]]];
        }
        $model->update(['status' => 0]);
        return ['status' => true];
    }

    public function delete($id)
    {
        $model = $this->form->where('id', $id)->first();
        if (!$model) {
            return ['status' => false, 'errors' => ['error' => [trans('crud.notfound')]]];
        }
        $model->delete();
        return ['status' => true];
    }
}
