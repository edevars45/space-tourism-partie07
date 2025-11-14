<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TechnologyRequest;
use App\Models\Technology;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TechnologyController extends Controller
{
    // Liste paginée
    public function index()
    {
        $items = Technology::latest()->paginate(12);
        return view('admin.technologies.index', compact('items'));
    }

    // Formulaire de création
    public function create()
    {
        return view('admin.technologies.create', [
            'technology' => new Technology(),
        ]);
    }

    // Enregistrement
    public function store(TechnologyRequest $request)
    {
        $data = $request->validated();

        // Slug
        $data['slug'] = !empty($data['slug'])
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);

        // Image
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('technologies', 'public');
        }

        // Publication par défaut
        $data['is_published'] = (bool)($data['is_published'] ?? true);

        Technology::create($data);

        return redirect()
            ->route('admin.technologies.index')
            ->with('success', 'Technologie créée.');
    }

    // Formulaire d’édition
    public function edit(Technology $technology)
    {
        // ⚠️ Vue dans le dossier "technologies" (pluriel)
        return view('admin.technologies.edit', compact('technology'));
    }

    // Mise à jour
    public function update(TechnologyRequest $request, Technology $technology)
    {
        $data = $request->validated();

        // Slug
        $data['slug'] = !empty($data['slug'])
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);

        // Image
        if ($request->hasFile('image')) {
            if ($technology->image_path) {
                Storage::disk('public')->delete($technology->image_path);
            }
            $data['image_path'] = $request->file('image')->store('technologies', 'public');
        }

        // Conserver la publication si non envoyé
        $data['is_published'] = (bool)($data['is_published'] ?? $technology->is_published);

        $technology->update($data);

        return redirect()
            ->route('admin.technologies.index')
            ->with('success', 'Technologie mise à jour.');
    }

    // Suppression
    public function destroy(Technology $technology)
    {
        if ($technology->image_path) {
            Storage::disk('public')->delete($technology->image_path);
        }

        $technology->delete();

        return redirect()
            ->route('admin.technologies.index')
            ->with('success', 'Technologie supprimée.');
    }
}
