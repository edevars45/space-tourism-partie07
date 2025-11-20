@php
    /** @var \App\Models\Planet $planet */
    $isEdit = $planet->exists;

    $isPublished = old(
        'published',
        $isEdit ? (bool) $planet->published : true
    );

    // URL de prévisualisation de l’image en back-office
    $previewImage = $planet->image
        ? asset('storage/' . $planet->image)   // storage/planets/xxxx.png
        : null;
@endphp

@csrf

<div class="space-y-6">

    {{-- Nom FR + slug --}}
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Nom *</label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $planet->name) }}"
                class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
                required
            >
        </div>

        <div>
            <label class="block text-sm mb-1">Slug</label>
            <input
                type="text"
                name="slug"
                value="{{ old('slug', $planet->slug) }}"
                class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
                placeholder="moon"
            >
            <p class="text-xs text-white/50">Laisse vide pour générer automatiquement.</p>
        </div>
    </div>

    {{-- Ordre + publié --}}
    <div class="grid md:grid-cols-2 gap-4 items-center">
        <div>
            <label class="block text-sm mb-1">Ordre</label>
            <input
                type="number"
                name="order"
                value="{{ old('order', $planet->order ?? 1) }}"
                class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
                min="1"
            >
        </div>

        <div class="flex items-center gap-2 mt-6">
            <input
                type="checkbox"
                id="published"
                name="published"
                value="1"
                class="h-4 w-4 rounded border border-white/60 bg-black accent-[#D0D6F9]"
                {{ $isPublished ? 'checked' : '' }}
            >
            <label for="published" class="text-sm">Publié</label>
        </div>
    </div>

    {{-- Image --}}
    <div>
        <label class="block text-sm mb-1">Image (upload)</label>
        <input
            type="file"
            name="image"
            class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
            accept="image/*"
        >

        @if($previewImage)
            <p class="text-xs text-white/60 mt-1">
                Actuelle :
                <a href="{{ $previewImage }}" target="_blank" class="underline">
                    {{ $planet->image }}
                </a>
            </p>
            <div class="mt-2">
                <img src="{{ $previewImage }}" alt="{{ $planet->name }}" class="h-20 object-contain">
            </div>
        @endif
    </div>

    {{-- Version FR --}}
    <h2 class="text-lg font-semibold">Version française</h2>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Distance</label>
            <input
                type="text"
                name="distance"
                value="{{ old('distance', $planet->distance) }}"
                class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
                placeholder="384 400 km"
            >
        </div>

        <div>
            <label class="block text-sm mb-1">Temps de trajet</label>
            <input
                type="text"
                name="travel_time"
                value="{{ old('travel_time', $planet->travel_time) }}"
                class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
                placeholder="3 jours"
            >
        </div>
    </div>

    <div>
        <label class="block text-sm mb-1">Description</label>
        <textarea
            name="description"
            rows="5"
            class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
        >{{ old('description', $planet->description) }}</textarea>
    </div>

    {{-- Version EN --}}
    <hr class="border-white/20 my-6">

    <h2 class="text-lg font-semibold">Version anglaise</h2>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Nom (EN)</label>
            <input
                type="text"
                name="name_en"
                value="{{ old('name_en', $planet->name_en) }}"
                class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
            >
        </div>
    </div>

    <div>
        <label class="block text-sm mb-1">Description (EN)</label>
        <textarea
            name="description_en"
            rows="5"
            class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
        >{{ old('description_en', $planet->description_en) }}</textarea>
    </div>

    <div class="mt-6 flex gap-3">
        <button class="bg-[#D0D6F9] text-black px-4 py-2 rounded" type="submit">
            Enregistrer
        </button>
        <a href="{{ route('admin.planets.index') }}"
           class="px-4 py-2 rounded border border-white/20">
            Annuler
        </a>
    </div>
</div>
