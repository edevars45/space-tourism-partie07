<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    /** Ne conserver que les colonnes réellement présentes dans la table */
    private function filterToExistingColumns(string $table, array $row): array
    {
        return collect($row)->filter(fn ($_, $k) => Schema::hasColumn($table, $k))->all();
    }

    public function run(): void
    {
        $table = 'technologies';
        if (! Schema::hasTable($table)) {
            return; // la migration n'est pas là
        }

        // Charger le JSON
        $path = database_path('data/technologies.json');
        if (! file_exists($path)) {
            return;
        }
        $items = json_decode(file_get_contents($path), true) ?: [];

        $now = now();
        $rows = collect($items)->map(function ($row) use ($table, $now) {
            // slug auto si manquant
            if (!isset($row['slug']) && isset($row['name'])) {
                $row['slug'] = Str::slug($row['name']);
            }
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
            return $this->filterToExistingColumns($table, $row);
        })->all();

        if (empty($rows)) return;

        // upsert sur slug si présent, sinon name
        $uniqueBy = Schema::hasColumn($table, 'slug') ? ['slug'] : ['name'];
        DB::table($table)->upsert($rows, $uniqueBy);
    }
}
