
<button type="button" class="btn btn-primary btn-sm d-flex gap-2 mt-2" style="height: 35px;" data-bs-toggle="modal" data-bs-target="#promoteModal{{ $student->id }}">
    <i class="fa-solid fa-arrow-up mt-1"></i> Promote
</button>


<div class="modal fade" id="promoteModal{{ $student->id }}" tabindex="-1" aria-labelledby="promoteModalLabel{{ $student->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="promoteModalLabel{{ $student->id }}">Confirm Promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to promote {{$student->lastname}}, {{$student->firstname}}?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('student.promote', ['id' => $student->id, 'section_id' => $student->section_id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">Promote</button>
                </form>
            </div>
        </div>
    </div>
</div>
