<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Motorcycle;
use App\Http\Resources\TripResource;

class TripController extends Controller
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

        $trips = $motor->trips();

        return TripResource::collection($trips->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'motorcycle_id' => 'required|integer',
            'distance_km' => 'required|numeric',
            'trip_type' => 'required|in:gps,manual'
        ]);
        $motor = Motorcycle::where('user_id', auth()->id())
                           ->findOrFail($request->motorcycle_id);

        $trip = Trip::create([
            'motorcycle_id' => $motor->id,
            'distance_km' => $request->distance_km,
            'trip_type' => $request->trip_type,
        ]);

        return (new TripResource($trip))->additional([
            'success' => true,
            'message' => 'Perjalanan berhasil dicatat',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trip = Trip::findOrFail($id);

        $user = $trip->motorcycle->user_id;

        if ($user !== auth()->id()){
            return response()->json([
                'message' => 'Komponen tidak dapat ditemukan'
            ], 404);
        }

        return (new TripResource($trip));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $trip = Trip::findOrFail($id);

        $user = $trip->motorcycle->user_id;


        if ($user !== auth()->id()){
            return response()->json([
                'message' => 'Perjalanan tidak dapat ditemukan'
            ], 404);
        }

        if ($trip->trip_type == 'gps') {
            return response()->json([
                'message' => 'Perjalanan melalui gps tidak dapat dirubah!!'
            ], 403);
        }

        $request->validate([
            'distance_km' => 'required|numeric',
        ]);

        $trip->update([
            'distance_km' => $request->distance_km,
        ]);
        $trip->refresh();

        return (new TripResource($trip))->additional([
            'success' => true,
            'message' => 'Perjalanan berhasil diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trip = Trip::findOrFail($id);
        $user = $trip->motorcycle->user_id;

        if ($user !== auth()->id()){
            return response()->json([
                'message' => 'Komponen tidak dapat ditemukan'
            ], 404);
        }

        $trip->delete();

        return response()->json([
            'success' => true,
            'message' => 'Perjalanan berhasil dihapus'
        ]);
    }
}
