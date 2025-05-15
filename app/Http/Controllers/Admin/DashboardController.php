<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cita;
use App\Models\Actividad;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Método para el dashboard (Google Calendar)
    public function index()
    {
        // Aquí puedes agregar cualquier lógica adicional para el calendario si es necesario
        return view('Admin.dashboardAdmin');
    }

    // Método para la vista de estadísticas
    public function estadisticas()
    {
        // Clientes por semana (ejemplo)
        $clientesPorSemana = User::select(DB::raw("WEEK(created_at, 1) as semana, count(*) as total"))
            ->where('is_admin', false)
            ->groupBy('semana')
            ->pluck('total', 'semana');

        // Reservas por semana: se unen reservas con citas y se agrupan por la semana de la fecha de la cita
        $reservasPorSemana = Reserva::join('citas', 'reservas.cita_id', '=', 'citas.id')
            ->select(DB::raw("WEEK(citas.fecha,1) as semana"), DB::raw("count(reservas.id) as total"))
            ->groupBy(DB::raw("WEEK(citas.fecha,1)"))
            ->pluck('total', 'semana'); 

        // Actividades activas
        $actividadesActivas = Actividad::where('activo', 1)->get();

        // Entrenadores destacados (máximo 6, puedes ajustar el criterio de selección)
        $entrenadores = \App\Models\Entrenador::orderByDesc('id')->take(6)->get(['nombre', 'especialidad', 'profile_photo_path']);

        return view('Admin.estadisticasAdmin', compact('clientesPorSemana', 'reservasPorSemana', 'actividadesActivas', 'entrenadores'));
    }
}
