<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Bundesland;
use App\Models\Bezirk;
use App\Models\Kreis;

class SearchBundesland
{
    public function __invoke($_, array $args)
    {
        $name = strtolower($args['name']);  // the input name from schema - type Query we set earlier

        // Match Bezirk
        $bezirkBundeslandIds = Bezirk::whereRaw('LOWER(name) LIKE ?', ["%{$name}%"])
            ->pluck('bundesland_id');

        // Match Kreis
        $kreisBundeslandIds = Kreis::whereRaw('LOWER(name) LIKE ?', ["%{$name}%"])
            ->with('bezirk')
            ->get()
            ->pluck('bezirk.bundesland_id');

        $allBundeslandIds = $bezirkBundeslandIds->merge($kreisBundeslandIds)->unique();

        return Bundesland::whereIn('id', $allBundeslandIds)->get();
    }
}


// example usage
// query {
//    searchBundesland(name: "München") {
//      name
//    }
//  }
  

