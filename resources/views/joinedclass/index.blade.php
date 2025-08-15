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
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#myModal{{ $y->id }}">
                                        Tambah Murid / Guru
                                    </button>
                                    <!-- The Modal -->
                                    <div class="modal fade" id="myModal{{ $y->id }}">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Form Tambah Murid / Guru Untuk
                                                        {{ $y->nama_mapel }}</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form action="{{ route('settingkelas.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="mapel_id" value="{{ $y->id }}">
                                                        <table class="table display" id="tabelUser{{ $y->id }}">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama</th>
                                                                    <th>Role</th>
                                                                    <th>Tambah</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($users as $z)
                                                                    <tr>
                                                                        <td>{{ $z->nama }}</td>
                                                                        <td>{{ $z->role }}</td>
                                                                        <td><input type="checkbox" name="user_id[]"
                                                                                class="form-check-input"
                                                                                value="{{ $z->id }}"></td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>

                                                </div>


                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <table class="table display" id="tabel{{ $y->id }}">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Nama') }}</th>
                                                <th>{{ __('Role') }}</th>
                                                <th>{{ __('Aksi') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($joinedClasses as $joinedClass)
                                                @if ($joinedClass->mapel_id == $y->id)
                                                    <tr>
                                                        <td>{{ $joinedClass->user->nama }}</td>
                                                        <td>{{ $joinedClass->user->role }}</td>
                                                        <td>
                                                            <form action="{{ route('settingkelas.destroy' , $joinedClass->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
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
