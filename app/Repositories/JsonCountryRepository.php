<?php


namespace App\Repositories;


use App\Country;
use App\Interfaces\CountryReaderInterface;

class JsonCountryRepository implements CountryReaderInterface
{
    private $file;

    public function __construct($file) {
        $this->file = $file;
    }

    public function import() {
        $rows = file_get_contents($this->file);
        $data = json_decode($rows, true);
        foreach($data as $country) {
            Country::create([
                'country' => $country['country'],
                'capital' => $country['capital']
            ]);
        }
    }

    public function export($data)
    {
        $fp = fopen('php://memory', 'w');
        fwrite($fp, json_encode($data));
        fseek($fp, 0);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$this->file.'";');
        fpassthru($fp);
    }
}