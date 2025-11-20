<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrewMemberRequest;
use App\Models\CrewMember;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CrewMemberController extends Controller
{
    /**
     * Ne garder que les colonnes qui existent vraiment dans la table crew_members.
     */
    private function keepExisting(array $data): array
    {
        $table = (new CrewMember())->getTable();

        return collect($data)
            ->filter(fn ($value, $key) => Schema::hasColumn($table, $key))
            ->all();
    }

    /**
     * Liste des membres.
     */
    public function index()
    {
        $table = (new CrewMember())->getTable();

        $query = CrewMember::query();

        if (Schema::hasColumn($table, 'order')) {
            $query->orderBy('order');
        } else {
            $query->orderBy('name');
        }

        $members = $query->paginate(12);

        return view('admin.crew_members.index', compact('members'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        $member = new CrewMember();

        return view('admin.crew_members.create', compact('member'));
    }

    /**
     * Enregistrement d’un nouveau membre.
     */
    public function store(CrewMemberRequest $request)
    {
        $table = (new CrewMember())->getTable();
        $data  = $request->validated();

        // Slug automatique si colonne présente
        if (Schema::hasColumn($table, 'slug')) {
            $data['slug'] = $data['slug'] ?? Str::slug($data['name'] ?? '');
        }

        // Checkbox "Publié" -> is_published (bool)
        if (Schema::hasColumn($table, 'is_published')) {
            $data['is_published'] = $request->boolean('is_published');
        }

        // Upload d'image vers public/images/crew et stockage du chemin relatif en BDD
        if ($request->hasFile('image') && Schema::hasColumn($table, 'image_path')) {
            $file = $request->file('image');

            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Fichier physique
            $file->move(public_path('images/crew'), $filename);

            // Chemin utilisé avec asset()
            $data['image_path'] = 'images/crew/' . $filename;
        }

        $data = $this->keepExisting($data);

        CrewMember::create($data);

        return redirect()
            ->route('admin.crew.index')
            ->with('success', 'Membre créé.');
    }

    /**
     * Formulaire d’édition.
     */
    public function edit(CrewMember $crew)
    {
        $member = $crew;

        return view('admin.crew_members.edit', compact('member'));
    }

    /**
     * Mise à jour d’un membre.
     */
    public function update(CrewMemberRequest $request, CrewMember $crew)
    {
        $table = $crew->getTable();
        $data  = $request->validated();

        // Slug automatique si vide
        if (Schema::hasColumn($table, 'slug')) {
            $data['slug'] = $data['slug'] ?? Str::slug($data['name'] ?? $crew->name);
        }

        // Checkbox "Publié"
        if (Schema::hasColumn($table, 'is_published')) {
            $data['is_published'] = $request->boolean('is_published');
        }

        // Nouvelle image uploadée ?
        if ($request->hasFile('image') && Schema::hasColumn($table, 'image_path')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Supprimer l’ancienne image si elle existe
            if ($crew->image_path && file_exists(public_path($crew->image_path))) {
                @unlink(public_path($crew->image_path));
            }

            // Stocker la nouvelle
            $file->move(public_path('images/crew'), $filename);

            $data['image_path'] = 'images/crew/' . $filename;
        }

        $data = $this->keepExisting($data);

        $crew->update($data);

        return redirect()
            ->route('admin.crew.index')
            ->with('success', 'Membre mis à jour.');
    }

    /**
     * Suppression d’un membre.
     */
    public function destroy(CrewMember $crew)
    {
        // Suppression éventuelle du fichier image
        if ($crew->image_path && file_exists(public_path($crew->image_path))) {
            @unlink(public_path($crew->image_path));
        }

        $crew->delete();

        return back()->with('success', 'Membre supprimé.');
    }
}
