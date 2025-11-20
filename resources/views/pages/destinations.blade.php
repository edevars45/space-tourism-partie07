{{-- resources/views/pages/destinations.blade.php --}}
@php
    use App\Models\Planet;

    /**
     * Variables attendues :
     * - $planets : collection de Planet (publiées, triées)
     * - $planet  : planète courante (instance de Planet)
     */

    // Sécurité : si $planet est nul, on prend la première
    $planet = $planet ?? $planets->first();

    // Langue courante
    $isEn = app()->getLocale() === 'en';

    // Map envoyée au JavaScript :
    //  - clé = slug
    //  - valeurs déjà adaptées à la langue courante (FR ou EN)
    $planetsMap = $planets
        ->keyBy('slug')
        ->map(function (Planet $p) use ($isEn) {

            // Nom + description dans la bonne langue
            $name = $isEn
                ? ($p->name_en ?: $p->name)
                : $p->name;

            $desc = $isEn
                ? ($p->description_en ?: $p->description)
                : $p->description;

            return [
                'name'     => $name,
                'desc'     => $desc,
                'distance' => $p->distance,
                'time'     => $p->travel_time,

                // IMAGE :
                // - en base : "planets/xxxx.png" sur le disque "public"
                // - URL publique : /storage/planets/xxxx.png
                'image' => $p->image
                    ? asset('storage/' . $p->image)
                    : asset('images/destinations/' . $p->slug . '.png'), // fallback
            ];
        });

    // Données de la planète courante pour l’affichage initial
    $currentData = $planet ? ($planetsMap[$planet->slug] ?? null) : null;
@endphp

@extends('layouts.app')
@section('title', __('destinations.title'))

@section('content')
<section class="relative min-h-screen text-white overflow-hidden">

    {{-- Fond d’écran : image DESTINATIONS --}}
    <img src="{{ asset('images/destinations/background.jpg') }}" alt=""
         class="absolute inset-0 w-full h-full object-cover -z-10">
    <div class="absolute inset-0 bg-black/45 -z-10"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-6 py-16 md:py-24">

        {{-- Titre principal --}}
        <h1 class="font-barlow-condensed uppercase tracking-[0.25em] text-[#D0D6F9] text-sm md:text-base mb-12">
            <span class="font-bold text-white/70 mr-3">01</span>
            {{ __('destinations.heading') }}
        </h1>

        @if(!$planet || !$currentData)
            <p class="text-white/70">Aucune planète disponible pour le moment.</p>
        @else
            <div class="grid md:grid-cols-2 gap-12 items-center">

                {{-- Colonne gauche : image de la planète courante --}}
                <div class="flex justify-center md:justify-start transition-all duration-700 ease-in-out">
                    <img
                        id="planet-image"
                        src="{{ $currentData['image'] }}"
                        alt="{{ $currentData['name'] }}"
                        class="w-56 md:w-72 lg:w-96 object-contain transition-all duration-700 ease-in-out transform"
                    >
                </div>

                {{-- Colonne droite : onglets + infos --}}
                <div class="text-center md:text-left">

                    {{-- Onglets planètes --}}
                    <div class="flex justify-center md:justify-start gap-8 mb-8"
                         role="tablist" aria-label="{{ __('destinations.title') }}">
                        @foreach($planets as $p)
                            @php
                                $isActive = $p->id === $planet->id;
                                $baseBtn  = 'planet-btn uppercase tracking-widest text-sm md:text-base pb-2 border-b-2 transition-colors';
                                $active   = $isActive
                                    ? 'border-white text-white'
                                    : 'border-transparent text-[#D0D6F9] hover:text-white';

                                $tabData  = $planetsMap[$p->slug] ?? null;
                                $tabLabel = $tabData['name'] ?? $p->name;
                            @endphp

                            <button
                                type="button"
                                class="{{ $baseBtn }} {{ $active }}"
                                data-planet="{{ $p->slug }}"
                                role="tab"
                                aria-selected="{{ $isActive ? 'true' : 'false' }}"
                                aria-controls="dest-panel"
                            >
                                {{ $tabLabel }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Nom de la planète courante --}}
                    <h2
                        id="planet-name"
                        class="font-bellefair uppercase text-6xl md:text-7xl mb-6 transition-all duration-700"
                    >
                        {{ $currentData['name'] }}
                    </h2>

                    {{-- Description courante --}}
                    <p
                        id="planet-desc"
                        class="font-barlow text-[#D0D6F9] text-[15px] md:text-base leading-relaxed max-w-md mx-auto md:mx-0 mb-10 transition-all duration-700"
                    >
                        {{ $currentData['desc'] }}
                    </p>

                    <hr class="border-gray-600 my-8 w-3/4 md:w-full mx-auto md:mx-0">

                    {{-- Distance + temps de trajet --}}
                    <div
                        id="dest-panel"
                        class="flex flex-col md:flex-row justify-center md:justify-start gap-10 text-center md:text-left uppercase font-barlow-condensed text-[#D0D6F9] tracking-widest text-sm"
                    >
                        <div>
                            <p class="text-gray-400">{{ __('destinations.distance') }}</p>
                            <p id="planet-distance" class="font-bellefair text-white text-2xl">
                                {{ $currentData['distance'] }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-400">{{ __('destinations.travel_time') }}</p>
                            <p id="planet-time" class="font-bellefair text-white text-2xl">
                                {{ $currentData['time'] }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    </div>
</section>

{{-- Script : changement de planète côté client --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Données envoyées par PHP (déjà dans la bonne langue)
    const planets = @json($planetsMap);
    let current   = @json($planet?->slug);

    const btns   = Array.from(document.querySelectorAll('.planet-btn[role="tab"]'));
    const imgEl  = document.getElementById('planet-image');
    const nameEl = document.getElementById('planet-name');
    const descEl = document.getElementById('planet-desc');
    const distEl = document.getElementById('planet-distance');
    const timeEl = document.getElementById('planet-time');

    function updateActiveButton(activeSlug) {
        btns.forEach(b => {
            const isActive = b.dataset.planet === activeSlug;
            b.setAttribute('aria-selected', isActive ? 'true' : 'false');
            b.classList.toggle('border-white', isActive);
            b.classList.toggle('text-white', isActive);
            b.classList.toggle('border-transparent', !isActive);
            b.classList.toggle('text-[#D0D6F9]', !isActive);
        });
    }

    function animateSwap(next) {
        const p = planets[next];
        if (!p) return;

        imgEl.classList.add('opacity-0', '-translate-x-10');
        nameEl.classList.add('opacity-0', 'translate-y-4');
        descEl.classList.add('opacity-0', 'translate-y-4');

        setTimeout(() => {
            imgEl.src          = p.image;
            imgEl.alt          = p.name || next;
            nameEl.textContent = p.name || '';
            descEl.textContent = p.desc || '';
            distEl.textContent = p.distance || '';
            timeEl.textContent = p.time || '';

            imgEl.classList.remove('-translate-x-10');
            nameEl.classList.remove('translate-y-4');
            descEl.classList.remove('translate-y-4');

            imgEl.classList.remove('opacity-0');
            nameEl.classList.remove('opacity-0');
            descEl.classList.remove('opacity-0');

            nameEl.setAttribute('tabindex', '-1');
            nameEl.focus({ preventScroll: true });
            setTimeout(() => nameEl.removeAttribute('tabindex'), 0);
        }, 250);
    }

    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            const slug = btn.dataset.planet;
            if (!slug || slug === current) return;
            current = slug;
            updateActiveButton(current);
            animateSwap(current);
        });

        btn.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                btn.click();
            }
        });
    });

    if (current) {
        updateActiveButton(current);
    }
});
</script>
@endsection
