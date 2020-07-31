<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Resources\CountryResource;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return CountryResource::collection($countries);
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'country' => 'required',
            'capital' => 'required',
        ]);

        $country = Country::create($attr);

        return response()->json([
            'country' => new CountryResource($country)
        ], 201);
    }

    public function show(Country $country)
    {
        return new CountryResource($country);
    }

    public function update(Request $request, Country $country)
    {
        $attr = $request->validate([
            'country' => 'required',
            'capital' => 'required',
        ]);

        $country->update($attr);

        return new CountryResource($country);
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return response()->json([], 204);
    }
}
