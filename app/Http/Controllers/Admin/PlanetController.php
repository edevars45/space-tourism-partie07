<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanetRequest;
use App\Models\Planet;
use Illuminate\Support\Str;

class PlanetController extends Controller
{
    public function index()
    {
        // Tri stable : d'abord par order (croissant), puis par id
        $planets = Planet::query()
            ->orderBy('order')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.planets.index', compact('planets'));
    }

    public function create()
    {
        $planet = new Planet();
        return view('admin.planets.create', compact('planet'));
    }

    public function store(PlanetRequest $request)
    {
        $data = $request->validated();

        // slug auto si vide
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        // ordre par défaut
        $data['order'] = $data['order'] ?? 0;

        Planet::create($data);

        return redirect()
            ->route('admin.planets.index')
            ->with('success', 'Planète créée.');
    }

    public function edit(Planet $planet)
    {
        return view('admin.planets.edit', compact('planet'));
    }

    public function update(PlanetRequest $request, Planet $planet)
    {
        $data = $request->validated();

        // slug auto si vide
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        // ordre par défaut
        $data['order'] = $data['order'] ?? 0;

        $planet->update($data);

        return redirect()
            ->route('admin.planets.index')
            ->with('success', 'Planète mise à jour.');
    }

    public function destroy(Planet $planet)
    {
        $planet->delete();

        return back()->with('success', 'Planète supprimée.');
    }
}
