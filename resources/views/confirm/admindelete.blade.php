<!-- Button trigger modal -->
<button type="button" class="btn btn-danger btn-sm gap-2 mt-2" style="height: 35px;" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $admin->id }}">
    <i class="fa-solid fa-trash"></i> Delete
</button>

<!-- Modal -->
<div class="modal fade" id="deleteModal{{ $admin->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $admin->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $admin->id }}">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete admin {{ $admin->name}}?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form action="{{ route('admin.delete', ['id'=> $admin->id]) }}" method="POST">

                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                 </form>
        
              </div>
        </div>
    </div>
</div>
