<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Inertia\Inertia;
use Session;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreMenuRequest;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{   
    public function index()
    {
        $menuItems = Menu::paginate(10); // Cambia el número de ítems por página según sea necesario
        return inertia('Menus/Index', ['menuItems' => $menuItems]);
    }

    public function create()
    {
        return Inertia::render('Menus/Create');
    }

    public function edit($id)
    {
        $menu = Menu::find($id);
        return Inertia::render('Menus/Edit', [
            'menuItem' => $menu
        ]);
    }

    public function store(StoreMenuRequest $request)
    {
        $menu = Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'type' => $request->type
        ]);

        return redirect()->route('dashboard')->with('successful', 'Item de menu creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->type = $request->type;
        $menu->save();

        return redirect()->route('dashboard')->with('successful', 'Item de menu actualizado correctamente');
    }
}
