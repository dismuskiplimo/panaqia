<div class="remodal" data-remodal-id="add-work-experience" role="dialog" aria-labelledby="Add Work Experience" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.work-experience.add') }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Add Work Experience</h2>
        
        <div class="row">
          
          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-1">From</label>
              <input type = "text" name="from" id="reference-1" required="" />
            </div>
          </div>

          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-2">To</label>
              <input type = "text" name="to" id="reference-2" required="" />
            </div>
          </div>

        </div>
        
        <div class="row">
          
          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-3">Company</label>
              <input type = "text" name="company" id="reference-3" required="" />
            </div>
          </div>

          <div class="col-sm-6">
            <div class="input-field">
              <label for="reference-4">Position</label>
              <input type = "text" name="position" id="reference-4" required="" />
            </div>
          </div>

        </div>
        
        <br>
        
        <button type="submit" class="btn green pull-right">Add Work Experience</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>