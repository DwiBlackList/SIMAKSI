@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ __('Kehadiran Siswa') }}</h1>
                <hr>
                <table class="table display" id="siswaTable">
                    <thead>
                        <tr>
                            <th>{{ __('Nama Siswa') }}</th>
                            <th>{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswas as $siswa)
                            <tr>
                                <td>{{ $siswa->nama }}</td>
                                <td>
                                    <a href="{{ route('kehadiran.show' , $siswa->id) }}" target="_blank" class="btn btn-outline-primary">Lihat/Edit Kehadiran Siswa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#siswaTable').DataTable();
        });
    </script>
@endsection
