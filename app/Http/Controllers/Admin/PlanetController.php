<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanetRequest;
use App\Models\Planet;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlanetController extends Controller
{
    /**
     * Ne garder que les colonnes qui existent vraiment dans la table planets.
     */
    private function keepExisting(array $data): array
    {
        $table = (new Planet())->getTable();

        return collect($data)
            ->filter(fn ($value, $key) => Schema::hasColumn($table, $key))
            ->all();
    }

    public function index()
    {
        $query = Planet::query();
        $table = (new Planet())->getTable();

        if (Schema::hasColumn($table, 'order')) {
            $query->orderBy('order');
        }

        $query->orderBy('id');

        $planets = $query->get();

        return view('admin.planets.index', compact('planets'));
    }

    public function create()
    {
        $planet = new Planet();

        return view('admin.planets.create', compact('planet'));
    }

    public function store(PlanetRequest $request)
    {
        $table = (new Planet())->getTable();
        $data  = $request->validated();

        // Slug auto si vide
        if (Schema::hasColumn($table, 'slug')) {
            $data['slug'] = $data['slug'] ?? Str::slug($data['name'] ?? '');
        }

        // Checkbox "Publié"
        if (Schema::hasColumn($table, 'published')) {
            $data['published'] = $request->boolean('published');
        }

        // Upload image vers storage/app/public/planets
        if ($request->hasFile('image') && Schema::hasColumn($table, 'image')) {
            // => planets/xxxx.png (dans le disk "public")
            $path = $request->file('image')->store('planets', 'public');
            $data['image'] = $path;
        }

        $data = $this->keepExisting($data);

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
        $table = $planet->getTable();
        $data  = $request->validated();

        // Slug auto si vide
        if (Schema::hasColumn($table, 'slug')) {
            $data['slug'] = $data['slug'] ?? Str::slug($data['name'] ?? $planet->name);
        }

        // Checkbox "Publié"
        if (Schema::hasColumn($table, 'published')) {
            $data['published'] = $request->boolean('published');
        }

        // Nouvelle image ?
        if ($request->hasFile('image') && Schema::hasColumn($table, 'image')) {

            // Supprimer l’ancienne image SI elle existe dans storage/app/public
            if ($planet->image && Storage::disk('public')->exists($planet->image)) {
                Storage::disk('public')->delete($planet->image);
            }

            // Stocker la nouvelle dans storage/app/public/planets
            $path = $request->file('image')->store('planets', 'public');
            $data['image'] = $path; // ex : "planets/xxxxxxxx.png"
        }

        $data = $this->keepExisting($data);

        $planet->update($data);

        return redirect()
            ->route('admin.planets.index')
            ->with('success', 'Planète mise à jour.');
    }

    public function destroy(Planet $planet)
    {
        // Suppression fichier si présent dans storage/app/public
        if ($planet->image && Storage::disk('public')->exists($planet->image)) {
            Storage::disk('public')->delete($planet->image);
        }

        $planet->delete();

        return back()->with('success', 'Planète supprimée.');
    }
}
