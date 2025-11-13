@extends('layouts.admin')
@section('title','Modifier la planète')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Modifier la planète</h1>

    <form method="POST" action="{{ route('admin.planets.update', $planet) }}">
        @method('PUT')
        @include('admin.planets._form', ['planet' => $planet])
    </form>
@endsection
