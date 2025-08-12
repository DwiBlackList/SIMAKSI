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
                <h1>{{ __('Mata Pelajaran') }}</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                    Tambah Mapel
                </button>

                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Form Tambah Mapel</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="{{ route('mapel.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama_mapel" class="form-label">Nama Mapel</label>
                                        <input type="text" class="form-control" id="nama_mapel" name="nama_mapel"
                                            value="{{ old('nama_mapel') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
                                        <input type="text" class="form-control" id="semester" name="semester"
                                            value="{{ old('semester') }}" required>
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
                <table class="table display" id="mapelTable">
                    <thead>
                        <tr>
                            <th>{{ __('Nama Mapel') }}</th>
                            <th>{{ __('Semester') }}</th>
                            <th colspan="2">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapels as $mapel)
                            <tr>
                                <td>{{ $mapel->nama_mapel }}</td>
                                <td>{{ $mapel->semester }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $mapel->id }}">
                                        Edit
                                    </button>
                                </td>
                                <td>
                                    <form action="{{ route('mapel.destroy', $mapel->id) }}" method="POST"
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
    @foreach ($mapels as $mapel)
        <div class="modal fade" id="modalEdit{{ $mapel->id }}">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Form Edit Mapel</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{ route('mapel.update', $mapel->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nama_mapel" class="form-label">Nama Mapel</label>
                                <input type="text" class="form-control" id="nama_mapel" name="nama_mapel"
                                    value="{{ $mapel->nama_mapel }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <input type="text" class="form-control" id="semester" name="semester"
                                    value="{{ $mapel->semester }}" required>
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
            $('#mapelTable').DataTable();
        });
    </script>
@endsection
