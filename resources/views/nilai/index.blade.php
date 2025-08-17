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
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header">
                                <a class="btn" data-bs-toggle="collapse" href="#collapse{{ $y->id }}">
                                    <h5 class="mb-0">Mapel : {{ $y->nama_mapel }}; Semester : {{ $y->semester }}</h5>
                                </a>
                            </div>
                            <div id="collapse{{ $y->id }}" class="collapse" data-bs-parent="#accordion">
                                <div class="card-body">
                                    <table class="table display" id="tabel{{ $y->id }}">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Nama') }}</th>
                                                <th>{{ __('Role') }}</th>
                                                <th>{{ __('Nilai') }}</th>
                                                <th colspan="3">{{ __('Aksi') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($joinedClasses as $joinedClass)
                                                @if ($joinedClass->mapel_id == $y->id)
                                                    <tr>
                                                        <td>{{ $joinedClass->user->nama }}</td>
                                                        <td>{{ $joinedClass->user->role }}</td>
                                                        <td>{{ $nilais->where('user_id', $joinedClass->user->id)->where('mapel_id', $y->id)->first()->nilai ?? '-' }}</td>
                                                        <td>
                                                            @if ($nilais->where('user_id', $joinedClass->user->id)->where('mapel_id', $y->id)->first() == null)
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#myModal{{ $joinedClass->id }}">
                                                                Tambah Nilai
                                                            </button>
                                                            <!-- The Modal -->
                                                            <div class="modal fade" id="myModal{{ $joinedClass->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">

                                                                        <!-- Modal Header -->
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Form Tambah Nilai :
                                                                                {{ $joinedClass->user->nama }} -
                                                                                {{ $y->nama_mapel }}</h4>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"></button>
                                                                        </div>

                                                                        <!-- Modal body -->
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('nilai.store') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="user_id"
                                                                                    value="{{ $joinedClass->user->id }}">
                                                                                <input type="hidden" name="mapel_id"
                                                                                    value="{{ $y->id }}">
                                                                                <div class="mb-3">
                                                                                    <label for="nilai"
                                                                                        class="form-label">Nilai</label>
                                                                                    <input type="number"
                                                                                        class="form-control" id="nilai"
                                                                                        name="nilai"
                                                                                        value="{{ old('nilai') }}"
                                                                                        required>
                                                                                </div>

                                                                        </div>


                                                                        <!-- Modal footer -->
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Simpan</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @else
                                                                <button type="button" class="btn btn-secondary"
                                                                    disabled>Nilai Sudah Ada</button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($nilais->where('user_id', $joinedClass->user->id)->where('mapel_id', $y->id)->first() == null)
                                                                <button type="button" class="btn btn-secondary"
                                                                    disabled>Belum Ada Nilai</button>
                                                            @else
                                                            <button type="button" class="btn btn-warning"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalEdit{{ $nilais->where('user_id', $joinedClass->user->id)->where('mapel_id', $y->id)->first()->id ?? '-' }}">
                                                                Edit
                                                            </button>
                                                            <div class="modal fade" id="modalEdit{{ $nilais->where('user_id', $joinedClass->user->id)->where('mapel_id', $y->id)->first()->id ?? '-' }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">

                                                                        <!-- Modal Header -->
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Form Edit Mapel</h4>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"></button>
                                                                        </div>

                                                                        <!-- Modal body -->
                                                                        <div class="modal-body">
                                                                            <form
                                                                                action="{{ route('nilai.update', $nilais->where('user_id', $joinedClass->user->id)->where('mapel_id', $y->id)->first()->id ?? '-') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <input type="hidden" name="user_id"
                                                                                    value="{{ $joinedClass->user->id }}">
                                                                                <input type="hidden" name="mapel_id"
                                                                                    value="{{ $y->id }}">
                                                                                <div class="mb-3">
                                                                                    <label for="nilai"
                                                                                        class="form-label">Nilai</label>
                                                                                    <input type="number"
                                                                                        class="form-control" id="nilai"
                                                                                        name="nilai"
                                                                                        value="{{ $nilais->where('user_id', $joinedClass->user->id)->where('mapel_id', $y->id)->first()->nilai ?? '-' }}"
                                                                                        required>
                                                                                </div>
                                                                        </div>


                                                                        <!-- Modal footer -->
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Simpan</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($nilais->where('user_id', $joinedClass->user->id)->where('mapel_id', $y->id)->first() == null)
                                                                <button type="button" class="btn btn-secondary"
                                                                    disabled>Belum Ada Nilai</button>
                                                            @else
                                                            <form
                                                                action="{{ route('nilai.destroy', $nilais->where('user_id', $joinedClass->user->id)->where('mapel_id', $y->id)->first()->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
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
