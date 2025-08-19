<?php

namespace App\Http\Controllers;

use App\Models\JoinedClass;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;

class JoinedClassController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
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
        return view('joinedclass.index', compact('joinedClasses', 'mapels', 'users'));
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
            'user_id' => 'required|array',
            'user_id.*' => 'exists:users,id',
        ]);

        foreach ($request->user_id as $userId) {
            JoinedClass::create([
                'mapel_id' => $request->mapel_id,
                'user_id' => $userId,
            ]);
        }

        return redirect()->route('settingkelas.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JoinedClass $joinedClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JoinedClass $joinedClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JoinedClass $joinedClass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        JoinedClass::findOrFail($id)->delete();
        return redirect()->route('settingkelas.index')->with('success', 'User deleted successfully.');
    }
}
