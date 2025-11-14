@extends('layouts.admin')

@section('title', 'Éditer une technologie')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-8">
  <h1 class="text-2xl font-bold mb-6">Éditer : {{ $technology->name }}</h1>

  @include('admin.technologies._form', [
    'technology'  => $technology,
    'method'      => 'PUT',
    'submitLabel' => 'Mettre à jour'
  ])
</section>
@endsection
