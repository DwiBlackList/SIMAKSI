@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <h1>{{ __('Penilaian Mata Pelajaran') }}</h1>

                <hr>
                @foreach ($mapels as $y)
                    <div class="accordion mb-3" id="accordionMapel{{ $y->id }}">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $y->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $y->id }}" aria-expanded="false"
                                    aria-controls="collapse{{ $y->id }}">
                                    <strong>Mapel:</strong> {{ $y->nama_mapel }} &nbsp; | &nbsp;
                                    <strong>Semester:</strong> {{ $y->semester }}
                                </button>
                            </h2>
                            <div id="collapse{{ $y->id }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $y->id }}"
                                data-bs-parent="#accordionMapel{{ $y->id }}">
                                <div class="accordion-body">
                                    <table class="table table-striped table-bordered" id="tabel{{ $y->id }}">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Nama</th>
                                                <th>Role</th>
                                                <th>Nilai</th>
                                                <th colspan="3" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($joinedClasses as $joinedClass)
                                                @if ($joinedClass->mapel_id == $y->id)
                                                    @php
                                                        $nilaiUser = $nilais
                                                            ->where('user_id', $joinedClass->user->id)
                                                            ->where('mapel_id', $y->id)
                                                            ->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $joinedClass->user->nama }}</td>
                                                        <td>{{ ucfirst($joinedClass->user->role) }}</td>
                                                        <td>{{ $nilaiUser->nilai ?? '-' }}</td>
                                                        <td>
                                                            @if (!$nilaiUser)
                                                                <!-- Tombol Tambah Nilai -->
                                                                <button type="button" class="btn btn-sm btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalTambah{{ $joinedClass->id }}">
                                                                    Tambah Nilai
                                                                </button>
                                                                @include('nilai.modal-nilai-tambah', [
                                                                    'joinedClass' => $joinedClass,
                                                                    'mapel' => $y,
                                                                ])
                                                            @else
                                                                <button class="btn btn-sm btn-secondary" disabled>Nilai
                                                                    Ada</button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($nilaiUser)
                                                                <!-- Tombol Edit -->
                                                                <button type="button" class="btn btn-sm btn-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalEdit{{ $nilaiUser->id }}">
                                                                    Edit
                                                                </button>
                                                                @include('nilai.modal-nilai-edit', [
                                                                    'nilai' => $nilaiUser,
                                                                    'mapel' => $y,
                                                                    'user' => $joinedClass->user,
                                                                ])
                                                            @else
                                                                <button class="btn btn-sm btn-secondary" disabled>Belum
                                                                    Ada</button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($nilaiUser)
                                                                <!-- Tombol Delete -->
                                                                <form action="{{ route('nilai.destroy', $nilaiUser->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Yakin hapus nilai ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger">Delete</button>
                                                                </form>
                                                            @else
                                                                <button class="btn btn-sm btn-secondary" disabled>Belum
                                                                    Ada</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    @foreach ($mapels as $y)
        <script>
            $(document).ready(function() {
                $('#tabel{{ $y->id }}').DataTable();
                $('#tabelUser{{ $y->id }}').DataTable();
            });
        </script>
    @endforeach
@endsection
