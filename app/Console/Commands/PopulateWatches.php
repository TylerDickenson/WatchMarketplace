<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Watch;

#[Signature('app:populate-watches')]
#[Description('Command description')]
class PopulateWatches extends Command
{
    /**
     * Execute the console command.
     */
    protected $signature = 'inventory:import';
    protected $description = 'Populates the master watch catalog from CSV';


    public function handle()
    {
        $filePath = storage_path('watches.csv');    

        if (!file_exists($filePath)) {
            $this->error("CSV file not found at $filePath");
            return;
        }

        $file = fopen($filePath, 'r');
        fgetcsv($file); // Skip the header row

        $count = 0;
        $this->info('Populating watch catalog...');

        while (($data = fgetcsv($file)) !== false) {
            // This ONLY creates the master record if the reference doesn't exist
            Watch::firstOrCreate(
                ['reference' => $data[3]], 
                [
                    'brand'              => $data[0],
                    'family'             => $data[1],
                    'model'              => $data[2],
                    'movement_calibre'   => $data[4],
                    'movement_functions' => $data[5],
                    'limited'            => $data[6],
                    'case_material'      => $data[7],
                    'glass'              => $data[8],
                    'back'               => $data[9],
                    'shape'              => $data[10],
                    'diameter'           => $data[11],
                    'thickness'          => $data[12],
                    'water_resistance'   => $data[13],
                    'dial_colour'        => $data[14],
                    'indexes'            => $data[15],
                    'hands'              => $data[16],
                    'description'        => $data[17],
                ]
            );

            $count++;
        }

        fclose($file);
        $this->info("Done! {$count} unique models are now in your master catalog.");
    }
}
