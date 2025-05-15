<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cita;
use Carbon\Carbon;

class CitasActividadesSeeder extends Seeder
{
    public function run()
    {
        // Configuraciones para cada actividad: id => [duracion, aforo, frecuencia]
        $configuraciones = [
            1 => ['duracion' => 60, 'aforo' => 4, 'frecuencia' => 'una_vez'],
            3 => ['duracion' => 20, 'aforo' => 2, 'frecuencia' => 'una_vez'],
            4 => ['duracion' => 60, 'aforo' => 3, 'frecuencia' => 'una_vez'],
        ];

        // Definir los periodos de atención
        $periodos = [
            ['inicio' => '07:00', 'fin' => '13:00'],
            ['inicio' => '17:00', 'fin' => '21:00']
        ];

        // Periodo a generar: desde hoy hasta 5 años en el futuro
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addYears(5);

        // Recorrer cada actividad en las configuraciones
        foreach ($configuraciones as $activityId => $config) {
            $duration = $config['duracion'];
            $aforo = $config['aforo'];
            $frecuencia = $config['frecuencia'];

            // Recorrer día a día
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                // Considerar sólo días de lunes a viernes (1 = lunes, 5 = viernes)
                if ($date->dayOfWeekIso <= 5) {
                    foreach ($periodos as $periodo) {
                        $periodoInicio = Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d') . ' ' . $periodo['inicio']);
                        $periodoFin = Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d') . ' ' . $periodo['fin']);

                        // Mientras que haya tiempo suficiente para un bloque de duración $duration
                        for ($slot = $periodoInicio->copy(); $slot->lte($periodoFin->copy()->subMinutes($duration)); $slot->addMinutes($duration)) {
                            $horaInicio = $slot->format('H:i');
                            $hueco = $horaInicio . '-' . $slot->copy()->addMinutes($duration)->format('H:i');

                            Cita::create([
                                'fecha'       => $date->format('Y-m-d'),
                                'hueco'       => $hueco,
                                'aforo'       => $aforo,
                                'hora_inicio' => $horaInicio,
                                'duracion'    => $duration,
                                'frecuencia'  => $frecuencia,
                                'actividad_id'=> $activityId,
                            ]);
                        }
                    }
                }
            }
        }
    }
}