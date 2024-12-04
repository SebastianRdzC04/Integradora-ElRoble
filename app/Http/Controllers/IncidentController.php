<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Incident;
use App\Models\IncidentImage;
use Carbon\Carbon;
use App\Models\Inventory;
use App\Models\InventoryCategory;
use App\Models\SerialNumberType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class IncidentController extends Controller
{
    public function create()
    {
        return view('pages.inventory.report_incidents');
    }

    public function saveItems(Request $request)
    {
        // Validar el JSON que contiene los items
        $request->validate([
            'items' => 'required|array',
            'items.*.serial' => 'required|string|max:10',
            'items.*.number' => 'required|integer|min:0|max:9999999999',
            'items.*.description' => 'required|string|max:100',
            'items.*.status' => 'required|in:disponible,no disponible',
        ]);

        // Guardar los items en la sesión
        session()->put('validated_items', $request->input('items'));

        return response()->json([
            'success' => true,
            'message' => 'Items validados y guardados en sesión correctamente.'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titleincident' => 'required|string|max:100',
            'incidentdescription' => 'required|string|max:100',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:10240',
        ]);
        //campos del incidente global
        $title = $request->input('titleincident');
        $description = $request->input('incidentdescription');
        //estos son los objetos que afecto ese incidente ya estan validados asi que no deberia haber ningun error
        $items = session()->get('validated_items', []);
        //dia actual para ubicar el evento
        $currentDate = Carbon::now()->format('Y-m-d');
        $eventId = Event::whereDate('date', $currentDate)->value('id');

        if (!$eventId) {
            return redirect()->route('incident.create')->withErrors(['error' => 'No se encontró un evento para la fecha actual.']);
        }

        $userId = Auth::user()->getAuthIdentifier();

        $incident = Incident::create([
            'event_id' => $eventId,
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::transaction(function () use ($incident, $items, $request) {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('event_images', 's3');
                    // guardamos en el s3 de Amazon 
                    Storage::disk('s3')->setVisibility($path, 'public');

                    IncidentImage::create([
                        'incident_id' => $incident->id,
                        'image_path' => Storage::disk('s3')->url($path),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }

            if (!empty($items)) {
                foreach ($items as $item) {
                    $serialType = SerialNumberType::where('code', $item['serial'])->first();

                    if (!$serialType) {
                        throw new \Exception('El serial "' . $item['serial'] . '" no es válido.');
                    }

                    $inventory = Inventory::where('serial_number_type_id', $serialType->id)
                                          ->where('number', $item['number'])
                                          ->first();

                    if (!$inventory) {
                        throw new \Exception('El inventario con número "' . $item['number'] . '" no existe.');
                    }

                    $inventory->update([
                        'status' => $item['status']
                    ]);
                
                    $incident->inventories()->syncWithoutDetaching([
                        $inventory->id => [
                            'description' => $item['description'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]
                    ]);
                }
            }
        });

        Session::forget('validated_items');
        return redirect()->route('incident.create')->with('success', 'El incidente y las imágenes fueron registrados correctamente.');
    }

    public function filterDataIncidentReport(Request $request)
    {
        $categories = explode(",", $request->query('categories'));
        
        $seriales = SerialNumberType::whereIn('category_id', function ($query) use ($categories){
            $query->select('id')->from('inventory_categories')->whereIn('name', $categories);
        })->get(['code']);

        
        
        return response()->json($seriales);
    }

    public function getCategories()
    {
        $categories = InventoryCategory::all(['id', 'name']); 
        return response()->json($categories);
    }
}
