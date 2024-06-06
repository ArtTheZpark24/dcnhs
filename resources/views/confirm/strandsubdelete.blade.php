<!-- Button trigger modal -->
<button type="button" class="btn btn-danger btn-sm d-flex gap-2 mt-2" style="height: 35px;" data-bs-toggle="modal" data-bs-target="#delete{{ $subject->id }}">
    <i class="fa-solid fa-trash mt-1"></i> Delete
</button>

<!-- Modal -->
<div class="modal fade" id="delete{{ $subject->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete subject {{ $subject->subject }}?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="height: 37px;"  data-bs-dismiss="modal">Cancel</button>
                <form action="{{route('strandsub.delete', ['id'=>$subject->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
