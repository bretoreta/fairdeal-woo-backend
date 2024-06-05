<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PragmaRX\Countries\Package\Countries;

class CountriesController extends Controller
{
    private $countries;

    public function __construct() {
        $this->countries = new Countries();
    }

    public function index(Request $request)
    {
        if($request->query('query'))
        {
            return Cache::remember('search_countries'. $request->query('query'), 120, function() use ($request) {
                return $this->countries
                    ->sortBy('name.common')
                    ->filter(function($item) use ($request) {
                        return str_contains(strtolower($item->name->common), strtolower($request->query('query')));
                    })
                    ->pluck('name.common');
            });
        }
        else {
            return $this->countries->all()->pluck('name.common')->toArray();
        }
    }

    public function states(Request $request, $country)
    {
        if($request->query('query'))
        {
            return $this->countries
                    ->where('name.common', $country)
                    ->first()
                    ->hydrateStates()->states
                    ->sortBy('name')
                    ->filter(function($item) use ($request) {
                        return str_contains(strtolower($item->name), strtolower($request->query('query')));
                    })
                    ->pluck('name');
        }
        else {
            return $this->countries
                    ->where('name.common', $country)
                    ->first()
                    ->hydrateStates()->states
                    ->sortBy('name')
                    ->pluck('name');
        }
    }

    public function cities(Request $request, $country)
    {
        if($request->query('query'))
        {
            return $this->countries
                    ->where('name.common', $country)
                    ->first()
                    ->hydrate('cities')->cities
                    ->sortBy('name')
                    ->filter(function($item) use ($request) {
                        return str_contains(strtolower($item->name), strtolower($request->query('query')));
                    })
                    ->pluck('name');
        }
        else {
            return $this->countries
                    ->where('name.common', $country)
                    ->first()
                    ->hydrate('cities')->cities
                    ->sortBy('name')
                    ->pluck('name');
        }
    }
}
