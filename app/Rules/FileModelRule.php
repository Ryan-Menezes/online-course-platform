<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class FileModelRule implements ValidationRule
{
    private Collection $allowMimetypes;

    public function __construct(array $allowMimetypes = [])
    {
        $this->allowMimetypes = collect($allowMimetypes);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        Validator::make([
            $attribute => $value?->id,
        ], [
            $attribute => ['required', 'exists:files,id'],
        ])->validate();

        if (
            $this->allowMimetypes->isNotEmpty() &&
            !$this->allowMimetypes->contains($value->mimetype)
        ) {
            $fail('The specified file does not have the correct mimetype');
        }
    }
}
