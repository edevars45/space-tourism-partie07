{{-- resources/views/admin/technologies/index.blade.php --}}

{{-- Liste des technologies (back-office) --}}
@extends('layouts.app')

@section('title', 'Technologies — Admin')

@section('content')

{{-- DEBUG TEMP – à retirer après test --}}
<!-- <div class="mb-4 text-xs text-gray-400">
    DB: {{ config('database.connections.sqlite.database') }} <br>
    Count: {{ \App\Models\Technology::count() }}
</div> -->

<section class="max-w-6xl mx-auto px-6 py-8">
    {{-- Titre + Bouton créer --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Technologies</h1>
        <a href="{{ route('admin.technologies.create') }}"
           class="inline-flex items-center px-4 py-2 rounded bg-white text-black hover:bg-gray-200">
            Nouvelle technologie
        </a>
    </div>

    {{-- Message flash succès --}}
    @if(session('success'))
        <div class="mb-4 rounded bg-green-600/20 text-green-200 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tableau des enregistrements --}}
    <div class="overflow-x-auto rounded border border-white/10">
        <table class="w-full min-w-[700px] text-left">
            <thead class="bg-white/5">
                <tr class="text-sm text-gray-300">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Nom</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3">Publié</th>
                    <th class="px-4 py-3">Ordre</th>
                    <th class="px-4 py-3">Modifié le</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/5">
                @forelse($items as $tech)
                    <tr class="text-sm">
                        <td class="px-4 py-3">{{ $tech->id }}</td>
                        <td class="px-4 py-3 font-medium">{{ $tech->name }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $tech->slug }}</td>
                        <td class="px-4 py-3">
                            @if($tech->is_published)
                                <span class="px-2 py-1 text-xs rounded bg-green-600/20 text-green-200">Oui</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded bg-red-600/20 text-red-200">Non</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $tech->order ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-400">
                            {{ optional($tech->updated_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2 justify-end">
                                <a href="{{ route('admin.technologies.edit', $tech) }}"
                                   class="px-3 py-1 rounded bg-white/10 hover:bg-white/20">Éditer</a>

                                {{-- Formulaire de suppression --}}
                                <form action="{{ route('admin.technologies.destroy', $tech) }}"
                                      method="POST"
                                      onsubmit="return confirm('Supprimer cette technologie ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 rounded bg-red-600/20 hover:bg-red-600/30">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-center text-gray-400" colspan="7">
                            Aucune technologie pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination : à placer sous le tableau --}}
    <div class="mt-6">
        {{ $items->links() }}
    </div>
</section>
@endsection
