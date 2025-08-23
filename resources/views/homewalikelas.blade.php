@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="accordion" id="mapelAccordion">
                    @forelse ($mapels as $i => $mapel)
                        @php
                            $accId = "mapel_{$mapel->id}_{$i}";
                        @endphp
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-{{ $accId }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $accId }}" aria-expanded="false"
                                    aria-controls="collapse-{{ $accId }}">
                                    {{ $mapel->nama_mapel }} — Semester {{ $mapel->semester }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $accId }}" class="accordion-collapse collapse"
                                aria-labelledby="heading-{{ $accId }}" data-bs-parent="#mapelAccordion">
                                <div class="accordion-body">

                                    <table class="table table-bordered table-striped align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:30%">Nama Siswa</th>
                                                <th style="width:15%">Nilai</th>
                                                <th style="width:20%">Kehadiran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($mapel->users as $siswa)
                                                @php
                                                    // Nilai untuk mapel ini
                                                    $nKey = $siswa->id . '-' . $mapel->id;
                                                    $nilai = isset($nilais[$nKey])
                                                        ? $nilais[$nKey]->first()->nilai
                                                        : null;

                                                    // Kehadiran berdasar semester mapel
                                                    $kKey = $siswa->id . '-' . $mapel->semester;
                                                    $kh = isset($kehadiran[$kKey]) ? $kehadiran[$kKey]->first() : null;
                                                    $total =
                                                        ($kh->hadir ?? 0) +
                                                        ($kh->absen ?? 0) +
                                                        ($kh->ijin ?? 0) +
                                                        ($kh->sakit ?? 0);
                                                    $persen =
                                                        $total > 0
                                                            ? round((($kh->hadir ?? 0) / $total) * 100, 2)
                                                            : null;
                                                @endphp
                                                <tr>
                                                    <td>{{ $siswa->nama }}</td>
                                                    <td>{{ $nilai !== null ? $nilai : '–' }}</td>
                                                    <td>
                                                        @if ($persen !== null)
                                                            {{ $persen }} %
                                                        @else
                                                            –
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Belum ada siswa pada mapel ini.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">Tidak ada mapel yang dipegang.</div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
@endsection
