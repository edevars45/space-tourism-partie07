<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use App\Models\Technology;   // 👈 modèle des technologies

class TechnologyController extends Controller
{
    public function index(Request $request)
    {
        $items  = [];
        $locale = App::getLocale();

        // --- Requête BDD ---
        $query = Technology::query()
            ->where('is_published', true);

        $table = (new Technology)->getTable();

        if (Schema::hasColumn($table, 'order')) {
            $query->orderBy('order');
        }

        $query->orderBy('id');

        $rows = $query->get();

        if ($rows->isNotEmpty()) {
            foreach ($rows as $row) {

                $name        = $row->name;
                $description = $row->description;

                if ($locale === 'en') {
                    $name        = $row->name_en        ?: $row->name;
                    $description = $row->description_en ?: $row->description;
                }

                // image_path ou image simple
                $path = $row->image_path
                    ? str_replace('\\', '/', $row->image_path)
                    : $row->image;

                $items[] = [
                    'name'        => $name,
                    'description' => $description,
                    'image'       => $path ? asset($path) : null,
                    'slug'        => $row->slug,
                ];
            }
        } else {
            // --- FALLBACK fichiers de langue (optionnel) ---
            $trans = __('technology.items');

            if (is_array($trans) && !empty($trans)) {
                foreach ($trans as $slug => $t) {
                    $items[] = [
                        'name'        => Arr::get($t, 'name', ''),
                        'description' => Arr::get($t, 'description', ''),
                        'image'       => Arr::get($t, 'image')
                            ? asset(Arr::get($t, 'image'))
                            : null,
                        'slug'        => $slug,
                    ];
                }
            }
        }

        return view('pages.technology', [
            'technologies' => $items,
            'pageTitle'    => __('technology.title'),
            'heading'      => __('technology.heading'),
        ]);
    }
}
