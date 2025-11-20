{{-- resources/views/admin/technologies/edit.blade.php --}}
@extends('layouts.app') {{-- ou layouts.admin --}}

@section('title', 'Modifier une technologie')

@section('content')
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">
            Modifier la technologie : {{ $technology->name }}
        </h1>

        <form method="POST"
              action="{{ route('admin.technologies.update', $technology) }}"
              enctype="multipart/form-data">
            @method('PUT')

            @include('admin.technologies._form', [
                'technology' => $technology,
            ])
        </form>
    </div>
@endsection
