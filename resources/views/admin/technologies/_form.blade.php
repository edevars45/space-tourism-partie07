{{-- resources/views/admin/technologies/_form.blade.php --}}

@php
    /** @var \App\Models\Technology|null $technology */

    // Sommes-nous en édition ?
    $isEdit = isset($technology) && $technology?->exists;

    // Valeur par défaut pour "Publié"
    // - en édition : on prend la valeur du modèle
    // - en création : par défaut = 1 (publié)
    $rawPublished = old(
        'is_published',
        $technology->is_published ?? $technology->published ?? 1
    );
    $publishedValue = (int) $rawPublished; // 0 ou 1
@endphp

{{--  IMPORTANT : ce partial NE contient PAS de <form>.
     Le <form> est dans create.blade.php et edit.blade.php --}}

{{-- Nom + Slug --}}
<div class="grid md:grid-cols-2 gap-4 mb-6">
    <div>
        <label for="name" class="block text-sm font-semibold mb-1">Nom *</label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $technology->name ?? '') }}"
            class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
            required
        >
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="slug" class="block text-sm font-semibold mb-1">Slug</label>
        <input
            id="slug"
            name="slug"
            type="text"
            value="{{ old('slug', $technology->slug ?? '') }}"
            class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
            placeholder="launch-vehicle"
        >
        @error('slug')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Version FR --}}
<h2 class="text-lg font-semibold mb-2">Version française</h2>

<div class="mb-4">
    <label for="description" class="block text-sm font-semibold mb-1">Description (FR)</label>
    <textarea
        id="description"
        name="description"
        rows="4"
        class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
    >{{ old('description', $technology->description ?? '') }}</textarea>
    @error('description')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<hr class="border-white/20 my-6">

{{-- Version EN --}}
<h2 class="text-lg font-semibold mb-2">Version anglaise</h2>

<div class="grid md:grid-cols-2 gap-4 mb-4">
    <div>
        <label for="name_en" class="block text-sm font-semibold mb-1">Nom (EN)</label>
        <input
            id="name_en"
            name="name_en"
            type="text"
            value="{{ old('name_en', $technology->name_en ?? '') }}"
            class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
        >
        @error('name_en')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mb-6">
    <label for="description_en" class="block text-sm font-semibold mb-1">Description (EN)</label>
    <textarea
        id="description_en"
        name="description_en"
        rows="4"
        class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
    >{{ old('description_en', $technology->description_en ?? '') }}</textarea>
    @error('description_en')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Divers : site + ordre --}}
<div class="grid md:grid-cols-2 gap-4 mb-6">
    <div>
        <label for="website_url" class="block text-sm font-semibold mb-1">Site officiel</label>
        <input
            id="website_url"
            name="website_url"
            type="url"
            value="{{ old('website_url', $technology->website_url ?? '') }}"
            class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
        >
        @error('website_url')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="order" class="block text-sm font-semibold mb-1">Ordre</label>
        <input
            id="order"
            name="order"
            type="number"
            min="0"
            step="1"
            value="{{ old('order', $technology->order ?? 0) }}"
            class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
        >
        @error('order')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Image --}}
<div class="mb-6">
    <label for="image" class="block text-sm font-semibold mb-1">Image (logo)</label>
    <input
        id="image"
        name="image"
        type="file"
        accept="image/*"
        class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
    >
    @error('image')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    @if(!empty($technology?->image_path))
        <div class="mt-2">
            <p class="text-sm text-white/60 mb-1">Image actuelle :</p>
            <img
                src="{{ asset('storage/'.$technology->image_path) }}"
                alt="Image de la technologie"
                class="h-16 object-contain border border-white/20 rounded"
            >
        </div>
    @endif
</div>

{{-- Publié : SELECT au lieu de checkbox --}}
<div class="mb-6">
    <label for="is_published" class="block text-sm font-semibold mb-1">Publié</label>
    <select
        id="is_published"
        name="is_published"
        class="w-40 rounded border border-white/40 bg-black text-white px-3 py-2"
    >
        <option value="1" {{ $publishedValue === 1 ? 'selected' : '' }}>Oui</option>
        <option value="0" {{ $publishedValue === 0 ? 'selected' : '' }}>Non</option>
    </select>
</div>

{{-- Boutons --}}
<div class="flex items-center gap-3">
    <button type="submit" class="px-4 py-2 rounded bg-[#D0D6F9] text-black font-semibold">
        {{ $submitLabel ?? ($isEdit ? 'Mettre à jour' : 'Créer') }}
    </button>
    <a href="{{ route('admin.technologies.index') }}" class="px-4 py-2 rounded border border-white/30">
        Annuler
    </a>
</div>
