<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapels = Mapel::all();
        return view('mapel.index' , compact('mapels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
        ]);

        Mapel::create($request->all());

        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mapel $mapel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mapel $mapel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
        ]);

        $mapel->update($request->all());

        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mapel $mapel)
    {
        Mapel::findOrFail($mapel->id)->delete();
        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran deleted successfully.');

    }
}
