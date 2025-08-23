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
                <div class="accordion" id="accordionMapel">
                    @foreach ($mapels as $y)
                        <div class="accordion-item mb-3 shadow-sm rounded">
                            <h2 class="accordion-header" id="heading{{ $y->id }}">
                                <button class="accordion-button collapsed fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $y->id }}"
                                    aria-expanded="false" aria-controls="collapse{{ $y->id }}">
                                    Mapel : {{ $y->nama_mapel }} | Semester : {{ $y->semester }}
                                </button>
                            </h2>
                            <div id="collapse{{ $y->id }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $y->id }}" data-bs-parent="#accordionMapel">
                                <div class="accordion-body">

                                    {{-- Tombol Modal --}}
                                    <button type="button" class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#myModal{{ $y->id }}">
                                        Tambah Murid / Guru
                                    </button>

                                    {{-- Modal --}}
                                    <div class="modal fade" id="myModal{{ $y->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Form Tambah Murid / Guru Untuk
                                                        {{ $y->nama_mapel }}</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('settingkelas.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="mapel_id" value="{{ $y->id }}">
                                                        <table class="table table-bordered table-striped"
                                                            id="tabelUser{{ $y->id }}">
                                                            <thead class="table-light">
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
                                                                        <td class="text-center">
                                                                            <input type="checkbox" name="user_id[]"
                                                                                class="form-check-input"
                                                                                value="{{ $z->id }}">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tabel Murid/Guru --}}
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="tabel{{ $y->id }}">
                                            <thead class="table-light">
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
                                                                <form
                                                                    action="{{ route('settingkelas.destroy', $joinedClass->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger">Delete</button>
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
