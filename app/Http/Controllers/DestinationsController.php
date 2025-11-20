<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use Illuminate\Support\Facades\Schema;

class DestinationsController extends Controller
{
    /**
     * Page des destinations.
     *
     * @param  string|null  $slug  Slug de la planète courante (moon, mars, europa, titan, etc.)
     */
    public function index(?string $slug = null)
    {
        $planetModel = new Planet();
        $table = $planetModel->getTable();

        // 1) Préparation de la requête
        $query = Planet::query();

        // Colonne de publication : "published" ou "is_published"
        if (Schema::hasColumn($table, 'published')) {
            $query->where('published', true);
        } elseif (Schema::hasColumn($table, 'is_published')) {
            $query->where('is_published', true);
        }

        // Tri par "order" si la colonne existe, sinon par id
        if (Schema::hasColumn($table, 'order')) {
            $query->orderBy('order');
        } else {
            $query->orderBy('id');
        }

        // 2) Récupération de toutes les planètes publiées
        $planets = $query->get();

        // Si aucune planète : on envoie une vue vide
        if ($planets->isEmpty()) {
            return view('pages.destinations', [
                'planets' => collect(),
                'planet'  => null,
            ]);
        }

        // 3) Planète courante
        if ($slug) {
            // On essaye de trouver la planète correspondant au slug
            $planet = $planets->firstWhere('slug', $slug) ?? $planets->first();
        } else {
            // Pas de slug → première planète
            $planet = $planets->first();
        }

        // 4) Envoi à la vue
        return view('pages.destinations', [
            'planets' => $planets,   // collection de Planet
            'planet'  => $planet,    // planète courante
        ]);
    }
}
