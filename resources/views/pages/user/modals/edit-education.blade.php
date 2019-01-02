<div class="remodal" data-remodal-id="edit-education-{{ $education->id }}" role="dialog" aria-labelledby="Add Education" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.education.update', ['id' => $education->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Edit Education</h2>
        
        <div class="row">
          <div class="col-sm-6">
            <div class="input-field">
              <label for="school">School*</label>
              <input type = "text" name="school" id="school" value="{{ $education->school }}" required="" />
            </div>
          </div>
          <div class="col-sm-6">
            <div class="input-field">
              <label for="level">Level*</label>
              <input type = "text" name="level" id="level" value="{{ $education->level }}"  required="" />
            </div> 
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="input-field">
              <label for="field_of_study">Field of Study*</label>
              <input type = "text" name="field_of_study" id="field_of_study" value="{{ $education->field_of_study }}"  required="" />
            </div>
          </div>
          <div class="col-sm-6">
            <div class="input-field">
              <label for="grade">Grade</label>
              <input type = "text" name="grade" value="{{ $education->grade }}"  id="grade" />
            </div> 
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="input-field">
              <label for="start_year">Start Year*</label>
              <input  type = "number" name="start_year" id="start_year" value="{{ $education->start_year }}"  required="" min="1900" max="{{ date('Y') }}" />
            </div>
          </div>
          <div class="col-sm-6">
            <div class="input-field">
              <label for="end_year">End Year*</label>
              <input type = "number" name="end_year" id="end_year" value="{{ $education->end_year }}"  required="" min="1900" max="{{ date('Y') }}" />
            </div> 
          </div>
        </div>
        
        <br>

        <button type="submit" class="btn green pull-right">UPDATE EDUCATION</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>