<div class="remodal" data-remodal-id="edit-reference-{{ $reference->id }}" role="dialog" aria-labelledby="Edit Reference" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.reference.update', ['id' => $reference->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Update Reference</h2>
        
        <div class="row">
          
          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-1">Name*</label>
              <input type = "text" name="name" id="reference-1" required="" value="{{ $reference->name }}" />
            </div>
          </div>

          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-2">Phone*</label>
              <input type = "text" name="phone" id="reference-2" required="" value="{{ $reference->phone }}" />
            </div>
          </div>

        </div>
        
        <div class="row">
          
          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-3">Email</label>
              <input type = "email" name="email" id="reference-3" value="{{ $reference->email }}" />
            </div>
          </div>

          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-4">Postal Address</label>
              <input type = "text" name="address" id="reference-4" value="{{ $reference->address }}" />
            </div>
          </div>

        </div>
        
        <div class="row">
          
          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-5">Company</label>
              <input type = "text" name="company" id="reference-4" value="{{ $reference->company }}" />
            </div>
          </div>

          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-6">Position</label>
              <input type = "text" name="position" id="reference-4" value="{{ $reference->position }}" />
            </div>
          </div>
          
        </div>
        
        <br>
        
        <button type="submit" class="btn green pull-right">Update Reference</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>