<div class="grid grid-cols-3 gap-5">
    @for($i = 0; $i < 3; $i++)
        <figure class="relative max-w-sm transition-all duration-300 cursor-pointer filter">
            <a href="#">
                <img class="rounded-lg h-60 object-cover object-center contrast-75" src="https://kinsta.com/pt/wp-content/uploads/sites/3/2019/05/o-que-php-1024x512.png" alt="image description">
            </a>
            <figcaption class="absolute px-4 text-lg text-white bottom-6">
                <h2 class="text-2xl mb-3 font-bold">Curso de PHP Avançado</h2>

                <p>Do you want to get notified when a new component is added to Flowbite?</p>
            </figcaption>
        </figure>
    @endfor
</div>
