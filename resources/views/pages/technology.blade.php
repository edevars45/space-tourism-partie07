{{-- resources/views/pages/technology.blade.php --}}

@extends('layouts.app')
@section('title', $pageTitle ?? 'Technology')

@section('content')
@php
    // On normalise les données
    $techs = collect($technologies ?? []);
    $hasTech = $techs->isNotEmpty();
@endphp

<section
    class="min-h-screen bg-no-repeat bg-cover bg-center relative overflow-hidden"
    style="background-image: url('{{ asset('images/technology/background-stars.jpg') }}');"
>
    <div class="absolute inset-0 bg-black/45"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-6 md:px-10 lg:px-12 pt-10 md:pt-14 lg:pt-16 pb-10 md:pb-14">

        {{-- Titre de page --}}
        <h1 class="font-barlow-condensed uppercase text-center md:text-left mb-8 md:mb-12 tracking-[0.25em] text-sm md:text-base text-gray-300">
            <span class="font-bold text-white/70 mr-3">03</span>
            {{ $heading ?? __('technology.heading') }}
        </h1>

        @unless($hasTech)
            <p class="text-white/70">Aucune technologie disponible pour le moment.</p>
        @else
            @php
                // Index actif par défaut = 0
                $activeIndex = 0;
                $active = $techs[$activeIndex];
            @endphp

            @foreach($techs as $i => $tech)
                @php
                    $isActive = $i === $activeIndex;

                    $title       = $tech['name']        ?? '';
                    $description = $tech['description'] ?? '';
                    $image       = $tech['image']       ?? null;
                @endphp

                <article
                    class="tech-slide {{ $isActive ? 'opacity-100' : 'opacity-0 hidden' }}
                           transition-opacity duration-500 grid md:grid-cols-2 gap-10 lg:gap-14 items-center"
                    data-index="{{ $i }}"
                    aria-labelledby="tech-title-{{ $i }}"
                >
                    {{-- IMAGE --}}
                    <div class="order-1 md:order-2 flex justify-center md:justify-end">
                        @if($image)
                            <img
                                src="{{ $image }}"
                                alt="{{ $title }}"
                                class="w-full max-w-[480px] md:max-w-[520px] h-auto object-contain"
                            >
                        @endif
                    </div>

                    {{-- CONTENU + BOUTONS --}}
                    <div class="order-2 md:order-1 flex flex-col md:flex-row items-center md:items-start gap-8 md:gap-12">

                        {{-- Boutons 1 / 2 / 3 --}}
                        <div class="flex md:flex-col gap-4 justify-center"
                             role="tablist" aria-label="{{ $pageTitle ?? 'Technology' }}">
                            @foreach($techs as $j => $t)
                                @php $activeDot = $j === $i; @endphp
                                <button type="button"
                                        class="tech-dot h-12 w-12 rounded-full border-2 border-white flex items-center justify-center
                                               font-bold text-lg transition
                                               {{ $activeDot ? 'bg-white text-black' : 'bg-transparent text-white hover:bg-white/20 hover:scale-110' }}"
                                        data-goto="{{ $j }}"
                                        role="tab"
                                        aria-selected="{{ $activeDot ? 'true' : 'false' }}"
                                        aria-controls="tech-panel-{{ $j }}">
                                    {{ $j + 1 }}
                                </button>
                            @endforeach
                        </div>

                        {{-- TEXTE --}}
                        <div id="tech-panel-{{ $i }}" class="text-center md:text-left">
                            <p class="uppercase font-barlow-condensed tracking-widest text-gray-400 mb-2">
                                {{ __('technology.terminology') }}
                            </p>
                            <h2 id="tech-title-{{ $i }}" class="text-3xl md:text-5xl font-bellefair uppercase mb-4">
                                {{ $title }}
                            </h2>
                            <p class="text-gray-200 leading-relaxed max-w-xl font-barlow">
                                {{ $description }}
                            </p>
                        </div>
                    </div>
                </article>
            @endforeach
        @endunless
    </div>
</section>

@if($hasTech)
<script>
    (function () {
        const slides = Array.from(document.querySelectorAll('.tech-slide'));
        const dots   = Array.from(document.querySelectorAll('.tech-dot'));

        function showSlide(index) {
            slides.forEach((s, i) => {
                if (i === index) {
                    s.classList.remove('hidden', 'opacity-0');
                    s.classList.add('opacity-100');
                } else {
                    s.classList.add('opacity-0');
                    setTimeout(() => s.classList.add('hidden'), 300);
                }
            });

            dots.forEach((d, i) => {
                const active = i === index;
                d.setAttribute('aria-selected', active ? 'true' : 'false');
                d.classList.toggle('bg-white', active);
                d.classList.toggle('text-black', active);
                d.classList.toggle('bg-transparent', !active);
                d.classList.toggle('text-white', !active);
            });
        }

        dots.forEach(d => {
            d.addEventListener('click', () => showSlide(parseInt(d.dataset.goto, 10)));
            d.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    d.click();
                }
            });
        });

        showSlide(0);
    })();
</script>
@endif
@endsection
