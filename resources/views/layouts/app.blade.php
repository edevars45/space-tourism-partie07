{{-- resources/views/layouts/app.blade.php --}}
{{-- Layout principal : je respecte i18n, accessibilité, SEO/OG et l’intégration Vite --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Meta de base --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Je fournis le token CSRF pour les formulaires --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Titre : je privilégie la section "title" de la vue, sinon le nom de l’appli --}}
    <title>
        @hasSection('title')
            @yield('title') — {{ config('app.name', 'Space Tourism') }}
        @else
            {{ config('app.name', 'Space Tourism') }}
        @endif
    </title>

    {{-- ====== SEO / Open Graph ======
         Je laisse les vues définir:
         - @section('meta_description')
         - @section('og_title')
         - @section('og_description')
         Si elles ne sont pas définies, je retombe sur des valeurs par défaut (home.description / app.name).
    --}}
    {{-- SEO de base --}}
    <meta name="description" content="@yield('meta_description', __('home.description'))">
    {{-- Canonical : je pointe vers l’URL courante pour éviter le contenu dupliqué --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph (prévisualisations sociales) --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name', 'Space Tourism') }}">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title')) ?: config('app.name'))">
    <meta property="og:description" content="@yield('og_description', __('home.description'))">
    <meta property="og:url" content="{{ url()->current() }}">
    {{-- Je prévois une image OG par défaut ; je peux la remplacer page par page si besoin --}}
    <meta property="og:image" content="{{ asset('images/og-default.jpg') }}">

    {{-- Polices (je garde les familles définies par la maquette) --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=barlow:400,500,600|bellefair:400|barlow-condensed:400,500&display=swap"
        rel="stylesheet" />

    {{-- Assets Vite (CSS + JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Hook optionnel : si une page veut pousser du <head> spécifique, je le rends possible --}}
    @stack('head')
</head>

<body class="font-sans antialiased bg-black text-white">
    <div class="min-h-screen flex flex-col">

        {{-- Header de la maquette (logo + trait + navigation) : je le garde dans un composant dédié --}}
        <x-header />

        {{-- Contenu des pages : je laisse de la place sous le header fixe --}}
        <main class="flex-grow pt-20 md:pt-24">
            @yield('content')
            {{-- Je supporte aussi le slot si on utilise ce layout comme composant --}}
            {{ $slot ?? '' }}
        </main>

        {{-- Footer simple et neutre (contraste suffisant, taille lisible) --}}
        <footer class="bg-gray-900 text-gray-400 text-center py-6 text-sm">
            © {{ date('Y') }} {{ config('app.name', 'Space Tourism') }} | Projet Laravel Breeze
        </footer>
    </div>
</body>

</html>
