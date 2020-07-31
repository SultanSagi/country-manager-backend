<?php

namespace App\Console\Commands;

use App\Repositories\CountryRepository;
use App\Repositories\CsvCountryRepository;
use App\Repositories\JsonCountryRepository;
use App\Repositories\XmlCountryRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ConvertCountriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:countries {--input-file=} {--output-file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert countries from one format to another';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $inputFile = $this->option('input-file');
        $outputFile = $this->option('output-file');

        $file = public_path($inputFile);
        $extension = explode('.', $file)[1];
        $importRepository = CountryRepository::init($extension, $file);
        try {
            $data = $importRepository->convertToArray();
        }
        catch(\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }
        $exportRepository = CountryRepository::init(explode('.', $outputFile)[1], $file);
        try {
            $exportRepository->export($data, $outputFile);
        }
        catch(\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }
        $this->info('Convert countries is successfully completed!');
        return true;
    }
}
