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
        $rows = $this->convertToArray();
        foreach ($rows as $row) {
            Country::create([
                'country' => $row['country'],
                'capital' => $row['capital']
            ]);
        }
    }

    public function convertToArray() {
        $rows = file_get_contents($this->file);
        $data = json_decode($rows, true);
        $results = [];
        foreach($data as $country) {
            $data = [];
            $data['country'] = $country['country'];
            $data['capital'] = $country['capital'];
            $results[] = $data;
        }
        return $results;
    }

    public function export($data, $file=null)
    {
        $data = is_array($data) ? $data : $data->toArray();
        $fp = fopen($file ?? 'php://memory', 'w');
        fwrite($fp, json_encode($data));
        if(!$file) {
            fseek($fp, 0);
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="' . $this->file . '";');
            fpassthru($fp);
        }
    }
}