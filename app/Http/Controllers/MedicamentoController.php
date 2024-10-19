<?php

namespace App\Http\Controllers;

use App\Models\Apartado;
use App\Models\ApartadoItem;
use App\Models\Farmacia;
use App\Models\Inventario;
use App\Models\Medicamento;
use App\Models\UserAddress;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class MedicamentoController extends Controller
{
    //verificar esta función


    public function index()
    {
        $medicamentos = Medicamento::all();
        $farmacias = Farmacia::all();
        //return view('user.home', compact('medicamentos'));
        return view('user.busqueda', compact('medicamentos', 'farmacias'));
    }

    //para la búsqueda con filtros de medicamentos
    public function search(Request $request)
    {
        $filters = $request->only(['farmacia', 'categoria', 'price_min', 'price_max', 'ubicacion', 'distance', 'address_id']);
        $searchText = $request->input('text');

        // Obtener la ubicación del usuario desde la base de datos
        $userAddress = DB::select("
            SELECT ST_Y(location) AS latitud, ST_X(location) AS longitud
            FROM user_addresses
            WHERE id = ?
        ", [$filters['address_id'] ?? null]);

        // Verificar si la dirección del usuario fue encontrada
        if (empty($userAddress)) {
            return redirect()->back()->withErrors('Dirección no encontrada.');
        }

        $userLat = $userAddress[0]->latitud;   // Latitud del usuario
        $userLng = $userAddress[0]->longitud;  // Longitud del usuario

        // Asegurarse de que la distancia es un número válido y convertirla a metros
        $distanceRange = ($filters['distance'] ?? 0) * 1000;  // Multiplicamos por 1000 para convertir a metros

        // Consulta para buscar farmacias dentro del rango de distancia
        $farmacias = DB::select("
            SELECT id_farmacia, nombre_razon_social, rif,
                ST_X(ubicacion) AS latitud,
                ST_Y(ubicacion) AS longitud,
                ST_Distance_Sphere(ubicacion, POINT(?, ?)) AS distance
            FROM farmacias
            HAVING distance <= ?
            ORDER BY distance ASC
        ", [$userLng, $userLat, $distanceRange]);

        // Redondear la distancia a kilómetros para mostrar en la vista
        foreach ($farmacias as $farmacia) {
            $farmacia->distance = round($farmacia->distance / 1000, 2); // Convertir de metros a kilómetros
        }

        // Consulta para obtener medicamentos basados en los filtros aplicados
        $medicamentosQuery = DB::table('medicamentos')
        ->join('farmacias', 'medicamentos.id_farmacia', '=', 'farmacias.id_farmacia')
        ->select('medicamentos.*', 'farmacias.nombre_razon_social', 'farmacias.ubicacion',
            DB::raw("ST_Distance_Sphere(farmacias.ubicacion, POINT($userLng, $userLat)) AS distance"))
        ->when($searchText, function ($query) use ($searchText) {
            return $query->where('medicamentos.nombre', 'like', '%' . $searchText . '%');
        })
        ->when(isset($filters['farmacia']), function ($query) use ($filters) {
            return $query->where('medicamentos.id_farmacia', $filters['farmacia']);
        })
        ->when(isset($filters['price_min']), function ($query) use ($filters) {
            return $query->where('medicamentos.precio', '>=', $filters['price_min']);
        })
        ->when(isset($filters['price_max']), function ($query) use ($filters) {
            return $query->where('medicamentos.precio', '<=', $filters['price_max']);
        })
        ->having('distance', '<=', $distanceRange)  // Filtro de distancia
        ->orderBy('distance', 'ASC');


        // Si se encontraron farmacias, aplicamos los filtros correspondientes a medicamentos
        if (count($farmacias) > 0) {
            $farmaciaIds = collect($farmacias)->pluck('id_farmacia')->toArray();
            $medicamentosQuery->whereIn('medicamentos.id_farmacia', $farmaciaIds);
        }

        // Ejecutar la consulta para obtener los medicamentos
        $medicamentos = $medicamentosQuery->get();

        // Redondear la distancia de los medicamentos a kilómetros (si no se ha hecho)
        foreach ($medicamentos as $medicamento) {
            $medicamento->distance = round($medicamento->distance / 1000, 2); // Convertir de metros a kilómetros
        }

        // Construir la cadena de la consulta para mostrar en la vista
        $searchQuery = "Resultados de la búsqueda de ";
        if (!empty($searchText)) {
            $searchQuery .= "el medicamento '{$searchText}', ";
        }
        if (!empty($filters['farmacia'])) {
            $searchQuery .= "la farmacia '{$filters['farmacia']}', ";
        }
        if (!empty($filters['categoria'])) {
            $searchQuery .= "la categoría '{$filters['categoria']}', ";
        }
        if (!empty($filters['price_min'])) {
            $searchQuery .= "precio mínimo de {$filters['price_min']}, ";
        }
        if (!empty($filters['price_max'])) {
            $searchQuery .= "precio máximo de {$filters['price_max']}, ";
        }
        if (!empty($filters['distance'])) {
            $searchQuery .= "distancia máxima de {$filters['distance']} km, ";
        }
        if (!empty($filters['address_id'])) {
            $searchQuery .= "dirección ID '{$filters['address_id']}', ";
        }
        $searchQuery = rtrim($searchQuery, ', ');

        // Obtener el carrito de compras si existe
        $carrito = session('carrito', []);  // Obtener el carrito de compras
        $totalItems = array_sum($carrito);  // Obtener la cantidad total de ítems en el carrito

        // Retornar la vista con los resultados
        return view('user.busqueda', compact('medicamentos', 'filters', 'farmacias', 'searchQuery', 'totalItems'));
    }


    public function carrito()
    {
        $carrito = session('carrito', []);

        // Log para verificar la estructura del carrito recuperado de la sesión
        Log::info('Estructura del carrito recuperado de la sesión:', ['carrito' => $carrito]);

        // Verificar que $carrito sea un array
        if (!is_array($carrito)) {
            Log::error('El carrito no es un array.', ['carrito' => $carrito]);
            $carrito = []; // Inicializar como array vacío para evitar errores
        }

        $medicamentos = Medicamento::whereIn('id_medicamento', array_keys($carrito))->get();

        // Verificar la estructura de los medicamentos recuperados
        Log::info('Medicamentos recuperados:', $medicamentos->toArray());

        // Construir detalles del carrito con validación
        $carritoDetalles = $medicamentos->mapWithKeys(function($medicamento) use ($carrito) {
            $item = $carrito[$medicamento->id_medicamento] ?? null;

            // Verificar que $item sea un array
            if (!is_array($item)) {
                Log::error('El ítem del carrito no es un array o falta.', ['id_medicamento' => $medicamento->id_medicamento, 'item' => $item]);
                $item = []; // Inicializar como array vacío para evitar errores
            }

            return [
                $medicamento->id_medicamento => [
                    'nombre' => $medicamento->nombre,
                    'precio' => $medicamento->precio,
                    'cantidad' => $item['cantidad'] ?? 0, // Asegúrate de que 'cantidad' esté definida
                    'image_path' => $medicamento->image_path ?? 'placeholder',
                ],
            ];
        });

        // Calcular el total de items
        $totalItems = array_sum(array_column($carritoDetalles->toArray(), 'cantidad'));

        return view('user.carrito', [
            'carrito' => $carritoDetalles,
            'totalItems' => $totalItems,
        ]);
    }

    // agregar medicamentos al carrito
    public function agregarCarrito(Request $request)
    {
        try {
            $request->validate([
                'id_medicamento' => 'required|integer',
                'cantidad' => 'required|integer|min:1',
            ]);

            $idMedicamento = $request->input('id_medicamento');
            $cantidad = (int)$request->input('cantidad');

            $medicamento = Medicamento::findOrFail($idMedicamento);
            $idFarmacia = $medicamento->id_farmacia;

            $carrito = Session::get('carrito', []);

            // Verificar el formato del carrito
            if (!is_array($carrito)) {
                Log::error('El carrito en la sesión no es un array.', ['carrito' => $carrito]);
                $carrito = [];
            }

            // Verificar el formato del ítem
            if (isset($carrito[$idMedicamento]) && is_array($carrito[$idMedicamento])) {
                $carrito[$idMedicamento]['cantidad'] += $cantidad;
            } else {
                $carrito[$idMedicamento] = [
                    'id_medicamento' => $idMedicamento,
                    'id_farmacia' => $idFarmacia,
                    'nombre' => $medicamento->nombre,
                    'precio' => (float)$medicamento->precio,
                    'cantidad' => $cantidad,
                    'image_path' => $medicamento->image_path ?? 'placeholder'
                ];
            }

            Session::put('carrito', $carrito);

            $totalItems = array_sum(array_column($carrito, 'cantidad'));

            return response()->json(['status' => 'Producto agregado al carrito', 'totalItems' => $totalItems]);
        } catch (\Exception $e) {
            Log::error('Error al agregar al carrito: ' . $e->getMessage());

            return response()->json(['status' => 'Error al agregar al carrito', 'error' => $e->getMessage()], 500);
        }
    }

    // actualiza cantidad en la vista de carrito para los botones
    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $cantidad = $request->input('cantidad');
        $carrito = session()->get('carrito', []);

        // Verifica que $carrito[$id] sea un array antes de acceder a sus elementos
        if (isset($carrito[$id]) && is_array($carrito[$id])) {
            $carrito[$id]['cantidad'] = $cantidad;
            session()->put('carrito', $carrito);

            $totalItems = array_sum(array_column($carrito, 'cantidad'));

            return response()->json(['success' => true, 'totalItems' => $totalItems]);
        }

        return response()->json(['success' => false, 'message' => 'Item no encontrado en el carrito'], 404);
    }



    // eliminar items del carrito
    public function destroy($id)
    {
        $carrito = session()->get('carrito', []);

        if (array_key_exists($id, $carrito)) {
            unset($carrito[$id]);

            session()->put('carrito', $carrito);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    //realizar apartado
    public function realizarApartado(Request $request)
    {
        try {
            $carrito = Session::get('carrito', []);
            $userId = auth()->id();

            // Verificar si el carrito está vacío
            if (empty($carrito)) {
                return redirect()->back()->with('error', 'El carrito está vacío.');
            }

            // Agrupar medicamentos por farmacia
            $apartadosPorFarmacia = [];
            foreach ($carrito as $item) {
                $idFarmacia = $item['id_farmacia'];
                if (!isset($apartadosPorFarmacia[$idFarmacia])) {
                    $apartadosPorFarmacia[$idFarmacia] = [];
                }
                $apartadosPorFarmacia[$idFarmacia][] = $item;
            }

            // Procesar cada apartado por farmacia
            foreach ($apartadosPorFarmacia as $idFarmacia => $items) {
                // Crear el apartado con la fecha actual
                $apartado = Apartado::create([
                    'id_usuario' => $userId,
                    'id_farmacia' => $idFarmacia,
                    'estado' => 'pendiente',
                    'fecha' => now(),
                    'fecha_expiracion' => now()->addHours(24),
                ]);

                // Procesar cada ítem en el apartado
                foreach ($items as $item) {
                    $cantidadNecesaria = $item['cantidad'];

                    // Obtener los lotes disponibles del medicamento, ordenados por fecha de vencimiento más cercana
                    $lotes = Inventario::where('id_medicamento', $item['id_medicamento'])
                        ->where('id_farmacia', $idFarmacia)
                        ->where('cantidad_disponible', '>', 0)
                        ->orderBy('fecha_vencimiento', 'asc')
                        ->get();

                    foreach ($lotes as $lote) {
                        if ($cantidadNecesaria <= 0) {
                            break; // Salir si ya se ha satisfecho la cantidad necesaria
                        }

                        if ($lote->cantidad_disponible >= $cantidadNecesaria) {
                            // Si el lote tiene suficiente cantidad
                            $lote->cantidad_disponible -= $cantidadNecesaria;
                            $cantidadNecesaria = 0; // Se ha satisfecho la cantidad necesaria
                        } else {
                            // Si el lote no tiene suficiente cantidad
                            $cantidadNecesaria -= $lote->cantidad_disponible;
                            $lote->cantidad_disponible = 0; // Agotar el lote
                        }

                        // Guardar los cambios en el inventario
                        $lote->save();

                        // Crear el item del apartado asociado al lote usado
                        try {
                            ApartadoItem::create([
                                'id_apartado' => $apartado->id,
                                'id_medicamento' => $item['id_medicamento'],
                                'cantidad' => $item['cantidad'], // Mantener la cantidad total pedida
                                'precio' => $item['precio'],
                                'numero_lote' => $lote->numero_lote, // Guardar el número de lote
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Error al crear ApartadoItem: ' . $e->getMessage());
                        }
                    }

                    // Si no se pudo satisfacer la cantidad necesaria, lanzar una excepción
                    if ($cantidadNecesaria > 0) {
                        throw new \Exception('No hay suficiente inventario disponible para cubrir la cantidad solicitada.');
                    }
                }
            }

            // Vaciar el carrito después de realizar los apartados
            Session::forget('carrito');

            return redirect()->route('user.home')->with('success', 'Apartados realizados con éxito');
        } catch (\Exception $e) {
            Log::error('Error al realizar el apartado: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function cancelar($id)
    {
        try {
            // Buscar el apartado por ID
            $apartado = Apartado::with('detalles')->findOrFail($id);

            // Cambiar el estado a 'cancelado'
            $apartado->estado = 'cancelado';
            $apartado->save();

            // Devolver los ítems del apartado al inventario
            foreach ($apartado->detalles as $item) {
                // Buscar el lote correspondiente
                $lote = Inventario::where('id_medicamento', $item->id_medicamento)
                    ->where('id_farmacia', $apartado->id_farmacia)
                    ->where('numero_lote', $item->numero_lote) // Asegúrate de que estás usando el campo correcto para identificar el lote
                    ->first();

                // Registro para verificar si se encontró el lote
                if ($lote) {
                    Log::info("Lote encontrado: ", [
                        'numero_lote' => $lote->numero_lote,
                        'cantidad_disponible' => $lote->cantidad_disponible,
                        'cantidad_a_devolver' => $item->cantidad,
                    ]);

                    // Aumentar la cantidad disponible en el lote
                    $lote->cantidad_disponible += $item->cantidad;
                    $lote->save(); // Guardar los cambios en el inventario

                    Log::info("Cantidad devuelta al lote: ", [
                        'nuevo_cantidad_disponible' => $lote->cantidad_disponible,
                    ]);
                } else {
                    Log::warning("No se encontró lote para el medicamento: ", [
                        'id_medicamento' => $item->id_medicamento,
                        'id_farmacia' => $apartado->id_farmacia,
                        'numero_lote' => $item->numero_lote,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Apartado cancelado y medicamentos devueltos al inventario con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al cancelar el apartado: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'No se pudo cancelar el apartado.']);
        }
    }

    public function mostrar()
    {
        try {
            // Recuperar todos los apartados del usuario autenticado con la relación de detalles
            $apartados = Apartado::with('detalles')->where('id_usuario', auth()->id())->get();

            $carrito = Session::get('carrito', []);
            $totalItems = array_sum(array_column($carrito, 'cantidad'));

            return view('user.apartado', ['apartados' => $apartados, 'totalItems' => $totalItems]);
        } catch (\Exception $e) {
            Log::error('Error al mostrar la lista de apartados: ' . $e->getMessage());
            return redirect()->route('user.home')->withErrors(['error' => 'No se pudo recuperar la lista de apartados.']);
        }
    }

    public function detalles($id)
    {
        try {
            // Recuperar el apartado específico
            $apartado = Apartado::with('detalles.medicamento')->findOrFail($id);

            // Devolver los detalles en formato JSON
            return response()->json($apartado->detalles);
        } catch (\Exception $e) {
            Log::error('Error al recuperar los detalles del apartado: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo recuperar los detalles del apartado.'], 500);
        }
    }


public function addToWishlist(Request $request, $id)
{
    $user = auth()->user();

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Usuario no autenticado.'], 401);
    }

    $exists = Wishlist::where('user_id', $user->id)
                      ->where('id_medicamento', $id)
                      ->exists();

    if (!$exists) {
        $wishlistItem = new Wishlist();
        $wishlistItem->user_id = $user->id;
        $wishlistItem->id_medicamento = $id;
        $wishlistItem->save();

        return response()->json(['success' => true, 'message' => 'Producto agregado a la lista de deseos.']);
    } else {
        return response()->json(['warning' => false, 'message' => 'El producto ya está en la lista de deseos.']);
    }
}

public function removeFromWishlist($id)
{
    $user = auth()->user();

    if ($user) {
        $wishlistItem = Wishlist::where('id', $id)
                               ->where('user_id', $user->id)
                               ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json(['success' => true, 'message' => 'Producto eliminado de la lista de deseos.']);
        }
    }

    return response()->json(['success' => false, 'message' => 'Error al eliminar el producto.']);
}

    public function showWishlist()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes estar autenticado para ver tu lista de deseos.');
        }

        $wishlistItems = Wishlist::with('medicamento')->where('user_id', $user->id)->get();
        $carrito = session('carrito', []);
        $totalItems = array_sum($carrito);


        return view('user.wishlist', compact('wishlistItems', 'totalItems'));
    }

    //prueba para admin

    public function mostrarMedicamentos()
    {
        $usuario = auth()->user();

        $farmacia = $usuario->farmacias()->first();

        if (!$farmacia) {
            return redirect()->back()->withErrors('Este administrador no tiene una farmacia asociada.');
        }

        $medicamentos = Medicamento::where('id_farmacia', $farmacia->id_farmacia)->get();

        return view('admin.medicamentos', compact('medicamentos', 'farmacia'));
    }



}

