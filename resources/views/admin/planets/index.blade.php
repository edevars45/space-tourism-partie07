@extends('layouts.admin')

@section('title','Planètes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Planètes</h1>
    @can('planets.manage')
        <a href="{{ route('admin.planets.create') }}" class="btn btn-primary">Nouvelle planète</a>
    @endcan
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Ordre</th>
                    <th>Publié</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($planets as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->slug }}</td>
                    <td>{{ $p->order }}</td>
                    <td>{{ $p->published ? 'Oui' : 'Non' }}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.planets.edit',$p) }}">Éditer</a>
                        <form action="{{ route('admin.planets.destroy',$p) }}" method="post" class="d-inline" onsubmit="return confirm('Supprimer ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-4">Aucune planète.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
