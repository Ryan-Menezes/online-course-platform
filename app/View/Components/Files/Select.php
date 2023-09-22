<?php

namespace App\View\Components\Files;

use App\Models\File;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class Select extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $placeholder = null,
        public ?string $mimetype = null,
    )
    {}

    public function files()
    {
        return File::query()
            ->when($this->mimetype, function (Builder $query) {
                $query->where('mimetype', 'LIKE', "%{$this->mimetype}%");
            })
            ->latest()
            ->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.files.select');
    }
}
