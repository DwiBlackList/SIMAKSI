<div class="modal fade" id="modalEdit{{ $nilai->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $nilai->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modalEditLabel{{ $nilai->id }}">Edit Nilai</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="user_id" value="{{ $user->id }}">
          <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">

          <div class="mb-3">
            <label class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" value="{{ $user->nama }}" disabled>
          </div>

          <div class="mb-3">
            <label class="form-label">Nilai</label>
            <input type="number" class="form-control" name="nilai" value="{{ $nilai->nilai }}" min="0" max="100" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
