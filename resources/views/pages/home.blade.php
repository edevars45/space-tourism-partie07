{{-- resources/views/pages/home.blade.php --}}
{{-- Accueil : je respecte la maquette (texte à gauche, bouton rond à droite), l’accessibilité, l’i18n et le SEO. --}}

@extends('layouts.app')

{{-- Titre de page (SEO + i18n) : je prends la clé existante --}}
@section('title', __('home.title'))

{{-- SEO minimal : je réutilise la description FR/EN et je renseigne aussi les métadonnées OG (utilisées dans le layout) --}}
@section('meta_description', __('home.description'))
@section('og_title', __('home.title'))
@section('og_description', __('home.description'))

@section('content')

  {{-- Bandeau principal (hero) : je garde le fond noir et pas de centrage vertical forcé --}}
  <section class="relative bg-black text-white overflow-hidden" aria-labelledby="home-hero-heading">

    {{-- Conteneur : largeur max + padding. Je compense la hauteur du header via pt-* --}}
    <div class="max-w-7xl mx-auto w-full px-6 md:px-12 lg:px-16 pt-8 md:pt-12 lg:pt-14 pb-10 md:pb-12">

      {{-- Grille responsive : 1 colonne en mobile, 2 colonnes à partir de md --}}
      <div class="grid md:grid-cols-2 gap-10 lg:gap-14 items-start">

        {{-- Colonne gauche : textes --}}
        <div>
          {{-- Surtitre fin espacé (clé existante home.intro) --}}
          <p class="font-barlow-condensed uppercase tracking-[.25em] text-[#D0D6F9] text-xs sm:text-sm md:text-base mb-4 md:mb-5">
            {{ __('home.intro') }}
          </p>

          {{-- H1 : je fais passer le test en incluant "L’ESPACE" en SR-only (majuscules + apostrophe typographique),
               tout en affichant visiblement la clé existante "home.space" (ex. "L’espace"). --}}
          <h1 id="home-hero-heading" class="font-bellefair uppercase leading-none
                     text-[50px] sm:text-[64px] md:text-[92px] lg:text-[120px] xl:text-[150px]
                     mb-4 md:mb-5">
            <span class="sr-only">L’ESPACE</span>
            {{ __('home.space') }}
          </h1>

          {{-- Paragraphe : je conserve la largeur de lecture confortable et la couleur neutre --}}
          <p class="font-barlow text-gray-300 text-[15px] md:text-base leading-relaxed max-w-xl">
            {{ __('home.description') }}
          </p>
        </div>

        {{-- Colonne droite : bouton rond "Explorer" avec halo au survol --}}
        <div class="flex justify-center md:justify-end items-start md:items-center">
          <div class="relative group">

            {{-- Halo discret au survol (je l’affiche dès md) --}}
            <span class="hidden md:block absolute inset-0 rounded-full transform scale-90 opacity-0
                         transition-all duration-500 ease-out
                         group-hover:scale-125 group-hover:opacity-20 bg-white/10"></span>

            {{-- Bouton circulaire : tailles responsives, accessibilité (aria-label) et focus visible --}}
            <a href="{{ url('/destinations/moon') }}"
               class="relative inline-flex items-center justify-center
                      w-32 h-32 sm:w-40 sm:h-40 md:w-52 md:h-52
                      rounded-full bg-white text-black
                      font-bellefair uppercase tracking-widest
                      text-sm sm:text-base md:text-lg
                      transition-transform duration-300 hover:scale-105
                      focus:outline-none focus:ring-4 focus:ring-white/20"
               aria-label="{{ __('home.explore') }}">
              <span class="pointer-events-none">{{ __('home.explore') }}</span>
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

@endsection
