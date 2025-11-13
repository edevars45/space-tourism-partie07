@extends('layouts.admin')
@section('title','Créer une planète')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Créer une planète</h1>

    <form method="POST" action="{{ route('admin.planets.store') }}">
        @include('admin.planets._form', ['planet' => $planet])
    </form>
@endsection
