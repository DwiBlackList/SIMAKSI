@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="accordion" id="semesterAccordion">
                    @foreach ($semesters as $semester)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $semester }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $semester }}" aria-expanded="false"
                                    aria-controls="collapse{{ $semester }}">
                                    Semester {{ $semester }}
                                </button>
                            </h2>
                            <div id="collapse{{ $semester }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $semester }}" data-bs-parent="#semesterAccordion">
                                <div class="accordion-body">

                                    {{-- Tabel Mapel --}}
                                    <h5>Mata Pelajaran</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Mapel</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($classesBySemester[$semester] ?? [] as $class)
                                                <tr>
                                                    <td>{{ $class->mapel->nama_mapel }}</td>
                                                    <td>
                                                        @php
                                                            $nilai = $class->mapel->nilais->first()?->nilai ?? '-';
                                                        @endphp
                                                        {{ $nilai }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{-- Tabel Kehadiran --}}
                                    <h5>Kehadiran</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Hadir</th>
                                                <th>Absen</th>
                                                <th>Ijin</th>
                                                <th>Sakit</th>
                                                <th>Persentase Kehadiran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $k = $kehadirans[$semester][0] ?? null;
                                            @endphp
                                            @if ($k)
                                                @php
                                                    $total = $k->hadir + $k->absen + $k->ijin + $k->sakit;
                                                    $persentase = $total > 0 ? ($k->hadir / $total) * 100 : 0;
                                                @endphp
                                                <tr>
                                                    <td>{{ $k->hadir }}</td>
                                                    <td>{{ $k->absen }}</td>
                                                    <td>{{ $k->ijin }}</td>
                                                    <td>{{ $k->sakit }}</td>
                                                    <td>{{ number_format($persentase, 2) }}%</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">Belum ada data kehadiran</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                    {{-- Tabel Status Kenaikan Kelas --}}
                                    <h5>Status Kenaikan Kelas</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Alasan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $alasan = [];
                                                $status = 'Tidak Naik Kelas';

                                                // Ambil nilai mapel semester ini
                                                $nilaiMapel = [];
                                                foreach ($classesBySemester[$semester] ?? [] as $class) {
                                                    $nilai = $class->mapel->nilais->first()?->nilai ?? null;
                                                    if ($nilai !== null) {
                                                        $nilaiMapel[] = $nilai;
                                                    }
                                                }

                                                $jumlahMapel = count($nilaiMapel);
                                                $rataRata =
                                                    $jumlahMapel > 0 ? array_sum($nilaiMapel) / $jumlahMapel : 0;
                                                $jumlahDiBawah75 = count(array_filter($nilaiMapel, fn($n) => $n < 75));

                                                // Hitung kehadiran
                                                if ($k) {
                                                    $total = $k->hadir + $k->absen + $k->ijin + $k->sakit;
                                                    $persentaseKehadiran = $total > 0 ? ($k->hadir / $total) * 100 : 0;
                                                } else {
                                                    $persentaseKehadiran = 0;
                                                }

                                                // Logika status
                                                if (
                                                    $rataRata >= 75 &&
                                                    $persentaseKehadiran >= 85 &&
                                                    $jumlahDiBawah75 == 0
                                                ) {
                                                    $status = 'Naik Kelas';
                                                } elseif (
                                                    $rataRata >= 75 &&
                                                    $persentaseKehadiran >= 80 &&
                                                    $jumlahDiBawah75 <= 2
                                                ) {
                                                    $status = 'Naik Bersyarat';
                                                    if ($jumlahDiBawah75 > 0) {
                                                        $alasan[] = "Terdapat $jumlahDiBawah75 mata pelajaran dengan nilai di bawah 75";
                                                    }
                                                } elseif ($jumlahDiBawah75 > 2 || $persentaseKehadiran <= 70) {
                                                    $status = 'Tidak Naik Kelas';
                                                    if ($jumlahDiBawah75 > 2) {
                                                        $alasan[] = 'Lebih dari 2 mata pelajaran nilainya di bawah 75';
                                                    }
                                                    if ($persentaseKehadiran <= 70) {
                                                        $alasan[] = "Persentase kehadiran kurang dari atau sama dengan 70% ({$persentaseKehadiran}%)";
                                                    }
                                                } else {
                                                    // fallback jika kondisi tidak masuk manapun
                                                    $status = 'Tidak Naik Kelas';
                                                }
                                            @endphp

                                            <tr>
                                                <td>
                                                    @if ($status === 'Naik Kelas')
                                                        <span class="badge bg-success">{{ $status }}</span>
                                                    @elseif ($status === 'Naik Bersyarat')
                                                        <span class="badge bg-warning text-dark">{{ $status }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (count($alasan) > 0)
                                                        <ul>
                                                            @foreach ($alasan as $a)
                                                                <li>{{ $a }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
