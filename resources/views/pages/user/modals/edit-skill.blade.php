<div class="remodal" data-remodal-id="edit-skill-{{ $skill->id }}" role="dialog" aria-labelledby="Edit Skill" aria-describedby="modal1Desc">
    
    <form action="{{ route('user.skill.update', ['id' => $skill->id]) }}" method="POST">
      @csrf

      <div class = "text-left">
        <h2 id="">Update Skill</h2>
        
        <div class="row">
          <div class="col-sm-12">
            <div class="input-field">
              <label for="skill-1">Skill</label>
              <input type = "text" name="skill" id="skill-1" required="" value="{{ $skill->skill }}" />
            </div>
          </div>
          
        </div>
        
        <br>
        
        <button type="submit" class="btn green pull-right">Update Skill</button>
        <button data-remodal-action="cancel" class="btn red">Cancel</button>
        
      </div>
      
    </form>
</div>