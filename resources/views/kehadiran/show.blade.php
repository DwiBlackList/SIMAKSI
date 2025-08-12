@extends('layouts.app')

@section('content')
    @foreach ($siswa as $y)
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
                    <h1>
                        {{ __('Kehadiran Siswa : ') }}
                        {{ $y->nama }}
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                        Tambah Data
                    </button>

                    <!-- The Modal -->
                    <div class="modal fade" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Form Tambah Kehadiran</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form action="{{ route('kehadiran.store') }}" method="POST">
                                        @csrf
                                        <input type="text" hidden value="{{ $y->id }}" name="user_id">
                                        <div class="mb-3">
                                            <label for="nama_siswa" class="form-label">Nama Siswa :
                                                {{ $y->nama }}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="semester" class="form-label">Semester</label>
                                            <input type="number" class="form-control" id="semester" name="semester"
                                                value="{{ old('semester') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="hadir" class="form-label">Hadir</label>
                                            <input type="number" class="form-control" id="hadir" name="hadir"
                                                value="{{ old('hadir') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="absen" class="form-label">Absen</label>
                                            <input type="number" class="form-control" id="absen" name="absen"
                                                value="{{ old('absen') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ijin" class="form-label">Ijin</label>
                                            <input type="number" class="form-control" id="ijin" name="ijin"
                                                value="{{ old('ijin') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sakit" class="form-label">Sakit</label>
                                            <input type="number" class="form-control" id="sakit" name="sakit"
                                                value="{{ old('sakit') }}" required>
                                        </div>
                                </div>


                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table class="table display" id="siswaTable">
                        <thead>
                            <tr>
                                <th>{{ __('Nama Siswa') }}</th>
                                <th>{{ __('Semester') }}</th>
                                <th>{{ __('Hadir') }}</th>
                                <th>{{ __('Absen') }}</th>
                                <th>{{ __('Ijin') }}</th>
                                <th>{{ __('Sakit') }}</th>
                                <th>{{ __('Persentase Kehadiran') }}</th>
                                <th colspan="2">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kehadirans as $x)
                                <tr>
                                    <td>{{ $x->user->nama }}</td>
                                    <td>{{ $x->semester }}</td>
                                    <td>{{ $x->hadir }}</td>
                                    <td>{{ $x->absen }}</td>
                                    <td>{{ $x->ijin }}</td>
                                    <td>{{ $x->sakit }}</td>
                                    @php
                                        $total = $x->hadir + $x->absen + $x->ijin + $x->sakit;
                                        $persentase = $total > 0 ? ($x->hadir / $total) * 100 : 0;
                                    @endphp
                                    <td>{{ number_format($persentase, 2) }}%</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $x->id }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <form action="{{ route('kehadiran.destroy', $x->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @foreach ($kehadirans as $x)
            <div class="modal fade" id="modalEdit{{ $x->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Form Edit Data Kehadiran</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <form action="{{ route('kehadiran.update', $x->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" hidden value="{{ $y->id }}" name="user_id">
                                <div class="mb-3">
                                    <label for="nama_siswa" class="form-label">Nama Siswa :
                                        {{ $y->nama }}</label>
                                </div>
                                <div class="mb-3">
                                    <label for="semester" class="form-label">Semester</label>
                                    <input type="number" class="form-control" id="semester" name="semester"
                                        value="{{ $x->semester }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="hadir" class="form-label">Hadir</label>
                                    <input type="number" class="form-control" id="hadir" name="hadir"
                                        value="{{ $x->hadir }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="absen" class="form-label">Absen</label>
                                    <input type="number" class="form-control" id="absen" name="absen"
                                        value="{{ $x->absen }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="ijin" class="form-label">Ijin</label>
                                    <input type="number" class="form-control" id="ijin" name="ijin"
                                        value="{{ $x->ijin }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="sakit" class="form-label">Sakit</label>
                                    <input type="number" class="form-control" id="sakit" name="sakit"
                                        value="{{ $x->sakit }}" required>
                                </div>
                        </div>


                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <script>
            $(document).ready(function() {
                $('#siswaTable').DataTable();
            });
        </script>
    @endforeach
@endsection
