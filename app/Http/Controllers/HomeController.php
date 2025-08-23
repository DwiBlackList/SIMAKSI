<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kehadiran;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Nilai;
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
            // Mapel yang diikuti/dikelola oleh walikelas (berdasarkan joined_classes)
            $mapelIds = JoinedClass::where('user_id', $user->id)
                ->pluck('mapel_id')
                ->unique();

            // Ambil mapel2 itu + daftar siswa (hanya role siswa)
            $mapels = Mapel::whereIn('id', $mapelIds)
                ->with(['users' => function ($q) {
                    $q->where('role', 'siswa')->orderBy('nama');
                }])
                ->orderBy('semester')
                ->orderBy('nama_mapel')
                ->get();

            // Kumpulkan semua siswa yang ikut mapel2 tsb (untuk eager load nilai & kehadiran)
            $studentIds = JoinedClass::whereIn('mapel_id', $mapelIds)
                ->pluck('user_id')->unique();

            // Kumpulkan nilai: key = "userId-mapelId"
            $nilais = Nilai::whereIn('user_id', $studentIds)
                ->whereIn('mapel_id', $mapelIds)
                ->get()
                ->groupBy(fn($n) => $n->user_id . '-' . $n->mapel_id);

            // Kumpulkan kehadiran: key = "userId-semester"
            $kehadiran = Kehadiran::whereIn('user_id', $studentIds)
                ->get()
                ->groupBy(fn($k) => $k->user_id . '-' . $k->semester);

            return view('homewalikelas', compact('mapels', 'nilais', 'kehadiran'));
        } else {
            return view('home');
        }
    }
}
