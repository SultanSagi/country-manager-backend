<?php

namespace App\Http\Controllers;

use App\Country;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'required',
        ]);

        $countryRepository = CountryRepository::init($request->type, 'countries.'.$request->type);
        return $countryRepository->export(Country::select('country', 'capital')->get());
    }
}
