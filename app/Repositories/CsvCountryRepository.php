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
        $rows = file($this->file);
        for($i=1;$i<count($rows);$i++) {
            $values = array_map('trim', explode(',', $rows[$i]));
            Country::create([
                'country' => $values[0],
                'capital' => $values[1]
            ]);
        }
    }

    public function export($data)
    {
        $c = $data->toArray();
        $delimiter = ',';
        $array = array_map(function($arr) {
            return array_values($arr);
        }, $c);
        $f = fopen('php://memory', 'w');
        foreach ($array as $line) {
            fputcsv($f, $line, $delimiter);
        }
        fseek($f, 0);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$this->file.'";');
        fpassthru($f);
    }
}