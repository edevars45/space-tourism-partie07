@extends('layouts.admin')
@section('title','Créer une technologie')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Créer une technologie</h1>

<form method="POST" action="{{ route('admin.technologies.store') }}" enctype="multipart/form-data">
  @csrf

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block mb-1">Nom *</label>
      <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 rounded">
    </div>
    <div>
      <label class="block mb-1">Slug</label>
      <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-3 py-2 rounded">
    </div>
    <div>
      <label class="block mb-1">Ordre</label>
      <input type="number" name="order" value="{{ old('order',1) }}" class="w-full px-3 py-2 rounded">
    </div>
    <div class="md:col-span-2">
      <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="published" value="1" {{ old('published') ? 'checked' : '' }}>
        <span>Publié</span>
      </label>
    </div>
    <div class="md:col-span-2">
      <label class="block mb-1">Description</label>
      <textarea name="description" rows="5" class="w-full px-3 py-2 rounded">{{ old('description') }}</textarea>
    </div>
    <div class="md:col-span-2">
      <label class="block mb-1">Site officiel (URL)</label>
      <input type="url" name="official_site" value="{{ old('official_site') }}" class="w-full px-3 py-2 rounded">
    </div>
    <div class="md:col-span-2">
      <label class="block mb-1">Image (logo)</label>
      <input type="file" name="image" class="w-full px-3 py-2 rounded">
    </div>
  </div>

  <div class="mt-6 flex gap-3">
    <button class="bg-[#D0D6F9] text-black px-4 py-2 rounded" type="submit">Enregistrer</button>
    <a href="{{ route('admin.technologies.index') }}" class="px-4 py-2 rounded border border-white/20">Annuler</a>
  </div>
</form>
@endsection
