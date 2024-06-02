<!-- Button trigger modal -->
<button type="button" class="btn btn-danger btn-sm d-flex gap-2 mt-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $data->id }}">
    <i class="fa-solid fa-trash mt-1"></i> Delete
</button>

<!-- Modal -->
<div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $data->id }}">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete teacher {{ $data->teacher_id }}?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form action="{{ route('teachers.data.delete', ['id' => $data->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                       <button class="btn btn-danger">Yes</button>
                  </form>
        
              </div>
        </div>
    </div>
</div>
