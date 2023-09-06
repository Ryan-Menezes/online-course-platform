<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard');
    }

    public function getRecentCoursesProperty()
    {
        return Course::query()->latest()->limit(9)->get();
    }
}
