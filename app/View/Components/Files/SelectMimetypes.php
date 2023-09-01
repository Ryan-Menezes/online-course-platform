<?php

namespace App\View\Components\Files;

use App\Models\File;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectMimetypes extends Component
{
    public function mimetypes(): array
    {
        return File::query()->distinct()->select('mimetype')->get()->toArray();
    }

    public function render(): View|Closure|string
    {
        return view('components.files.select-mimetypes');
    }
}
