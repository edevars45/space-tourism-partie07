@extends('layouts.app')

@section('title', 'Créer une planète')

@section('content')
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">Créer une planète</h1>

        <form method="POST" action="{{ route('admin.planets.store') }}" enctype="multipart/form-data">
            @include('admin.planets._form', ['planet' => $planet])
        </form>

    </div>
@endsection
