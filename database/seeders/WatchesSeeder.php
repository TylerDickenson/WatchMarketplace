<?php

namespace Database\Seeders;

use App\Models\Watch;
use Illuminate\Database\Seeder;

class WatchesSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = storage_path('app/Watches.csv');
        if (!file_exists($filePath)) {
            throw new \RuntimeException('Watches.csv not found.');
        }

        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            throw new \RuntimeException('Unable to open Watches.csv.');
        }

        $header = fgetcsv($handle, 0, ',', '"');
        if ($header === false) {
            fclose($handle);
            return;
        }

        $normalizedHeader = array_map(
            fn (string $col) => strtolower(str_replace([' ', '_'], '', trim($col))),
            $header
        );

        $rows = [];
        while (($data = fgetcsv($handle, 0, ',', '"')) !== false) {
            if ($data === [null] || $data === false) {
                continue;
            }

            $row = [];
            foreach ($normalizedHeader as $index => $key) {
                $row[$key] = isset($data[$index]) ? trim($data[$index]) : null;
            }

            $reference = $row['reference'] ?? null;
            $brand = $row['brand'] ?? null;

            if ($reference === null || $reference === '' || $brand === null || $brand === '') {
                continue;
            }

            $rows[] = [
                'brand'              => $brand,
                'family'             => $row['family'] ?? null,
                'model'              => $row['model'] ?? null,
                'reference'          => $reference,
                'movement_calibre'   => $row['movementcalibre'] ?? null,
                'movement_functions' => $row['movementfunctions'] ?? null,
                'limited'            => $row['limited'] ?? null,
                'case_material'      => $row['casematerial'] ?? null,
                'glass'              => $row['glass'] ?? null,
                'back'               => $row['back'] ?? null,
                'shape'              => $row['shape'] ?? null,
                'diameter'           => $row['diameter'] ?? null,
                'thickness'          => $row['thickness'] ?? null,
                'water_resistance'   => $row['waterresistance'] ?? null,
                'dial_colour'        => $row['dialcolour'] ?? null,
                'indexes'            => $row['indexes'] ?? null,
                'hands'              => $row['hands'] ?? null,
                'description'        => $row['description'] ?? null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ];

            if (count($rows) >= 500) {
                Watch::upsert($rows, ['reference']);
                $rows = [];
            }
        }

        if ($rows !== []) {
            Watch::upsert($rows, ['reference']);
        }

        fclose($handle);
    }
}