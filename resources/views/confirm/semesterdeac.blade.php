<button type="button" class="btn btn-success btn-sm d-flex gap-2 mt-2" style="height: 35px;" data-bs-toggle="modal" data-bs-target="#resetModal{{ $semester->id }}">
    <i class="fa-solid fa-toggle-on mt-1"></i> Active
</button>


<div class="modal fade" id="resetModal{{ $semester->id }}" tabindex="-1" aria-labelledby="resetModalLabel{{ $semester->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetModalLabel{{ $semester->id}}">Confirm deactivation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               Are you sure you want to deactivate {{ $semester->semester }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('semester.deactive.status', ['id' => $semester->id]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-secondary">Deactivate</button>
                </form>
            </div>
        </div>
    </div>
</div>