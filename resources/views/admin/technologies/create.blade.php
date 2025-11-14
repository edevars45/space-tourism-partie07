@extends('layouts.admin')

@section('title', 'Créer une technologie')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-8">
  <h1 class="text-2xl font-bold mb-6">Créer une technologie</h1>

  @include('admin.technologies._form', [
    'technology'  => new \App\Models\Technology(),
    'submitLabel' => 'Créer'
  ])
</section>
@endsection
