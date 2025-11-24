{{-- resources/views/admin/technologies/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Créer une technologie')

@section('content')
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">Créer une technologie</h1>

        <form method="POST"
              action="{{ route('admin.technologies.store') }}"
              enctype="multipart/form-data">
            @csrf

            @include('admin.technologies._form', [
                // au cas où le contrôleur n’envoie pas $technology
                'technology'  => $technology ?? new \App\Models\Technology(),
                'submitLabel' => 'Créer',
            ])
        </form>
    </div>
@endsection
