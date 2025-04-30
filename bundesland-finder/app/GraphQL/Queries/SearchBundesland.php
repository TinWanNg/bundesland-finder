<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Bundesland;
use App\Models\Bezirk;
use App\Models\Kreis;

class SearchBundesland
{
    public function __invoke($_, array $args)  // like constructor
    {
        $name = strtolower($args['name']);  // the input name from schema - type Query we set earlier

        // search for matching Bezirk, extract parent Bundesland and itself
        $bezirkMatches = Bezirk::whereRaw('LOWER(name) LIKE ?', ["%{$name}%"])
            ->with('bundesland')  // eager load parent Bundesland
            ->get()
            ->map(function ($bezirk) {
                return [
                    'bundesland_name' => $bezirk->bundesland->name,
                    'bezirk_name' => $bezirk->name,
                ];
            });

        // search for matching Kreis, extract parent Bezirk, its parent Bundesland, and itself
        $kreisMatches = Kreis::whereRaw('LOWER(name) LIKE ?', ["%{$name}%"])
            ->with('bezirk.bundesland')  // eager load parent Bezirk and its parent Bundesland
            ->get()
            ->map(function ($kreis) {
                return [
                    'bundesland_name' => $kreis->bezirk->bundesland->name,
                    'bezirk_name' => $kreis->bezirk->name,
                    'kreis_name' => $kreis->name,
                ];
            });
        
        // remember to return an array with keys matching those in graphql schema
        $response = [];
        foreach ($bezirkMatches as $bezirk) {
            $response[] = [
                'bundesland_name' => $bezirk['bundesland_name'],
                'bezirk_name' => $bezirk['bezirk_name']
            ];
        }

        foreach ($kreisMatches as $kreis) {
            $response[] = [
                'bundesland_name' => $kreis['bundesland_name'],
                'bezirk_name' => $kreis['bezirk_name'],
                'kreis_name' => $kreis['kreis_name']
            ];
        }
    
        return $response;
    }
}


// example usage
// query {
//    searchBundesland(name: "München") {
//      bundesland_name
//    }
//  }
  

