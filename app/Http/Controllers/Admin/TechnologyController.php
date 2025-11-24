<?php

namespace App\Http\Controllers\Admin;   // "Admin" ici

use App\Http\Controllers\Controller;
use App\Http\Requests\TechnologyRequest;
use App\Models\Technology;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TechnologyController extends Controller
{
    /**
     * Ne garder que les colonnes qui existent vraiment dans la table technologies.
     */
    private function keepExisting(array $data): array
    {
        $table = (new Technology())->getTable();

        return collect($data)
            ->filter(fn ($value, $key) => Schema::hasColumn($table, $key))
            ->all();
    }

    /**
     * Liste des technologies (back-office).
     */
    public function index()
    {
        $table = (new Technology())->getTable();
        $query = Technology::query();

        // Tri par "order" si la colonne existe
        if (Schema::hasColumn($table, 'order')) {
            $query->orderBy('order');
        }

        // Tri de secours
        $query->orderBy('id');

        $technologies = $query->get();

        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        $technology = new Technology();

        return view('admin.technologies.create', compact('technology'));
    }

    /**
     * Enregistrement d’une nouvelle technologie.
     */
    public function store(TechnologyRequest $request)
    {
        $table = (new Technology())->getTable();
        $data  = $request->validated();

        // Slug auto si vide
        if (Schema::hasColumn($table, 'slug')) {
            $data['slug'] = $data['slug'] ?? Str::slug($data['name'] ?? '');
        }

        // Checkbox "Publié"
        if (Schema::hasColumn($table, 'is_published')) {
            $data['is_published'] = $request->boolean('is_published');
        }

        // Upload image -> storage/app/public/technologies
        if ($request->hasFile('image') && Schema::hasColumn($table, 'image_path')) {
            $path = $request->file('image')->store('technologies', 'public'); // ex : technologies/xxx.jpg
            $data['image_path'] = $path;
        }

        $data = $this->keepExisting($data);

        Technology::create($data);

        return redirect()
            ->route('admin.technologies.index')
            ->with('success', 'Technologie créée.');
    }

    /**
     * Formulaire d’édition.
     */
    public function edit(Technology $technology)
    {
        return view('admin.technologies.edit', compact('technology'));
    }

    /**
     * Mise à jour d’une technologie existante.
     */
    public function update(TechnologyRequest $request, Technology $technology)
    {
        $table = $technology->getTable();
        $data  = $request->validated();

        // Slug auto si vide
        if (Schema::hasColumn($table, 'slug')) {
            $data['slug'] = $data['slug'] ?? Str::slug($data['name'] ?? $technology->name);
        }

        // Checkbox "Publié"
        if (Schema::hasColumn($table, 'is_published')) {
            $data['is_published'] = $request->boolean('is_published');
        }

        // Nouvelle image ?
        if ($request->hasFile('image') && Schema::hasColumn($table, 'image_path')) {

            // Supprimer l’ancienne dans storage/app/public/technologies
            if ($technology->image_path && Storage::disk('public')->exists($technology->image_path)) {
                Storage::disk('public')->delete($technology->image_path);
            }

            // Stocker la nouvelle
            $path = $request->file('image')->store('technologies', 'public');
            $data['image_path'] = $path;
        }

        $data = $this->keepExisting($data);

        $technology->update($data);

        return redirect()
            ->route('admin.technologies.index')
            ->with('success', 'Technologie mise à jour.');
    }

    /**
     * Suppression d’une technologie.
     */
    public function destroy(Technology $technology)
    {
        if ($technology->image_path && Storage::disk('public')->exists($technology->image_path)) {
            Storage::disk('public')->delete($technology->image_path);
        }

        $technology->delete();

        return back()->with('success', 'Technologie supprimée.');
    }
}
