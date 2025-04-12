<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kreis;
use App\Models\Bezirk;

class KreisSeeder extends Seeder
{
    public function run()
    {
        // load data & convert to php array
        $geojson = file_get_contents(database_path('data/kreis.geo.json'));
        $data = json_decode($geojson, true);

        foreach ($data['features'] as $feature) {
            $bezirkName = $feature['properties']['NAME_2'] ?? null;
            $kreisName = $feature['properties']['NAME_3'] ?? 'Unknown';

            // pass if no bezirk
            if (!$bezirkName) {
                continue;
            }

            // else, find the matching name in Bezirk table
            $bezirk = Bezirk::where('name', $bezirkName)->first();

            if (!$bezirk) {
                echo "Bezirk not found for Kreis: $kreisName (Parent: $bezirkName)\n";
                continue;
            }

            // create with the id of the bezirk found, if none exists already via firstOrCreate
            Kreis::firstOrCreate(
                [
                    'name' => $kreisName,
                    'bezirk_id' => $bezirk->id
                ],
                [
                    'geometry' => json_encode($feature['geometry'])
                ]
            );
            
        }
    }
}

