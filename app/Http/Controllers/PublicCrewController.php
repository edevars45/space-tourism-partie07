<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;   // C'EST ICI qu'on ajoute Schema
use App\Models\CrewMember;

class PublicCrewController extends Controller
{
    public function index(Request $request)
    {
        $members = [];

        // Langue actuelle : 'fr' ou 'en'
        $locale = App::getLocale();

        // --- Construction de la requête sur la BDD ---
        $query = CrewMember::query()
            ->where('is_published', true);

        // Nom réel de la table
        $table = (new CrewMember)->getTable();

        // On ne trie par "order" QUE si la colonne existe
        if (Schema::hasColumn($table, 'order')) {
            $query->orderBy('order');
        }

        // Tri de secours : toujours par id
        $query->orderBy('id');

        $rows = $query->get();

        if ($rows->isNotEmpty()) {
            foreach ($rows as $row) {

                // Normalisation du chemin de l'image
                $path = $row->image_path
                    ? str_replace('\\', '/', $row->image_path)
                    : null;

                // Textes FR / EN
                $role = $row->role;
                $bio  = $row->bio;

                if ($locale === 'en') {
                    $role = $row->role_en ?: $row->role;
                    $bio  = $row->bio_en  ?: $row->bio;
                }

                $alt = $locale === 'en'
                    ? 'Portrait of ' . $row->name
                    : 'Portrait de ' . $row->name;

                $members[] = [
                    'name'  => $row->name,
                    'role'  => $role,
                    'bio'   => $bio,
                    'image' => $path ? asset($path) : null,
                    'alt'   => $alt,
                    'slug'  => $row->slug,
                ];
            }
        } else {
            // Fallback fichiers de langue si la BDD est vide
            $trans = __('crew.members');

            if (is_array($trans) && !empty($trans)) {
                foreach ($trans as $slug => $m) {
                    $imagePath = Arr::get($m, 'image');

                    $members[] = [
                        'name'  => Arr::get($m, 'name', ''),
                        'role'  => Arr::get($m, 'role', ''),
                        'bio'   => Arr::get($m, 'bio', ''),
                        'image' => $imagePath ? asset($imagePath) : null,
                        'alt'   => Arr::get($m, 'alt', ''),
                        'slug'  => $slug,
                    ];
                }
            }
        }

        return view('pages.crew', [
            'members'   => $members,
            'pageTitle' => __('crew.title'),
            'heading'   => __('crew.heading'),
        ]);
    }
}
