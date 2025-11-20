{{-- resources/views/admin/technologies/create.blade.php --}}
@extends('layouts.app') {{-- ou layouts.admin, suivant ton projet --}}

@section('title', 'Créer une technologie')

@section('content')
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">Créer une technologie</h1>

        {{-- ICI le bloc avec le <form> et l’include --}}
        <form method="POST"
              action="{{ route('admin.technologies.store') }}"
              enctype="multipart/form-data">
            @include('admin.technologies._form', [
                // on passe un "nouveau" modèle au partial
                'technology' => $technology,
            ])
        </form>
    </div>
@endsection
