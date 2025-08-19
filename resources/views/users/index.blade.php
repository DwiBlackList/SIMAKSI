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
                <h1>{{ __('Data Siswa & Guru') }}</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                    Tambah Siswa
                </button>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModalGuru">
                    Tambah Guru
                </button>

                <!-- The Modal Siswa -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Form Tambah Siswa</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="{{ route('users.store') }}" method="POST">
                                    @csrf
                                    <input type="text" class="form-control" id="role" name="role" value="siswa"
                                        hidden>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Siswa</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ old('nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-Mail</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <input type="text" class="form-control" id="kelas" name="kelas"
                                            value="{{ old('kelas') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jurusan" class="form-label">Jurusan</label>
                                        <input type="text" class="form-control" id="jurusan" name="jurusan"
                                            value="{{ old('jurusan') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nisn/nip" class="form-label">NISN</label>
                                        <input type="text" class="form-control" id="nisn/nip" name="nisn/nip"
                                            value="{{ old('nisn/nip') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            value="{{ old('password') }}" required>
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

                <!-- The Modal Guru -->
                <div class="modal fade" id="myModalGuru">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Form Tambah Guru</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="{{ route('users.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Guru</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ old('nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-Mail</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select" id="role" name="role" required>
                                            <option value="">Pilih Role</option>
                                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="gurumapel" {{ old('role') === 'gurumapel' ? 'selected' : '' }}>
                                                Guru Mapel</option>
                                            <option value="gurubp/bk" {{ old('role') === 'gurubp/bk' ? 'selected' : '' }}>
                                                Guru BP/BK</option>
                                            <option value="walikelas" {{ old('role') === 'walikelas' ? 'selected' : '' }}>
                                                Wali Kelas</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nisn/nip" class="form-label">NIP</label>
                                        <input type="text" class="form-control" id="nisn/nip" name="nisn/nip"
                                            value="{{ old('nisn/nip') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            value="{{ old('password') }}" required>
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
                <table class="table display" id="userTable">
                    <thead>
                        <tr>
                            <th>{{ __('Nama Siswa / Guru') }}</th>
                            <th>{{ __('E-Mail') }}</th>
                            <th>{{ __('Kelas') }}</th>
                            <th>{{ __('Jurusan') }}</th>
                            <th>{{ __('NISN / NIP') }}</th>
                            <th>{{ __('Role') }}</th>
                            <th colspan="2">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->kelas }}</td>
                                <td>{{ $user->jurusan }}</td>
                                <td>{{ $user->nisn_nip }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $user->id }}">
                                        Edit
                                    </button>
                                </td>
                                <td>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
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
    @foreach ($users as $user)
        @if ($user->role === 'siswa')
            <div class="modal fade" id="modalEdit{{ $user->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Form Tambah Siswa</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" class="form-control" id="role" name="role" value="siswa"
                                    hidden>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Siswa</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ $user->nama }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-Mail</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <input type="text" class="form-control" id="kelas" name="kelas"
                                        value="{{ $user->kelas }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan" name="jurusan"
                                        value="{{ $user->jurusan }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nisn/nip" class="form-label">NISN</label>
                                    <input type="text" class="form-control" id="nisn/nip" name="nisn/nip"
                                        value="{{ $user->nisn_nip }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        value="" required>
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
        @else
            <div class="modal fade" id="modalEdit{{ $user->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Guru</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Guru</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ $user->nama }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-Mail</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="">Pilih Role</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="gurumapel" {{ $user->role === 'gurumapel' ? 'selected' : '' }}>
                                            Guru Mapel</option>
                                        <option value="gurubp/bk" {{ $user->role === 'gurubp/bk' ? 'selected' : '' }}>
                                            Guru BP/BK</option>
                                        <option value="walikelas" {{ $user->role === 'walikelas' ? 'selected' : '' }}>
                                            Wali Kelas</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="nisn/nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="nisn/nip" name="nisn/nip"
                                        value="{{ $user->nisn_nip }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        value="" required>
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
        @endif
    @endforeach
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });
    </script>
@endsection
