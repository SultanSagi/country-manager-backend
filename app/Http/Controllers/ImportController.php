<?php

namespace App\Http\Controllers;

use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    protected $usedExtensions = ['xml', 'txt', 'csv', 'json'];
    protected $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function store(Request $request)
    {
    	$request->validate([
    	    'file' => 'required'
        ]);
    	$extension = explode(".", $request->file->getClientOriginalName())[1];

    	if(!in_array($extension, $this->usedExtensions)) {
    	    return response()->json('Extension not supported to import', 422);
        }

        $countryRepository = CountryRepository::init($extension, $request->file('file'));
    	$countryRepository->import();
    }
}
