<?php


namespace App\Repositories;


use App\Country;
use App\Interfaces\CountryReaderInterface;
use Illuminate\Support\Facades\Storage;

class XmlCountryRepository implements CountryReaderInterface
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
        $rows = simplexml_load_file($this->file);
        $results = [];
        foreach ($rows->element as $row) {
            $data = [];
            $data['country'] = (string)$row->country;
            $data['capital'] = (string)$row->capital;
            $results[] = $data;
        }
        return $results;
    }

    public function export($data, $file=null)
    {
        $c = is_array($data) ? $data : $data->toArray();

        $xml = '<root>';
        foreach($c as $key => $country) {
            $xml .= '<element>
                <capital>'.$country["capital"].'</capital>
                <country>'.$country["country"].'</country>
            </element>';
        }
        $xml .= '</root>';
        $sxe = new \SimpleXMLElement($xml);
        $dom = new \DOMDocument('1,0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        if(!$file) {
            header('Content-type: text/xml');
            header('Content-Disposition: attachment; filename="' . $this->file . '";');
            echo $sxe->asXML();
        }
        else {
            Storage::disk('public')->put($file, $sxe->asXML());
        }
    }
}