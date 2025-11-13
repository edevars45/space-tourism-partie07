@php
    /** @var \App\Models\Planet $planet */
@endphp
@csrf

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm mb-1">Nom *</label>
        <input type="text" name="name" value="{{ old('name', $planet->name) }}"
               class="w-full rounded border px-3 py-2"
               required>
    </div>

    <div>
        <label class="block text-sm mb-1">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $planet->slug) }}"
               class="w-full rounded border px-3 py-2"
               placeholder="la-planete">
        <p class="text-xs text-white/60 mt-1">Laisse vide pour générer automatiquement.</p>
    </div>

    <div>
        <label class="block text-sm mb-1">Ordre</label>
        <input type="number" name="order" value="{{ old('order', $planet->order ?? 0) }}"
               class="w-full rounded border px-3 py-2" min="0" step="1">
    </div>

    <div class="flex items-center gap-2 mt-6">
        <input type="checkbox" id="published" name="published"
               value="1" @checked(old('published', (int)$planet->published))>
        <label for="published" class="text-sm">Publié</label>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm mb-1">Image (chemin)</label>
        <input type="text" name="image" value="{{ old('image', $planet->image) }}"
               class="w-full rounded border px-3 py-2" placeholder="planets/mars.png">
    </div>

    <div>
        <label class="block text-sm mb-1">Distance</label>
        <input type="text" name="distance" value="{{ old('distance', $planet->distance) }}"
               class="w-full rounded border px-3 py-2" placeholder="225 millions km">
    </div>

    <div>
        <label class="block text-sm mb-1">Temps de trajet</label>
        <input type="text" name="travel_time" value="{{ old('travel_time', $planet->travel_time) }}"
               class="w-full rounded border px-3 py-2" placeholder="9 mois">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm mb-1">Description</label>
        <textarea name="description" rows="5"
                  class="w-full rounded border px-3 py-2">{{ old('description', $planet->description) }}</textarea>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="bg-[#D0D6F9] text-black px-4 py-2 rounded" type="submit">Enregistrer</button>
    <a href="{{ route('admin.planets.index') }}" class="px-4 py-2 rounded border border-white/20">Annuler</a>
</div>
