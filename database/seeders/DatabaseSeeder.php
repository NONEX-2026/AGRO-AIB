<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecutar todos los seeders del proyecto.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LoteSeeder::class,
        ]);
    }
}
