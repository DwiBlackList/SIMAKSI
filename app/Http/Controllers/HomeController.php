<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kehadiran;
use App\Models\Mapel;
use App\Models\JoinedClass;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'siswa') {
            // Ambil semester yang ada dari mapel atau kehadiran
            $semesters = Mapel::orderBy('semester')->pluck('semester')->unique();

            $joinedClasses = JoinedClass::with(['mapel', 'mapel.nilais' => function ($q) use ($user) {
                $q->where('user_id', $user->id);
            }])->where('user_id', $user->id)->get();

            // Kelompokkan joined class per semester
            $classesBySemester = $joinedClasses->groupBy(fn($jc) => $jc->mapel->semester);

            // Ambil kehadiran siswa, group by semester
            $kehadirans = Kehadiran::where('user_id', $user->id)
                ->get()
                ->groupBy('semester');

            return view('homesiswa', compact('semesters', 'classesBySemester', 'kehadirans'));
        } elseif ($user->role === 'walikelas') {
            return view('homewalikelas');
        } else {
            return view('home');
        }
    }
}
