<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableSlot;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AvailableSlotsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createSlots(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required',
                'slots' => 'required|array',
                'slots.*' => 'date_format:H:i:s',
            ]);

            $date = $validated['date'];
            $slots = collect($validated['slots']);

            $created = [];

            foreach ($slots as $startTime) {
                try {
                    $start = Carbon::createFromFormat('H:i:s', $startTime);
                    $slot = TimeSlot::where('start_time', $start->format('H:i:s'))->first();

                    if (!$slot) {
                        Log::warning("No se encontró slot para hora: $startTime");
                        continue; // O lanza una excepción si quieres detener el proceso
                    }

                    // Validar si ya existe un AvailableSlot con esa fecha y slot
                    $exists = AvailableSlot::where('date', $date)
                        ->where('time_slot_id', $slot->id)
                        ->exists();

                    if (!$exists) {
                        $created[] = AvailableSlot::create([
                            'date' => $date,
                            'time_slot_id' => $slot->id
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error("Error al procesar slot $startTime: " . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Slots procesados correctamente',
                'created_count' => count($created),
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error("Error general al crear slots: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado'
            ], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function getTimeSlots(Request $request)
    {
        $slots = AvailableSlot::all();

        $events = [];

        foreach ($slots as $slot) {
            $StartTime = TimeSlot::where('id', $slot->time_slot_id)->get()->first();
            $start = Carbon::parse($slot->date . ' ' . $StartTime->start_time);  // Convierte a objeto Carbon
            $end = $start->copy()->addMinutes(30);
            // Forzar que end no pase de la medianoche del mismo día:
            if ($end->day !== $start->day) {
                $end = $start->copy()->endOfDay(); // fin del mismo día, 23:59:59
            }
            $events[] = [
                'title' => $slot->id,
                'start' => $start->format('Y-m-d\TH:i:s'),
                'end' => $end->format('Y-m-d\TH:i:s'),
            ];
        }

        return response()->json($events);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyTimeSlots(Request $request)
    {
        try {
            $id = $request->route('id');
            $result = (bool) AvailableSlot::destroy($id);
            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => "No se encontró el registro con ID $id para eliminar."
                ], 404);
            }
            return response()->json([
                'success' => $result,
                'deleted_id' => $id,
            ]);
        } catch (\Throwable $th) {
            // Loguear el error para depuración
            \Log::error('Error eliminando slot: ' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al eliminar el slot.',
                'error' => $th->getMessage(), // opcional, para debug en desarrollo
            ], 500);
        }
    }
}
