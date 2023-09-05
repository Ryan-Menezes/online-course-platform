@props([
    'course'
])

<figure class="relative max-w-sm transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0">
    <a href="#">
        <img class="rounded-lg h-60 object-cover object-center w-full" src="{{ $course->thumb->url }}" alt="{{ $course->title }}">
    </a>
    <figcaption class="absolute px-4 text-lg text-white bottom-6">
        <h2 class="text-2xl mb-3 font-bold">{{ $course->title }}</h2>

        <p>{{ $course->description }}</p>
    </figcaption>
</figure>
