<?php

namespace App\Http\Controllers;

use App\Models\Organism;
use App\Models\Sample;
use App\Models\Crop;
use App\Models\Abundance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * Example of controller for the Challenge
 */
class BiomeController extends Controller
{


    /**
     * Returns a list of samples
     */
    public function listSamples(){

        return Sample::query()
            ->withCount('abundances')
            ->with('crop')
            ->get();
    }

    /**
     * Creates a new organism
     */
    public function newOrganism(Request $request) {
        $organismData = $request->validate([
            "genus" => "required|string",
            "species" => "required|string",
        ]);
        try {
            $organism = new Organism;
            $organism->genus = $organismData["genus"];
            $organism->species = $organismData["species"];
            $organism->save();
            return response()->json(['Organism Creates succesfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Not completed'], 400);
        }
    }

    /**
     * Returns a paginated list of organisms 
     */
    public function listOrganisms(){
        return Organism::paginate(10);
    }

    /**
     * Returns the top list of organisms
     */
    public function listOrganismsTop10(){
        return Organism::query()
        ->withCount('abundances')
        ->orderBy('abundances_count','DESC')
        ->limit(10)
        ->get();
    }

}
