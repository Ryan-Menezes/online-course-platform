<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    public function url(): Attribute
    {
        return Attribute::get(function () {
            if (str($this->path)->startsWith('http')) {
                return $this->path;
            }

            return url("storage/{$this->path}");
        });
    }

    public function isImage(): bool
    {
        return str($this->mimetype)->startsWith('image/');
    }
}
