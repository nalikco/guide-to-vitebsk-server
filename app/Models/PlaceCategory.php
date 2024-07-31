<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceCategory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'name',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Upload::class, 'uploadable');
    }

    public function getImagesPath(): string
    {
        return 'place-categories';
    }

    public function views(): HasMany
    {
        return $this->hasMany(PlaceCategoryView::class);
    }
}
