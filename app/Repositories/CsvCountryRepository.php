<?php


namespace App\Repositories;


use App\Country;
use App\Interfaces\CountryReaderInterface;

class CsvCountryRepository implements CountryReaderInterface
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
        $rows = file($this->file);
        $results = [];
        for($i=1;$i<count($rows);$i++) {
            $values = array_map('trim', explode(',', $rows[$i]));
            $data = [];
            $data['country'] = $values[0];
            $data['capital'] = $values[1];
            $results[] = $data;
        }
        return $results;
    }

    public function export($data, $file=null)
    {
        $c = is_array($data) ? $data : $data->toArray();
        $delimiter = ',';
        $array = array_map(function($arr) {
            return array_values($arr);
        }, $c);
        $f = fopen($file ?? 'php://memory', 'w');
        foreach ($array as $line) {
            fputcsv($f, $line, $delimiter);
        }
        if(!$file) {
            fseek($f, 0);
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="' . $this->file . '";');
            fpassthru($f);
        }
    }
}