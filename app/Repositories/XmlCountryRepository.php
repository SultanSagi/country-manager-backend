<?php


namespace App\Repositories;


use App\Country;
use App\Interfaces\CountryReaderInterface;

class XmlCountryRepository implements CountryReaderInterface
{
    private $file;

    public function __construct($file) {
        $this->file = $file;
    }

    public function import() {
        $rows = simplexml_load_file($this->file);
        foreach ($rows->element as $row) {
            Country::create([
                'country' => (string)$row->country,
                'capital' => (string)$row->capital
            ]);
        }
    }

    public function export($data)
    {
        $c = $data->toArray();

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
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="'.$this->file.'";');
        echo $sxe->asXML();
    }
}