<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bundesland;

class BundeslandSeeder extends Seeder
{
    public function run()
    {
        $geojson = file_get_contents(database_path('data/bundesland.geo.json'));
        $data = json_decode($geojson, true);

        foreach ($data['features'] as $feature) {
            Bundesland::create([
                'name' => $feature['properties']['name'] ?? 'Unknown',  // note bundesland json has a diff structure than the others
                'geometry' => json_encode($feature['geometry']),
            ]);
        }
    }
}