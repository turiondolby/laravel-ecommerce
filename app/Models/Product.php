<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Spatie\Image\Manipulations;
use App\Models\Scopes\LiveScope;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Searchable;

    protected static function booted()
    {
        static::addGlobalScope(new LiveScope());
    }

    public function formattedPrice()
    {
        return money($this->price);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb200x200')
            ->fit(Manipulations::FIT_CROP, 200, 200);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useFallbackUrl(url('/storage/no-product-image.png'));
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function toSearchableArray()
    {
        return array_merge([
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'price' => $this->price,
            'category_ids' => $this->categories->pluck('id')->toArray(),
        ], $this->variations->groupBy('type')
            ->mapWithKeys(function ($variation, $key) {
                return [
                    $key => $variation->pluck('title')
                ];
            })
            ->toArray()
        );
    }
}
