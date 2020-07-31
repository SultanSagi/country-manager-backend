<?php


namespace App\Interfaces;


interface CountryReaderInterface
{
    public function __construct($file);

    public function import();

    public function export($data);
}