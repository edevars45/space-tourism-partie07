@extends('layouts.admin')
@section('title','Modifier un membre de l’équipage')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Modifier le membre</h1>

    <form method="POST" action="{{ route('admin.crew.update', $member) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.crew_members._form', ['member' => $member])
    </form>
@endsection
