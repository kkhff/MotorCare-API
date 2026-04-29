<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenancePart;
use App\Models\Motorcycle;
use App\Http\Resources\MaintenancePartResource;

class MaintenancePartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'motorcycle_id' => 'required|integer',
        ]);

        $motor = Motorcycle::where('user_id', auth()->id())
                           ->findOrFail($request->motorcycle_id);

        $parts = $motor->maintenance();

        return MaintenancePartResource::collection($parts->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'motorcycle_id' => 'required|integer',
            'part_name' => 'required|string',
            'interval_km' => 'required|integer',
            'last_replace_km' => 'required|numeric',
        ]);

        $motor = Motorcycle::where('user_id', auth()->id())
                           ->findOrFail($request->motorcycle_id);



        $part = MaintenancePart::create([
            'motorcycle_id' => $motor->id,
            'part_name' => $request->part_name,
            'interval_km' => $request->interval_km,
            'last_replace_km' => $request->last_replace_km,
        ]);

        return (new MaintenancePartResource($part))->additional([
            'success' => true,
            'message' => 'Komponen berhasil ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $part = MaintenancePart::findOrFail($id);

        $user = $part->motorcycle->user_id;

        if ($user !== auth()->id()){
            return response()->json([
                'message' => 'Komponen tidak dapat ditemukan'
            ], 404);
        }

        return (new MaintenancePartResource($part));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $part = MaintenancePart::findOrFail($id);

        $user = $part->motorcycle->user_id;

        if ($user !== auth()->id()){
            return response()->json([
                'message' => 'Komponen tidak dapat ditemukan'
            ], 404);
        }

        $request->validate([
            'part_name' => 'required|string',
            'interval_km' => 'required|integer',
            'last_replace_km' => 'required|numeric',
        ]);

        $part->update([
            'part_name' => $request->part_name,
            'interval_km' => $request->interval_km,
            'last_replace_km' => $request->last_replace_km,
        ]);

        return (new MaintenancePartResource($part))->additional([
            'success' => true,
            'message' => 'Komponen berhasil diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $part = MaintenancePart::findOrFail($id);
        $user = $part->motorcycle->user_id;

        if ($user !== auth()->id()){
            return response()->json([
                'message' => 'Komponen tidak dapat ditemukan'
            ], 404);
        }
        $part->delete();

        return response()->json([
            'success' => true,
            'message' => 'Komponen berhasil dihapus'
        ]);
    }

    public function replace(string $id)
    {
        $part = MaintenancePart::findOrFail($id);
        $user = $part->motorcycle->user_id;

        if ($user !== auth()->id()){
            return response()->json([
                'message' => 'Komponen tidak dapat ditemukan'
            ], 404);
        }
        $current_km = $part->motorcycle->current_km;

        $part->update([
            'last_replace_km' => $current_km,
        ]);

        $part->refresh();

        return (new MaintenancePartResource($part))->additional([
            'success' => true,
            'message' => 'Komponen berhasil diperbarui'
        ]);
    }
}
