<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bezirk;
use App\Models\Bundesland;

class BezirkSeeder extends Seeder
{
    public function run()
    {
        // load data & convert to php array
        $geojson = file_get_contents(database_path('data/bezirk.geo.json'));
        $data = json_decode($geojson, true);

        foreach ($data['features'] as $feature) {
            $bundeslandName = $feature['properties']['NAME_1'] ?? null;
            $bezirkName = $feature['properties']['NAME_2'] ?? 'Unknown';

            // pass if no bundesland
            if (!$bundeslandName) {
                continue;
            }

            // else, find the matching name in Bundesland table
            $bundesland = Bundesland::where('name', $bundeslandName)->first();

            if (!$bundesland) {
                echo "Bundesland not found for Bezirk: $bezirkName (Parent: $bundeslandName)\n";
                continue;
            }

            // create with the id of the bundesland found, if none exists already via firstOrCreate
            Bezirk::firstOrCreate(
                [
                    'name' => $bezirkName,
                    'bundesland_id' => $bundesland->id
                ],
                [
                    'geometry' => json_encode($feature['geometry'])
                ]
            );
            
        }
    }
}