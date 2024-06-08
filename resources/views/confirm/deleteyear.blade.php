<!-- Button trigger modal -->
<button type="button" class="btn btn-danger btn-sm gap-2 mt-2 d-flex" style="height: 35px;" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $schoolYear->id }}">
    <i class="fa-solid fa-trash mt-1"></i> Delete
</button>

<!-- Modal -->
<div class="modal fade" id="deleteModal{{ $schoolYear->id  }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $schoolYear->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $schoolYear->id }}">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="fa-solid fa-triangle-exclamation"></i>   Caution: Deleting this school year will result in the loss of associated data and information. This action cannot be undone. Please confirm.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('school.year.delete', ['id'=> $schoolYear->id]) }}" method="POST">

                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                 </form>
        
              </div>
        </div>
    </div>
</div>
