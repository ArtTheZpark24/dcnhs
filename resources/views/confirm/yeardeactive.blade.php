<button type="button" class="btn btn-success btn-sm d-flex gap-2 mt-2" style="height: 35px;" data-bs-toggle="modal" data-bs-target="#resetModal{{ $schoolYear->id }}">
    <i class="fa-solid fa-toggle-on mt-1"></i> Active
</button>


<div class="modal fade" id="resetModal{{ $schoolYear->id }}" tabindex="-1" aria-labelledby="resetModalLabel{{ $schoolYear->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetModalLabel{{ $schoolYear->id }}">Confirm deactivation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               Are you sure you want to deactivate the year {{ \Carbon\Carbon::parse($schoolYear->date_start)->format('Y') }} - {{ \Carbon\Carbon::parse($schoolYear->date_end)->format('Y') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('school.year.deactive', ['id' => $schoolYear->id]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-secondary">Deactivate</button>
                </form>
            </div>
        </div>
    </div>
</div>