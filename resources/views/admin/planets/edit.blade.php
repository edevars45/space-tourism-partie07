@extends('layouts.app')

@section('title', 'Modifier une planète')

@section('content')
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">
            Modifier la planète : {{ $planet->name }}
        </h1>

        <form method="POST" action="{{ route('admin.planets.update', $planet) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.planets._form', ['planet' => $planet])
        </form>

    </div>
@endsection
