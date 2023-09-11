<?php

namespace App\Models;

use App\Models\Traits\FilterScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes, FilterScope;

    private array $permissions = ['files-create', 'files-edit', 'files-delete'];

    public function scopeMimetypes(Builder $query, array $mimetypes): void
    {
        $query->when($mimetypes, function ($query) use ($mimetypes) {
            $query->whereIn('mimetype', $mimetypes);
        });
    }

    public function url(): Attribute
    {
        return Attribute::get(function () {
            if (str($this->path)->startsWith('http')) {
                return $this->path;
            }

            return url("storage/{$this->path}");
        });
    }

    public function thumb(): Attribute
    {
        return Attribute::get(function () {
            if ($this->isImage()) {
                return $this->url;
            }

            return url('assets/img/file.png');
        });
    }

    public function isImage(): bool
    {
        return str($this->mimetype)->startsWith('image/');
    }

    public function scopeSearch(Builder $query, ?string $search): void
    {
        $query->when($search, function (Builder $query) use ($search) {
            $query
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('path', 'LIKE', "%{$search}%");
        });
    }
}
