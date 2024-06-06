
<button type="button" class="btn btn-secondary btn-sm d-flex gap-2 mt-2"  style="height: 35px;" data-bs-toggle="modal" data-bs-target="#resetModal{{ $data->id }}">
    <i class="fa-solid fa-user-lock mt-1"></i> Reset
</button>

<!-- Modal -->
<div class="modal fade" id="resetModal{{ $data->id }}" tabindex="-1" aria-labelledby="resetModalLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetModalLabel{{ $data->id }}">Confirm Password Reset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to reset the password of student {{ $data->lrn }}?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('student.password.reset', ['id' => $data->id]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-primary">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
