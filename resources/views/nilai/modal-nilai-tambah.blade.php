<div class="modal fade" id="modalTambah{{ $joinedClass->id }}" tabindex="-1" aria-labelledby="modalTambahLabel{{ $joinedClass->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('nilai.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel{{ $joinedClass->id }}">Tambah Nilai</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="user_id" value="{{ $joinedClass->user->id }}">
          <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">

          <div class="mb-3">
            <label class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" value="{{ $joinedClass->user->nama }}" disabled>
          </div>

          <div class="mb-3">
            <label class="form-label">Nilai</label>
            <input type="number" class="form-control" name="nilai" min="0" max="100" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
