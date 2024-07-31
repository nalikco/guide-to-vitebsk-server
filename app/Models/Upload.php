<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Upload extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'path',
        'name',
        'extension',
    ];

    protected function storagePath(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->path.'/'.$this->name.'.'.$this->extension,
        );
    }

    protected function publicPath(): Attribute
    {
        return Attribute::make(
            get: fn () => URL::asset('storage/'.$this->storage_path),
        );
    }
}
