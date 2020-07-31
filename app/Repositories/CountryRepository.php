<?php


namespace App\Repositories;


class CountryRepository
{
    public static function init($type, $file)
    {
        switch ($type) {
            case 'csv':
                $countryRepository = new CsvCountryRepository($file);
                break;
            case 'txt':
                $countryRepository = new CsvCountryRepository($file);
                break;
            case 'xml':
                $countryRepository = new XmlCountryRepository($file);
                break;
            case 'json':
                $countryRepository = new JsonCountryRepository($file);
                break;
            default:
                die('Incorrect type ' . $type);
        }
        return $countryRepository;
    }
}