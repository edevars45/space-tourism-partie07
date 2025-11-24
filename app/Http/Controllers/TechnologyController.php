<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class TechnologyController extends Controller
{
    public function index()
    {
        $locale = App::getLocale();

        $table = (new Technology())->getTable();

        $query = Technology::query();

        // Filtrer sur publié si la colonne existe
        if (Schema::hasColumn($table, 'is_published')) {
            $query->where('is_published', true);
        }

        // Trier par "order" si dispo, puis par id
        if (Schema::hasColumn($table, 'order')) {
            $query->orderBy('order');
        }

        $query->orderBy('id');

        $rows = $query->get();

        // On construit un tableau propre pour la vue
        $techs = $rows->map(function (Technology $tech) use ($locale) {

            // FR / EN
            $name = $locale === 'en'
                ? ($tech->name_en ?: $tech->name)
                : $tech->name;

            $description = $locale === 'en'
                ? ($tech->description_en ?: $tech->description)
                : $tech->description;

            // Image : d’abord image_path (storage), sinon fallback images/technology/slug.jpg
            $image = null;

            if (!empty($tech->image_path)) {
                // stockée via disk "public" => storage/technologies/...
                $image = asset('storage/' . ltrim($tech->image_path, '/'));
            } elseif (!empty($tech->slug)) {
                // fallback vers les images d’origine
                $image = asset('images/technology/' . $tech->slug . '.jpg');
            }

            return [
                'slug'        => $tech->slug,
                'name'        => $name,
                'description' => $description,
                'image'       => $image,
            ];
        })->values()->all(); // tableau d’array simples

        return view('pages.technology', [
            'technologies' => $techs,
            'pageTitle'    => __('technology.title'),
            'heading'      => __('technology.heading'),
        ]);
    }
}
