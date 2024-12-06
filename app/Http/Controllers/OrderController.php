<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Inertia\Inertia;
use Session;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreOrdenRequest;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['table', 'details.menu'])->get();
        return inertia('Orders/Index', ['orders' => $orders]);
    }

    public function create()
    {
        // Obtener las mesas activas
        $activeTables = Table::where('status', 'available')->get();

        // Obtener alimentos y bebidas filtrados por tipo
        $foods = Menu::where('type', 'food')->get();
        $drinks = Menu::where('type', 'drink')->get();

        // Pasar los datos a la vista con Inertia
        return Inertia::render('Orders/Create', [
            'tables' => $activeTables,
            'foods' => $foods,
            'drinks' => $drinks
        ]);

    }

    public function store(StoreOrdenRequest $request)
    {
        // Crear el pedido principal
        $order = Order::create([
            'table_id' => $request['table_id'],
            'customer_name' => $request['customer_name'],
            'status' => 'pending',
            'comments' => $request['comments'] ?? null,
            'total' => 0, // Total se calculará a continuación
        ]);

        $total = 0;

        $combined = array_merge($request['foods'], $request['drinks']);
        // Crear los detalles del pedido
        foreach ($combined as $detail) {
            // Calcular subtotal basado en el precio del menú
            $menu = \App\Models\Menu::findOrFail($detail['item']);
            $subtotal = $menu->price * $detail['quantity'];

            OrderDetail::create([
                'order_id' => $order->id,
                'menu_id' => $detail['item'],
                'quantity' => $detail['quantity'],
                'subtotal' => $subtotal,
            ]);

            $total += $subtotal;
        }

        // Actualizar el total del pedido
        $order->update(['total' => $total]);

        // Actualizar el estado de la mesa a "occupied"
        $table = \App\Models\Table::findOrFail($request['table_id']);
        $table->update(['status' => 'occupied']);

        return redirect()->route('orders')->with('successful', 'Orden creada correctamente');
    }

    public function edit(Order $order)
    {
        // Cargar las mesas disponibles
        $tables = Table::all();

        // Cargar los items de menú disponibles
        $menuItems = Menu::all();

        // Cargar detalles de la orden existente
        $order->load(['details.menu', 'table']);

        return Inertia::render('Orders/Edit', [
            'order' => $order,
            'tables' => $tables,
            'menuItems' => $menuItems,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        // Actualizar la información básica de la orden
        $order->update([
            'table_id' => $request['table_id'],
            'customer_name' => $request['customer_name'],
            'comments' => $request['comments'] ?? '',
        ]);
    
        // Obtener los detalles existentes para actualizarlos o eliminarlos
        $existingDetails = $order->details()->get();
        $newDetails = collect();
    
        // Procesar los alimentos
        if (isset($request['foods'])) {
            foreach ($request['foods'] as $food) {
                $newDetails->push([
                    'menu_id' => $food['item'],
                    'quantity' => $food['quantity'],
                    'subtotal' => $this->calculateSubtotal($food['item'], $food['quantity']),
                ]);
            }
        }
    
        // Procesar las bebidas
        if (isset($request['drinks'])) {
            foreach ($request['drinks'] as $drink) {
                $newDetails->push([
                    'menu_id' => $drink['item'],
                    'quantity' => $drink['quantity'],
                    'subtotal' => $this->calculateSubtotal($drink['item'], $drink['quantity']),
                ]);
            }
        }
    
        // Actualizar detalles de la orden
        $existingDetails->each(function ($detail) use (&$newDetails) {
            $matchingDetail = $newDetails->firstWhere('menu_id', $detail->menu_id);
    
            if ($matchingDetail) {
                // Si existe en los nuevos detalles, actualizarlo
                $detail->update([
                    'quantity' => $matchingDetail['quantity'],
                    'subtotal' => $matchingDetail['subtotal'],
                ]);
    
                // Removerlo de los nuevos detalles ya procesados
                $newDetails = $newDetails->reject(fn ($item) => $item['menu_id'] === $detail->menu_id);
            } else {
                // Si no está en los nuevos detalles, eliminarlo
                $detail->delete();
            }
        });
    
        // Agregar los detalles restantes que no existían previamente
        $newDetails->each(fn ($detail) => $order->details()->create($detail));
    
        // Recalcular el total de la orden
        $total = $order->details()->sum('subtotal');
        $order->update(['total' => $total]);
    
        return redirect()->route('orders.index')->with('success', 'Orden actualizada exitosamente.');
    }
    

    // Método para calcular el subtotal
    protected function calculateSubtotal($menuId, $quantity)
    {
        $menu = Menu::findOrFail($menuId);
        return $menu->price * $quantity;
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        // Verificar si el estado es "completed" o "cancelled"
        if (in_array($request->status, ['completed', 'cancelled'])) {
            $table = \App\Models\Table::findOrFail($order->table_id);
            $table->update(['status' => 'available']); // Habilitar la mesa
        }

        return redirect()->route('orders.index')->with('success', 'Estado de la Orden actualizado exitosamente.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Orden eliminada exitosamente.');
    }


}
