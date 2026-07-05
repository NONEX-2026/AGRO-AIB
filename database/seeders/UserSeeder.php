<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'nombre'        => 'Bryhan Alonso Palomino Peña',
                'username'      => 'admin',
                'password'      => 'admin2026',
                'rol'           => 'Administrador',
                'estado'        => 'Activo',
                'ultimo_acceso' => '2026-01-15 08:30:00',
            ],
            [
                'nombre'        => 'Nexar Snayder Olaya Torres',
                'username'      => 'supervisor1',
                'password'      => 'super2026',
                'rol'           => 'Supervisor',
                'estado'        => 'Activo',
                'ultimo_acceso' => '2026-01-14 14:20:00',
            ],
            [
                'nombre'        => 'Jose Alberto Sotelo Mancha',
                'username'      => 'opagri1',
                'password'      => 'opera2026',
                'rol'           => 'Operario agrícola',
                'estado'        => 'Activo',
                'ultimo_acceso' => '2026-01-14 09:15:00',
            ],
            [
                'nombre'        => 'Breishman Avalos Arias',
                'username'      => 'opplanta1',
                'password'      => 'opera2026',
                'rol'           => 'Operario de planta',
                'estado'        => 'Activo',
                'ultimo_acceso' => '2026-01-13 16:45:00',
            ],
            [
                'nombre'        => 'Maria Elena Rojas Huaman',
                'username'      => 'empaque1',
                'password'      => 'empa2026',
                'rol'           => 'Empaquetador',
                'estado'        => 'Activo',
                'ultimo_acceso' => '2026-01-12 11:00:00',
            ],
            [
                'nombre'        => 'Carlos Fuentes Quispe',
                'username'      => 'transporte1',
                'password'      => 'trans2026',
                'rol'           => 'Transporte',
                'estado'        => 'Activo',
                'ultimo_acceso' => '2026-01-13 10:30:00',
            ],
        ];

        foreach ($usuarios as $usuario) {
            User::create([
                'nombre'        => $usuario['nombre'],
                'username'      => $usuario['username'],
                'password'      => $usuario['password'],
                'rol'           => $usuario['rol'],
                'estado'        => $usuario['estado'],
                'ultimo_acceso' => $usuario['ultimo_acceso'],
            ]);
        }

        $this->command->info('Se crearon ' . count($usuarios) . ' usuarios exitosamente.');
    }
}
