@php
    /** @var \App\Models\CrewMember $member */
@endphp
@csrf

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm mb-1">Nom *</label>
        <input type="text" name="name" value="{{ old('name', $member->name) }}"
               class="w-full rounded border px-3 py-2" required>
    </div>

    <div>
        <label class="block text-sm mb-1">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $member->slug) }}"
               class="w-full rounded border px-3 py-2" placeholder="douglas-hurley">
        <p class="text-xs text-white/60 mt-1">Laisse vide pour auto-générer.</p>
    </div>

    <div>
        <label class="block text-sm mb-1">Rôle *</label>
        <input type="text" name="role" value="{{ old('role', $member->role) }}"
               class="w-full rounded border px-3 py-2" required>
    </div>

    <div>
        <label class="block text-sm mb-1">Ordre</label>
        <input type="number" name="order" value="{{ old('order', $member->order ?? 0) }}"
               class="w-full rounded border px-3 py-2" min="0" step="1">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm mb-1">Biographie</label>
        <textarea name="bio" rows="5" class="w-full rounded border px-3 py-2">{{ old('bio', $member->bio) }}</textarea>
    </div>

    <div>
        <label class="block text-sm mb-1">Image (upload)</label>
        <input type="file" name="image" class="w-full rounded border px-3 py-2">
        @if($member->image_path)
            <p class="text-xs text-white/60 mt-1">Actuelle : <span class="underline">{{ $member->image_path }}</span></p>
        @endif
    </div>

    <div class="flex items-center gap-2 mt-6">
        <input type="checkbox" id="published" name="published"
               value="1" @checked(old('published', (int)$member->published))>
        <label for="published" class="text-sm">Publié</label>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="bg-[#D0D6F9] text-black px-4 py-2 rounded" type="submit">Enregistrer</button>
    <a href="{{ route('admin.crew.index') }}" class="px-4 py-2 rounded border border-white/20">Annuler</a>
</div>
