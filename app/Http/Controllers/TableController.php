<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Inertia\Inertia;
use Session;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreTableRequest;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return inertia('Tables/Index', ['tables' => $tables]);
    }

    public function create()
    {
        return Inertia::render('Tables/Create');
    }

    public function store(StoreTableRequest $request)
    {
        $table = Table::create([
            'number' => $request->number,
            'capacity' => $request->capacity
        ]);

        return redirect()->route('dashboard')->with('successful', 'Mesa creada correctamente');
    }

    public function edit(Table $table)
    {
        return inertia('Tables/Edit', ['table' => $table]);
    }

    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'number' => 'required|integer|unique:tables,number,' . $table->id,
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,occupied,reserved'
        ]);

        $table->update($validated);

        return redirect()->route('tables.index')->with('success', 'Mesa actualizada exitosamente.');
    }

    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('tables.index')->with('success', 'Mesa eliminada exitosamente.');
    }
}
