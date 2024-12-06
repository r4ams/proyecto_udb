<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Inertia\Inertia;
use Session;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        // Número de registros por página
        $perPage = 3;

        // Obtener reservaciones con paginación
        $reservations = Reservation::with('table')
            ->orderBy('reservation_date', 'asc') // Ordenar por fecha de reservación
            ->paginate($perPage);

        // Retornar datos a la vista
        return inertia('Reservations/Index', [
            'reservations' => $reservations,
        ]);
    }

    public function create()
    {
        // Obtener todas las mesas de la base de datos
        $tables = Table::where('status', 'available')->get();

        // Retornar la vista y pasar las mesas como prop
        return Inertia::render('Reservations/Create', [
            'tables' => $tables
        ]);
    }

    // Método para almacenar una nueva reserva
    public function store(StoreReservationRequest $request)
    {
        $table_capacity = Table::where('id', $request->table_id)->get();

        // Crear la nueva reserva
        $reservation = Reservation::create([
            'customer_name' => $request->customer_name,
            'table_id' => $request->table_id,
            'phone' => $request->phone,
            'reservation_date' => $request->reservation_date,
            'party_size' => $table_capacity[0]->capacity
        ]);

        // Actualizar el estado de la mesa a "occupied"
        $table = \App\Models\Table::findOrFail($request['table_id']);
        $table->update(['status' => 'reserved']);

        // Redirigir con éxito
        return redirect()->route('reservations.index')->with('success', 'Reserva creada correctamente');
    }

    public function edit(Reservation $reservation)
    {
        $tables = Table::all();
        return inertia('Reservations/Edit', ['reservation' => $reservation, 'tables' => $tables]);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'table_id' => 'required|exists:tables,id',
            'reservation_date' => 'required|date',
        ]);

        $reservation->update($validated);

        return redirect()->route('reservations.index')->with('success', 'Reservación actualizada exitosamente.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Reservación eliminada exitosamente.');
    }
}
