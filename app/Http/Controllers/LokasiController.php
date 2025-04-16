<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\DataLocation;
use Illuminate\Http\Request;
use App\Models\LocationParameter;

class LokasiController extends Controller
{
    // Menampilkan form input lokasi
    public function index()
    {
        $availableLocations = DataLocation::all();
        return view('pages.user.lokasi', compact('availableLocations'));
    }

    // Menyimpan data lokasi dan parameter
    public function store(Request $request)
    {
        $request->validate([
            'business_type' => 'required|string',
            'locations' => 'required|array|min:1',
            'locations.*.name' => 'required|string|max:255',
            'locations.*.latitude' => 'required|numeric',
            'locations.*.longitude' => 'required|numeric',
            'locations.*.parameters' => 'required|array',
        ]);

        foreach ($request->locations as $locationData) {
            $location = Location::create([
                'name' => $locationData['name'],
                'type' => $request->business_type,
                'latitude' => $locationData['latitude'],
                'longitude' => $locationData['longitude'],
            ]);

            foreach ($locationData['parameters'] as $paramKey => $value) {
                LocationParameter::create([
                    'location_id' => $location->id,
                    'parameter_name' => $paramKey,
                    'value' => $value,
                ]);
            }
        }
        return redirect()->route('lokasi')->with('success', 'Lokasi berhasil disimpan');
    }
}
