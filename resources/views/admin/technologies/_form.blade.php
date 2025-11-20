{{-- resources/views/admin/technologies/_form.blade.php --}}
@php
  /** @var \App\Models\Technology|null $technology */
  $isEdit = isset($technology) && $technology?->exists;
  $defaultPublished = $isEdit ? (bool) $technology->is_published : true;
  $isPublished = old('is_published', $defaultPublished);
@endphp

<form method="POST"
      action="{{ $action ?? ($isEdit ? route('admin.technologies.update', $technology) : route('admin.technologies.store')) }}"
      enctype="multipart/form-data"
      class="space-y-6">
  @csrf
  @if(($method ?? null) === 'PUT' || $isEdit)
    @method('PUT')
  @endif

  {{-- Nom + Slug --}}
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label for="name" class="block text-sm font-semibold">Nom *</label>
      <input
        id="name"
        name="name"
        type="text"
        value="{{ old('name', $technology->name ?? '') }}"
        class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
        required
      >
      @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="slug" class="block text-sm font-semibold">Slug</label>
      <input
        id="slug"
        name="slug"
        type="text"
        value="{{ old('slug', $technology->slug ?? '') }}"
        class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
        placeholder="launch-vehicle"
      >
      @error('slug') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>
  </div>

  {{-- Version française --}}
  <h2 class="text-lg font-semibold">Version française</h2>

  <div>
    <label for="description" class="block text-sm font-semibold">Description</label>
    <textarea
      id="description"
      name="description"
      rows="4"
      class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
    >{{ old('description', $technology->description ?? '') }}</textarea>
    @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
  </div>

  {{-- Version anglaise --}}
  <hr class="border-white/20">

  <h2 class="text-lg font-semibold">Version anglaise</h2>

  <div>
    <label for="description_en" class="block text-sm font-semibold">Description (EN)</label>
    <textarea
      id="description_en"
      name="description_en"
      rows="4"
      class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
    >{{ old('description_en', $technology->description_en ?? '') }}</textarea>
  </div>

  {{-- Divers --}}
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label for="website_url" class="block text-sm font-semibold">Site officiel</label>
      <input
        id="website_url"
        name="website_url"
        type="url"
        value="{{ old('website_url', $technology->website_url ?? '') }}"
        class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
      >
      @error('website_url') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="order" class="block text-sm font-semibold">Ordre</label>
      <input
        id="order"
        name="order"
        type="number"
        min="0"
        step="1"
        value="{{ old('order', $technology->order ?? 0) }}"
        class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
      >
      @error('order') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>
  </div>

  {{-- Image --}}
  <div>
    <label for="image" class="block text-sm font-semibold">Image (logo)</label>
    <input
      id="image"
      name="image"
      type="file"
      accept="image/*"
      class="w-full rounded border border-white/40 bg-transparent text-white px-3 py-2"
    >
    @error('image') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

    @if(!empty($technology?->image_path))
      <div class="mt-2">
        <p class="text-sm text-white/60">Image actuelle :</p>
        <img src="{{ asset('storage/'.$technology->image_path) }}" alt="Image" class="h-12 object-contain">
      </div>
    @endif
  </div>

  {{-- Publié ? --}}
  <div class="flex items-center gap-2">
    <input
      id="is_published"
      name="is_published"
      type="checkbox"
      value="1"
      class="h-4 w-4 rounded border border-white/60 bg-black accent-[#D0D6F9]"
      {{ $isPublished ? 'checked' : '' }}
    >
    <label for="is_published" class="text-sm font-semibold">Publié</label>
  </div>

  <div class="flex items-center gap-3">
    <button type="submit" class="px-4 py-2 rounded bg-[#D0D6F9] text-black">
      {{ $submitLabel ?? ($isEdit ? 'Mettre à jour' : 'Créer') }}
    </button>
    <a href="{{ route('admin.technologies.index') }}" class="px-4 py-2 rounded border border-white/30">
      Annuler
    </a>
  </div>
</form>
