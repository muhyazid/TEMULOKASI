<?php

namespace App\Http\Controllers\Admin;

use App\Models\DataLocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDataLokasiController extends Controller
{
    public function index()
    {
        $locations = DataLocation::latest()->get();
        return view('pages.admin.datalokasi', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        DataLocation::create($request->only('nama_lokasi', 'latitude', 'longitude'));

        return redirect()->route('admin.datalokasi')->with('success', 'Data lokasi berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lokasi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $location = DataLocation::findOrFail($id);
        $location->update($request->only('nama_lokasi', 'latitude', 'longitude'));

        return redirect()->route('admin.datalokasi')->with('success', 'Data lokasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $location = DataLocation::findOrFail($id);
        $location->delete();

        return redirect()->route('admin.datalokasi')->with('success', 'Data lokasi berhasil dihapus!');
    }
}
