<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PlanetsSeeder extends Seeder
{
    /** Garde uniquement les colonnes réellement présentes en base */
    private function filterToExistingColumns(string $table, array $row): array
    {
        return collect($row)->filter(fn ($_, $k) => Schema::hasColumn($table, $k))->all();
    }

    public function run(): void
    {
        $table = 'planets';
        if (!Schema::hasTable($table)) {
            return; // table absente, on sort proprement
        }

        // 1) Lire le JSON
        $path = base_path('database/data/planets.json');
        if (!is_file($path)) {
            $this->command?->warn("Fichier manquant: database/data/planets.json");
            return;
        }

        $raw = json_decode(file_get_contents($path), true);
        if (!is_array($raw)) {
            $this->command?->warn("JSON invalide: database/data/planets.json");
            return;
        }

        $now = now();

        // 2) Normaliser + timestamps + filtrage colonnes
        $rows = collect($raw)->map(function ($row) use ($table, $now) {
            $row = array_change_key_case($row, CASE_LOWER);

            // slug auto si manquant
            if ((!isset($row['slug']) || $row['slug'] === '') && !empty($row['name'])) {
                $row['slug'] = Str::slug($row['name']);
            }

            // published → bool/int
            if (isset($row['published'])) {
                $row['published'] = (bool)$row['published'];
            }

            $row['created_at'] = $now;
            $row['updated_at'] = $now;

            return $this->filterToExistingColumns($table, $row);
        })->filter()->values()->all();

        if (!$rows) {
            return;
        }

        // 3) Contrainte d’unicité utilisée pour l’upsert
        $uniqueBy = Schema::hasColumn($table, 'slug') ? ['slug'] : (Schema::hasColumn($table, 'name') ? ['name'] : []);

        // 4) Insert/Upsert
        if ($uniqueBy) {
            DB::table($table)->upsert($rows, $uniqueBy);
        } else {
            DB::table($table)->insert($rows);
        }

        $this->command?->info('PlanetsSeeder: données insérées/mises à jour.');
    }
}
