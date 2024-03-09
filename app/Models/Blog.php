<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Localizable;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends Model implements HasMedia
{
    use HasFactory, Localizable, HasTranslations, InteractsWithMedia;
    protected $guarded = ['id'];
    protected $casts = ['title' => 'json', 'description' => 'json', 'hashtags' => 'string', 'likes' => 'integer', 'unlikes' => 'integer'];
    public $translatable = ['title', 'description'];

    public function similarBlogs()
    {
        $hashtags = explode(',', $this->hashtags);

        return Blog::where('id', '<>', $this->id)
            ->where(function ($query) use ($hashtags) {
                foreach ($hashtags as $hashtag) {
                    $query->orWhere('hashtags', 'like', "%$hashtag%");
                }
            })
            ->limit(3)
            ->get();
    }

    public function views()
    {
        return $this->hasMany(BlogView::Class, 'blog_id');
    }
}
