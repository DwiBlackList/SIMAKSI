<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'gurubp/bk') {
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
        $kehadirans = Kehadiran::all();
        $siswas = User::where('role', '=', 'siswa')->get();
        return view('kehadiran.index', compact('siswas', 'kehadirans'));
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
            'user_id' => 'required|integer|exists:users,id',
            'semester' => 'required|string|max:255',
            'hadir' => 'required|integer',
            'absen' => 'required|integer',
            'ijin' => 'required|integer',
            'sakit' => 'required|integer',
        ]);

        // Cek apakah user_id + semester sudah ada
        $exists = Kehadiran::where('user_id', $request->user_id)
            ->where('semester', $request->semester)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['semester' => 'Data untuk semester ini sudah ada untuk user tersebut.'])
                ->withInput();
        }

        Kehadiran::create($request->all());

        return redirect()->route('kehadiran.show', $request->user_id)->with('success', 'Data Kehadiran created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $siswa = User::where('id', '=', $id)->get();
        $kehadirans = Kehadiran::where('user_id', '=', $id)->get();
        return view('kehadiran.show', compact('siswa', 'kehadirans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kehadiran $kehadiran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kehadiran $kehadiran)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'semester' => 'required|string|max:255',
            'hadir' => 'required|integer',
            'absen' => 'required|integer',
            'ijin' => 'required|integer',
            'sakit' => 'required|integer',
        ]);

        // Kalau semester berubah, cek duplikasi
        if ($request->semester != $kehadiran->semester) {
            $exists = Kehadiran::where('user_id', $request->user_id)
                ->where('semester', $request->semester)
                ->exists();

            if ($exists) {
                return redirect()->back()
                    ->withErrors(['semester' => 'Data untuk semester ini sudah ada untuk user tersebut.'])
                    ->withInput();
            }
        }

        $kehadiran->update($request->all());

        return redirect()->route('kehadiran.show', $request->user_id)->with('success', 'Data Kehadiran updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kehadiran $kehadiran)
    {
        Kehadiran::findOrFail($kehadiran->id)->delete();
        return redirect()->route('kehadiran.show', $kehadiran->user_id)->with('success', 'Data Kehadiran deleted successfully.');
    }
}
