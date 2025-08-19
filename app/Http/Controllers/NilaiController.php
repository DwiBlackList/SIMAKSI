<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\JoinedClass;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'gurumapel') {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $joinedClasses = JoinedClass::with(['user', 'mapel'])->get();
        $mapels = Mapel::all();
        $users = User::all();
        $nilais = Nilai::all();
        return view('nilai.index', compact('joinedClasses', 'mapels', 'users', 'nilais'));
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
            'mapel_id' => 'required|exists:mapels,id',
            'user_id' => 'required|integer',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        // cek apakah sudah ada nilai untuk user_id + mapel_id
        $exists = Nilai::where('mapel_id', $request->mapel_id)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['mapel_id' => 'User ini sudah memiliki nilai untuk mata pelajaran tersebut.'])
                ->withInput();
        }

        Nilai::create($request->all());

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Nilai $nilai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nilai $nilai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'user_id' => 'required|integer',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $nilai->update($request->all());

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }
}
