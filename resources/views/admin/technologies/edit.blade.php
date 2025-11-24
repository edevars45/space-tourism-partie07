@extends('layouts.admin')

@section('title', 'Modifier une technologie')

@section('content')
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">
            Modifier la technologie : {{ $technology->name }}
        </h1>

        <form method="POST"
              action="{{ route('admin.technologies.update', $technology) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.technologies._form', [
                'technology'   => $technology,
                'submitLabel'  => 'Mettre à jour',
            ])
        </form>
    </div>
@endsection
