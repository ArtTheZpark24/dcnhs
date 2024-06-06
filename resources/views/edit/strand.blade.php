<!-- Button trigger modal -->
<a href="#edit{{ $data->id }}" class="btn" data-bs-toggle="modal" data-bs-target="#edit{{ $data->id }}" 
  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit {{$data->strands}}">
<button class="btn btn-warning btn-sm d-flex"><i class="fa-solid fa-pencil mt-1"></i> Edit</button>
</a>

  <!-- Modal -->
  <div class="modal fade" id="edit{{ $data->id }}" tabindex="-1" aria-labelledby="strandEditlabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="strandEditFormlabel">Edit Strand</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('strand.update', ['id'=>$data->id])}}" method="POST">
              @method('PUT')
              @csrf
                <label for="strand" class="col-form-label">Strand Name*</label>
                <input type="text" class="form-control input-student mb-3" name="strands" required value="{{ $data->strands }}">

                <label for="description" class="col-form-label">Description*</label>
                <input type="text" id="description" class="form-control input-student mb-3" name="description" required value="{{$data->description}}">

                
              
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
      </div>
    </div>
  </div>