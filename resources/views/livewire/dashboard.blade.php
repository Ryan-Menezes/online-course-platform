<div>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <h2 class="mb-9 text-4xl font-extrabold leading-none tracking-tight text-gray-900 dark:text-white">Recent <span class="bg-blue-100 text-blue-800 font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-2">Courses</span></h1>

    <div class="grid grid-cols-3 gap-5">
        @foreach($this->recentCourses as $course)
            <x-courses.card :course="$course" />
        @endforeach
    </div>
</div>

