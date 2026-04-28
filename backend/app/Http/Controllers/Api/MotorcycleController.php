<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motorcycle;
use App\Models\MaintenancePart;
use App\Http\Resources\MotorcycleResource;
use App\Http\Resources\MaintenancePartResource;

class MotorcycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motor = Motorcycle::where('user_id', auth()->id());

        return MotorcycleResource::collection($motor->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'motorcycle_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'current_km' => 'required|numeric|min:0',
        ]);

        $motor = Motorcycle::create([
            'user_id' => auth()->id(),
            'motorcycle_name' => $request->motorcycle_name,
            'brand' => $request->brand,
            'current_km' => $request->current_km
        ]);

        return (new MotorcycleResource($motor))->additional([
            'success' => true,
            'message' => 'Motor berhasil ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $motor = Motorcycle::with('maintenance')
                           ->where('user_id', auth()->id())
                           ->findOrFail($id);

        return (new MotorcycleResource($motor));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $motor = Motorcycle::where('user_id', auth()->id())
                           ->where('id', $id)
                           ->first();
        if (!$motor) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ],404);
        }

        $request->validate([
            'motorcycle_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'current_km' => 'required|numeric|min:0',
        ]);

        $motor->update([
            'motorcycle_name' => $request->motorcycle_name,
            'brand' => $request->brand,
            'current_km' => $request->current_km
        ]);

        return (new MotorcycleResource($motor))->additional([
            'success' => true,
            'message' => 'Motor berhasil ditambahkan'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $motor = Motorcycle::where('user_id', auth()->id())
                           ->findOrFail($id);


        $motor->maintenance()->delete();
        $motor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
