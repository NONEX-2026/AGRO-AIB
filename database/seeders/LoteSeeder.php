<?php

namespace Database\Seeders;

use App\Models\Lote;
use App\Models\Trazabilidad;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder de lotes y sus trazabilidades.
 * Crea 8 lotes con datos realistas de Agroindustrias AIB.
 */
class LoteSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de lotes.
     */
    public function run(): void
    {
        // Obtener IDs de usuarios para las relaciones
        $admin     = User::where('username', 'admin')->first()->id;
        $super1    = User::where('username', 'supervisor1')->first()->id;
        $oper1     = User::where('username', 'operario1')->first()->id;
        $oper2     = User::where('username', 'operario2')->first()->id;
        $calidad   = User::where('username', 'calidad1')->first()->id;

        $lotesData = [
            [
                'codigo' => 'LOT-2026-001',
                'producto' => 'Esparrago',
                'variedad' => 'Verde',
                'cantidad_kg' => 5200,
                'etapa_actual' => 'Exportacion',
                'estado' => 'Completado',
                'proveedor' => 'Agropecuaria San Jose S.A.C.',
                'observaciones' => 'Lote exportado a Estados Unidos',
                'registrado_por' => $oper1,
                'historial' => [
                    ['etapa' => 'Cultivo', 'fecha' => '2025-09-10', 'obs' => 'Siembra en campo de Ica, parcela 3', 'resp' => $oper1],
                    ['etapa' => 'Recepcion', 'fecha' => '2025-11-15', 'obs' => 'Recepcion en planta, control fitosanitario aprobado', 'resp' => $calidad],
                    ['etapa' => 'Procesamiento', 'fecha' => '2025-11-20', 'obs' => 'Corte, seleccion y clasificacion por calibres', 'resp' => $oper2],
                    ['etapa' => 'Empaque', 'fecha' => '2025-12-01', 'obs' => 'Empaque en bolsas de 500g, etiquetado', 'resp' => $oper1],
                    ['etapa' => 'Almacenamiento', 'fecha' => '2025-12-05', 'obs' => 'Almacenamiento en camara fria a 2°C', 'resp' => $super1],
                    ['etapa' => 'Exportacion', 'fecha' => '2026-01-08', 'obs' => 'Despacho al puerto del Callao - destino EE.UU.', 'resp' => $admin],
                ],
            ],
            [
                'codigo' => 'LOT-2026-002',
                'producto' => 'Palta',
                'variedad' => 'Hass',
                'cantidad_kg' => 8500,
                'etapa_actual' => 'Almacenamiento',
                'estado' => 'En Proceso',
                'proveedor' => 'Hass Peru Export SAC',
                'observaciones' => 'Almacenado en camara fria esperando embarque',
                'registrado_por' => $oper2,
                'historial' => [
                    ['etapa' => 'Cultivo', 'fecha' => '2025-10-05', 'obs' => 'Cosecha en fundo Los Libertadores', 'resp' => $oper2],
                    ['etapa' => 'Recepcion', 'fecha' => '2025-12-10', 'obs' => 'Ingreso a planta, revision de madurez', 'resp' => $calidad],
                    ['etapa' => 'Procesamiento', 'fecha' => '2025-12-15', 'obs' => 'Seleccion por tamano, eliminacion de defectuosos', 'resp' => $oper1],
                    ['etapa' => 'Empaque', 'fecha' => '2025-12-22', 'obs' => 'Empaque en cajas de 4kg con guata protectora', 'resp' => $oper2],
                    ['etapa' => 'Almacenamiento', 'fecha' => '2025-12-28', 'obs' => 'Camara fria a 5°C, humedad controlada 90%', 'resp' => $super1],
                ],
            ],
            [
                'codigo' => 'LOT-2026-003',
                'producto' => 'Mango',
                'variedad' => 'Kent',
                'cantidad_kg' => 12000,
                'etapa_actual' => 'Procesamiento',
                'estado' => 'En Proceso',
                'proveedor' => 'Mango del Sur E.I.R.L.',
                'observaciones' => 'En linea de procesamiento',
                'registrado_por' => $oper1,
                'historial' => [
                    ['etapa' => 'Cultivo', 'fecha' => '2025-11-01', 'obs' => 'Cosecha en fundo San Juan, Ica', 'resp' => $oper1],
                    ['etapa' => 'Recepcion', 'fecha' => '2026-01-05', 'obs' => 'Recepcion y pesaje, control de madurez', 'resp' => $calidad],
                    ['etapa' => 'Procesamiento', 'fecha' => '2026-01-10', 'obs' => 'Lavado, desinfeccion, pelado y corte', 'resp' => $oper2],
                ],
            ],
            [
                'codigo' => 'LOT-2026-004',
                'producto' => 'Uva',
                'variedad' => 'Red Globe',
                'cantidad_kg' => 6800,
                'etapa_actual' => 'Empaque',
                'estado' => 'En Proceso',
                'proveedor' => 'Vinedos de Ica S.A.',
                'observaciones' => 'Proceso de empaque en curso',
                'registrado_por' => $oper2,
                'historial' => [
                    ['etapa' => 'Cultivo', 'fecha' => '2025-10-20', 'obs' => 'Cosecha manual en parcela 7', 'resp' => $oper2],
                    ['etapa' => 'Recepcion', 'fecha' => '2025-12-18', 'obs' => 'Recepcion, prueba de residuos aprobada', 'resp' => $calidad],
                    ['etapa' => 'Procesamiento', 'fecha' => '2025-12-22', 'obs' => 'Despalillado, clasificacion por calibre', 'resp' => $oper1],
                    ['etapa' => 'Empaque', 'fecha' => '2026-01-12', 'obs' => 'Empaque en bolsas con SO2, cajas de 8.2kg', 'resp' => $oper2],
                ],
            ],
            [
                'codigo' => 'LOT-2026-005',
                'producto' => 'Arandano',
                'variedad' => 'Biloxi',
                'cantidad_kg' => 3200,
                'etapa_actual' => 'Recepcion',
                'estado' => 'En Proceso',
                'proveedor' => 'Berries del Pacifico SAC',
                'observaciones' => 'Recien ingresado a planta',
                'registrado_por' => $oper1,
                'historial' => [
                    ['etapa' => 'Cultivo', 'fecha' => '2026-01-02', 'obs' => 'Cosecha en invernadero, fundo La Campana', 'resp' => $oper1],
                    ['etapa' => 'Recepcion', 'fecha' => '2026-01-14', 'obs' => 'Ingreso a planta, control de calidad pendiente', 'resp' => $calidad],
                ],
            ],
            [
                'codigo' => 'LOT-2026-006',
                'producto' => 'Paprika',
                'variedad' => 'Dubai',
                'cantidad_kg' => 4500,
                'etapa_actual' => 'Cultivo',
                'estado' => 'En Proceso',
                'proveedor' => 'Agricola La Joya S.A.C.',
                'observaciones' => 'En etapa de cultivo, estimado cosecha marzo',
                'registrado_por' => $oper2,
                'historial' => [
                    ['etapa' => 'Cultivo', 'fecha' => '2026-01-10', 'obs' => 'Siembra en campo de La Joya, riego por goteo instalado', 'resp' => $oper2],
                ],
            ],
            [
                'codigo' => 'LOT-2026-007',
                'producto' => 'Esparrago',
                'variedad' => 'Blanco',
                'cantidad_kg' => 7100,
                'etapa_actual' => 'Procesamiento',
                'estado' => 'En Proceso',
                'proveedor' => 'Agropecuaria San Jose S.A.C.',
                'observaciones' => 'Procesamiento de esparrago blanco',
                'registrado_por' => $oper1,
                'historial' => [
                    ['etapa' => 'Cultivo', 'fecha' => '2025-08-15', 'obs' => 'Cultivo bajo tierra, fundo San Jose', 'resp' => $oper1],
                    ['etapa' => 'Recepcion', 'fecha' => '2025-10-20', 'obs' => 'Recepcion en planta, control de blancura', 'resp' => $calidad],
                    ['etapa' => 'Procesamiento', 'fecha' => '2025-10-25', 'obs' => 'Corte, pelado y clasificacion', 'resp' => $oper2],
                ],
            ],
            [
                'codigo' => 'LOT-2026-008',
                'producto' => 'Aceituna',
                'variedad' => 'Sevillana',
                'cantidad_kg' => 9200,
                'etapa_actual' => 'Recepcion',
                'estado' => 'En Proceso',
                'proveedor' => 'Olivos de Ica E.I.R.L.',
                'observaciones' => 'Aceitunas recien recibidas',
                'registrado_por' => $oper2,
                'historial' => [
                    ['etapa' => 'Cultivo', 'fecha' => '2026-01-08', 'obs' => 'Cosecha en olivar de Subtanjalla', 'resp' => $oper2],
                    ['etapa' => 'Recepcion', 'fecha' => '2026-01-14', 'obs' => 'Clasificacion por tamano y estado de madurez', 'resp' => $calidad],
                ],
            ],
        ];

        foreach ($lotesData as $data) {
            // Crear el lote
            $lote = Lote::create([
                'codigo'        => $data['codigo'],
                'producto'      => $data['producto'],
                'variedad'      => $data['variedad'],
                'cantidad_kg'   => $data['cantidad_kg'],
                'etapa_actual'  => $data['etapa_actual'],
                'proveedor'     => $data['proveedor'],
                'estado'        => $data['estado'],
                'observaciones' => $data['observaciones'],
                'registrado_por' => $data['registrado_por'],
                'created_at'    => $data['historial'][0]['fecha'] . ' 08:00:00',
            ]);

            // Crear los registros de trazabilidad
            foreach ($data['historial'] as $h) {
                Trazabilidad::create([
                    'lote_id'       => $lote->id,
                    'etapa'         => $h['etapa'],
                    'fecha'         => $h['fecha'],
                    'observaciones' => $h['obs'],
                    'responsable_id' => $h['resp'],
                    'created_at'    => $h['fecha'] . ' 08:00:00',
                ]);
            }
        }

        $this->command->info('Se crearon ' . count($lotesData) . ' lotes con sus trazabilidades.');
    }
}
