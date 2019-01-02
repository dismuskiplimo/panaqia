<div class="remodal" data-remodal-id="edit-work-experience-{{ $work_experience->id }}" role="dialog" aria-labelledby="Update Work Experience" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.work-experience.update', ['id' => $work_experience->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Update Work Experience</h2>
        
        <div class="row">
          
          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-1">From</label>
              <input type = "text" name="from" id="reference-1" required="" value="{{ $work_experience->from_date }}" />
            </div>
          </div>

          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-2">To</label>
              <input type = "text" name="to" id="reference-2" required="" value="{{ $work_experience->to_date }}" />
            </div>
          </div>

        </div>
        
        <div class="row">
          
          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-3">Company</label>
              <input type = "text" name="company" id="reference-3" required="" value="{{ $work_experience->company }}" />
            </div>
          </div>

          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-4">Position</label>
              <input type = "text" name="position" id="reference-4" required="" value="{{ $work_experience->position }}" />
            </div>
          </div>

        </div>
        
        <br>
        
        <button type="submit" class="btn green pull-right">Update Work Experience</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>